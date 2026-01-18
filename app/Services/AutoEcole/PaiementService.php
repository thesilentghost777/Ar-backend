<?php
namespace App\Services\AutoEcole;

use App\Models\AutoEcoleUser;
use App\Models\AutoEcolePaiement;
use App\Models\CodeCaisse;
use App\Models\ConfigPaiement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaiementService
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        Log::info('PaiementService initialisé');
    }

    public function deposerViaMobile(AutoEcoleUser $user, float $montant, string $numeroPayeur): array
{
    Log::info("Tentative de dépôt pour l'utilisateur {$user->id}, montant: {$montant}, payeur: {$numeroPayeur}");
    
    $config = ConfigPaiement::getConfig();
    
    if ($montant < $config->depot_minimum) {
        Log::warning("Montant inférieur au dépôt minimum ({$config->depot_minimum}) pour l'utilisateur {$user->id}");
        return [
            'success' => false,
            'message' => "Le dépôt minimum est de {$config->depot_minimum} FCFA"
        ];
    }
    
    try {
        DB::beginTransaction();
        Log::info("Transaction DB démarrée pour le dépôt de l'utilisateur {$user->id}");
        
        // Annuler les anciens paiements en attente
        $paiementsAnnules = AutoEcolePaiement::where('user_id', $user->id)
            ->where('type', 'depot')
            ->where('methode', 'mobile_money')
            ->where('status', 'en_attente')
            ->update(['status' => 'annule']);
        
        Log::info("Anciens paiements en attente annulés: {$paiementsAnnules}");
        
        $soldeAvant = $user->solde;
        
        // Créer un paiement en attente
        $paiement = AutoEcolePaiement::create([
            'user_id' => $user->id,
            'type' => 'depot',
            'methode' => 'mobile_money',
            'montant' => $montant,
            'solde_avant' => $soldeAvant,
            'solde_apres' => $soldeAvant,
            'reference' => AutoEcolePaiement::genererReference(),
            'description' => "Dépôt via Mobile Money - {$numeroPayeur}",
            'status' => 'en_attente'
        ]);
        
        Log::info("Paiement en attente créé: ID {$paiement->id}, reference {$paiement->reference}");
        
        // Appel à l'API Money Fusion
        $apiUrl = 'https://www.pay.moneyfusion.net/ange_raphael/4a7599fc1f39f73d/pay/';
        $paymentData = [
            'totalPrice' => $montant,
            'article' => [['depot' => $montant]],
            'personal_Info' => [['userId' => $user->id]],
            'numeroSend' => $numeroPayeur,
            'nomclient' => $user->nomComplet,
            'return_url' => 'https://ange-raphael.supahuman.site/api/end_payment',
            'webhook_url' => 'https://ange-raphael.supahuman.site/api/webhook/payment'
        ];
        
        Log::info('Appel API Money Fusion', ['url' => $apiUrl, 'data' => $paymentData]);
        
        $response = Http::post($apiUrl, $paymentData);
        
        Log::info('Réponse API Money Fusion', ['response' => $response->json()]);
        
        if ($response->failed() || !$response['statut']) {
            $paiement->status = 'annule';
            $paiement->save();
            Log::error('Échec de l\'initialisation du paiement', ['response' => $response->json()]);
            throw new \Exception($response['message'] ?? 'Échec de l\'initialisation du paiement');
        }
        
        $paiement->token_pay = $response['token'];
        $paiement->save();
        
        DB::commit();
        Log::info("Transaction DB commitée pour le paiement {$paiement->id}");
        
        return [
            'success' => true,
            'message' => 'Paiement initié, veuillez procéder au paiement',
            'url' => $response['url']
        ];
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("Erreur lors de l'initialisation du dépôt pour l'utilisateur {$user->id}", [
            'error' => $e->getMessage()
        ]);
        
        return [
            'success' => false,
            'message' => 'Erreur lors de l\'initialisation du dépôt: ' . $e->getMessage()
        ];
    }
}

    public function deposerViaCodeCaisse(AutoEcoleUser $user, string $code): array
    {
        $codeCaisse = CodeCaisse::where('code', $code)->first();
        if (!$codeCaisse) {
            return [
                'success' => false,
                'message' => 'Code caisse invalide'
            ];
        }
        if (!$codeCaisse->estValide()) {
            return [
                'success' => false,
                'message' => 'Ce code a déjà été utilisé ou a expiré'
            ];
        }
        // Vérifier si le code est destiné à cet utilisateur
        if ($codeCaisse->user_id && $codeCaisse->user_id !== $user->id) {
            return [
                'success' => false,
                'message' => 'Ce code n\'est pas valide pour votre compte'
            ];
        }
        try {
            DB::beginTransaction();
            $montant = $codeCaisse->montant;
            $soldeAvant = $user->solde;
            $soldeApres = $soldeAvant + $montant;
            // Marquer le code comme utilisé
            $codeCaisse->utilise = true;
            $codeCaisse->utilise_at = now();
            $codeCaisse->user_id = $user->id;
            $codeCaisse->save();
            // Créer le paiement
            $paiement = AutoEcolePaiement::create([
                'user_id' => $user->id,
                'type' => 'depot',
                'methode' => 'code_caisse',
                'montant' => $montant,
                'solde_avant' => $soldeAvant,
                'solde_apres' => $soldeApres,
                'reference' => AutoEcolePaiement::genererReference(),
                'description' => "Dépôt via Code Caisse - {$code}",
                'status' => 'valide'
            ]);
            // Mettre à jour le solde
            $user->solde = $soldeApres;
            // Premier dépôt?
            $estPremierDepot = is_null($user->premier_depot_at);
            if ($estPremierDepot) {
                $user->premier_depot_at = now();
                $user->cours_debloques = true;
            }
            $user->save();
            // Si premier dépôt, vérifier les niveaux du parrain
            if ($estPremierDepot && $user->parrain_id) {
                $this->authService->verifierEtMettreAJourNiveauApresDepot($user->parrain_id);
            }
           
            DB::commit();
            return [
                'success' => true,
                'message' => 'Dépôt effectué avec succès',
                'paiement' => $paiement,
                'nouveau_solde' => $soldeApres,
                'cours_debloques' => $user->cours_debloques
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Erreur lors du dépôt: ' . $e->getMessage()
            ];
        }
    }
    public function transferer(AutoEcoleUser $expediteur, string $telephoneDestinataire, float $montant): array
    {
        if ($montant <= 0) {
            return [
                'success' => false,
                'message' => 'Le montant doit être supérieur à 0'
            ];
        }
        if ($expediteur->solde < $montant) {
            return [
                'success' => false,
                'message' => 'Solde insuffisant'
            ];
        }
        $destinataire = AutoEcoleUser::where('telephone', $telephoneDestinataire)->first();
        if (!$destinataire) {
            return [
                'success' => false,
                'message' => 'Destinataire non trouvé'
            ];
        }
        if ($destinataire->id === $expediteur->id) {
            return [
                'success' => false,
                'message' => 'Vous ne pouvez pas vous transférer à vous-même'
            ];
        }
        try {
            DB::beginTransaction();
            $reference = AutoEcolePaiement::genererReference();
            // Débiter l'expéditeur
            $soldeAvantExp = $expediteur->solde;
            $soldeApresExp = $soldeAvantExp - $montant;
            AutoEcolePaiement::create([
                'user_id' => $expediteur->id,
                'type' => 'transfert_sortant',
                'methode' => 'transfert',
                'montant' => $montant,
                'solde_avant' => $soldeAvantExp,
                'solde_apres' => $soldeApresExp,
                'reference' => $reference,
                'description' => "Transfert vers {$destinataire->prenom} {$destinataire->nom}",
                'status' => 'valide',
                'destinataire_id' => $destinataire->id
            ]);
            $expediteur->solde = $soldeApresExp;
            $expediteur->save();
            // Créditer le destinataire
            $soldeAvantDest = $destinataire->solde;
            $soldeApresDest = $soldeAvantDest + $montant;
            AutoEcolePaiement::create([
                'user_id' => $destinataire->id,
                'type' => 'transfert_entrant',
                'methode' => 'transfert',
                'montant' => $montant,
                'solde_avant' => $soldeAvantDest,
                'solde_apres' => $soldeApresDest,
                'reference' => $reference . '-R',
                'description' => "Transfert reçu de {$expediteur->prenom} {$expediteur->nom}",
                'status' => 'valide',
                'destinataire_id' => $expediteur->id
            ]);
            $destinataire->solde = $soldeApresDest;
            $destinataire->save();
         
            DB::commit();
            return [
                'success' => true,
                'message' => 'Transfert effectué avec succès',
                'nouveau_solde' => $soldeApresExp,
                'destinataire' => [
                    'nom' => $destinataire->nom,
                    'prenom' => $destinataire->prenom
                ]
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Erreur lors du transfert: ' . $e->getMessage()
            ];
        }
    }
    public function rechercherDestinataire(string $telephone): array
    {
        $user = AutoEcoleUser::where('telephone', $telephone)->first();
        if (!$user) {
            return [
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ];
        }
        return [
            'success' => true,
            'destinataire' => [
                'id' => $user->id,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'telephone' => $user->telephone
            ]
        ];
    }
    public function payerFrais(AutoEcoleUser $user, string $typeFrais): array
    {
        $config = ConfigPaiement::getConfig();
        $fraisMapping = [
            'formation' => [
                'montant' => $config->frais_formation,
                'status_field' => 'status_frais_formation',
                'description_field' => 'description_paiement_formation',
                'label' => 'Frais de formation'
            ],
            'inscription' => [
                'montant' => $config->frais_inscription,
                'status_field' => 'status_frais_inscription',
                'description_field' => 'description_paiement_inscription',
                'label' => 'Frais d\'inscription'
            ],
            'examen_blanc' => [
                'montant' => $config->frais_examen_blanc,
                'status_field' => 'status_examen_blanc',
                'description_field' => 'description_paiement_examen_blanc',
                'label' => 'Frais d\'examen blanc'
            ],
            'examen' => [
                'montant' => $config->frais_examen,
                'status_field' => 'status_frais_examen',
                'description_field' => 'description_paiement_examen',
                'label' => 'Frais d\'examen'
            ]
        ];
        if (!isset($fraisMapping[$typeFrais])) {
            return [
                'success' => false,
                'message' => 'Type de frais invalide'
            ];
        }
        $frais = $fraisMapping[$typeFrais];
        $statusField = $frais['status_field'];
        $descriptionField = $frais['description_field'];
        // Vérifier si déjà payé ou dispensé
        if ($user->{$statusField} !== 'non_paye') {
            return [
                'success' => false,
                'message' => 'Ces frais sont déjà payés ou dispensés'
            ];
        }
        $montant = $frais['montant'];
        if ($user->solde < $montant) {
            return [
                'success' => false,
                'message' => "Solde insuffisant. Il vous manque " . ($montant - $user->solde) . " FCFA"
            ];
        }
        try {
            DB::beginTransaction();
            $soldeAvant = $user->solde;
            $soldeApres = $soldeAvant - $montant;
            // Créer le paiement
            AutoEcolePaiement::create([
                'user_id' => $user->id,
                'type' => 'paiement_frais',
                'methode' => 'systeme',
                'montant' => $montant,
                'solde_avant' => $soldeAvant,
                'solde_apres' => $soldeApres,
                'reference' => AutoEcolePaiement::genererReference(),
                'description' => $frais['label'],
                'status' => 'valide',
                'frais_type' => $typeFrais
            ]);
            // Mettre à jour l'utilisateur
            $user->solde = $soldeApres;
            $user->{$statusField} = 'paye';
            $user->{$descriptionField} = 'Payé le ' . now()->format('d/m/Y à H:i');
            $user->save();
          
            DB::commit();
            return [
                'success' => true,
                'message' => 'Paiement effectué avec succès',
                'nouveau_solde' => $soldeApres,
                'frais_payes' => $frais['label']
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Erreur lors du paiement: ' . $e->getMessage()
            ];
        }
    }
    public function getStatusFrais(AutoEcoleUser $user): array
    {
        $config = ConfigPaiement::getConfig();
        return [
            'success' => true,
            'frais' => [
                'formation' => [
                    'montant' => $config->frais_formation,
                    'status' => $user->status_frais_formation,
                    'description' => $user->description_paiement_formation,
                    'label' => 'Frais de formation'
                ],
                'inscription' => [
                    'montant' => $config->frais_inscription,
                    'status' => $user->status_frais_inscription,
                    'description' => $user->description_paiement_inscription,
                    'label' => 'Frais d\'inscription'
                ],
                'examen_blanc' => [
                    'montant' => $config->frais_examen_blanc,
                    'status' => $user->status_examen_blanc,
                    'description' => $user->description_paiement_examen_blanc,
                    'label' => 'Frais d\'examen blanc'
                ],
                'examen' => [
                    'montant' => $config->frais_examen,
                    'status' => $user->status_frais_examen,
                    'description' => $user->description_paiement_examen,
                    'label' => 'Frais d\'examen'
                ]
            ],
            'solde' => $user->solde
        ];
    }
    public function getHistorique(AutoEcoleUser $user, int $limit = 20): array
    {
        $paiements = AutoEcolePaiement::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
        return [
            'success' => true,
            'paiements' => $paiements,
            'solde_actuel' => $user->solde
        ];
    }

     public function handleWebhook(array $data): array
    {
        Log::info('Webhook reçu', ['data' => $data]);

        $tokenPay = $data['tokenPay'] ?? null;
        $event = $data['event'] ?? null;

        if (!$tokenPay || !$event) {
            Log::warning('Webhook invalide: tokenPay ou event manquant');
            return ['success' => false, 'message' => 'Données webhook invalides'];
        }

        $paiement = AutoEcolePaiement::where('token_pay', $tokenPay)
            ->where('status', 'en_attente')
            ->first();

        if (!$paiement) {
            Log::warning("Paiement non trouvé ou déjà traité pour tokenPay {$tokenPay}");
            return ['success' => false, 'message' => 'Paiement non trouvé ou déjà traité'];
        }

        $user = $paiement->user;

        try {
            DB::beginTransaction();
            Log::info("Transaction DB démarrée pour le webhook du paiement {$paiement->id}");

            if ($event === 'payin.session.completed') {
                

                $soldeApres = $paiement->solde_avant + $paiement->montant;
                $paiement->status = 'valide';
                $paiement->solde_apres = $soldeApres;
                $paiement->transaction_externe = $data['numeroTransaction'] ?? null;
                $paiement->methode = $data['moyen'] ?? 'mobile_money';
                $paiement->save();
                Log::info("Paiement validé: ID {$paiement->id}, solde après: {$soldeApres}");

                $user->solde = $soldeApres;
                $estPremierDepot = is_null($user->premier_depot_at);
                if ($estPremierDepot) {
                    $user->premier_depot_at = now();
                    $user->cours_debloques = true;
                    Log::info("Premier dépôt de l'utilisateur {$user->id}");
                }
                $user->save();

                if ($estPremierDepot && $user->parrain_id) {
                    $this->authService->verifierEtMettreAJourNiveauApresDepot($user->parrain_id);
                    
                    Log::info("Notification envoyée au parrain {$user->parrain_id}");
                }

               
                Log::info("Notification envoyée à l'utilisateur {$user->id}");
            } elseif ($event === 'payin.session.cancelled') {
                $paiement->status = 'annule';
                $paiement->save();
                Log::info("Paiement annulé via webhook: ID {$paiement->id}");
            }

            DB::commit();
            Log::info("Transaction DB commitée pour le webhook du paiement {$paiement->id}");
            return ['success' => true];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur lors du traitement du webhook pour le paiement {$paiement->id}", [
                'error' => $e->getMessage()
            ]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}