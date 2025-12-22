<?php

namespace App\Services\AutoEcole;

use App\Models\AutoEcoleUser;
use App\Models\AutoEcolePaiement;
use App\Models\CodeCaisse;
use App\Models\ConfigPaiement;
use App\Models\AutoEcoleNotification;
use Illuminate\Support\Facades\DB;

class PaiementService
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function deposerViaMobile(AutoEcoleUser $user, float $montant, string $numeroPayeur): array
    {
        $config = ConfigPaiement::getConfig();

        if ($montant < $config->depot_minimum) {
            return [
                'success' => false,
                'message' => "Le dépôt minimum est de {$config->depot_minimum} FCFA"
            ];
        }

        try {
            DB::beginTransaction();

            // Simulateur de paiement mobile (à remplacer par vraie API)
            $paiementReussi = $this->simulerPaiementMobile($montant, $numeroPayeur);

            if (!$paiementReussi) {
                return [
                    'success' => false,
                    'message' => 'Échec du paiement mobile'
                ];
            }

            $soldeAvant = $user->solde;
            $soldeApres = $soldeAvant + $montant;

            // Créer le paiement
            $paiement = AutoEcolePaiement::create([
                'user_id' => $user->id,
                'type' => 'depot',
                'methode' => 'mobile_money',
                'montant' => $montant,
                'solde_avant' => $soldeAvant,
                'solde_apres' => $soldeApres,
                'reference' => AutoEcolePaiement::genererReference(),
                'description' => "Dépôt via Mobile Money - {$numeroPayeur}",
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

            // Si premier dépôt, notifier le parrain et vérifier les niveaux
            if ($estPremierDepot && $user->parrain_id) {
                $this->authService->verifierEtMettreAJourNiveauApresDepot($user->parrain_id);

                AutoEcoleNotification::envoyer(
                    $user->parrain_id,
                    'Votre filleul a fait son premier dépôt!',
                    "{$user->prenom} {$user->nom} a effectué son premier dépôt.",
                    'parrainage'
                );
            }

            // Notification
            AutoEcoleNotification::envoyer(
                $user->id,
                'Dépôt effectué',
                "Votre dépôt de {$montant} FCFA a été crédité sur votre compte. Nouveau solde: {$soldeApres} FCFA",
                'paiement'
            );

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

            // Notification
            AutoEcoleNotification::envoyer(
                $user->id,
                'Dépôt effectué',
                "Votre dépôt de {$montant} FCFA (code caisse) a été crédité. Nouveau solde: {$soldeApres} FCFA",
                'paiement'
            );

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

            // Notifications
            AutoEcoleNotification::envoyer(
                $expediteur->id,
                'Transfert effectué',
                "Vous avez transféré {$montant} FCFA à {$destinataire->prenom}. Nouveau solde: {$soldeApresExp} FCFA",
                'paiement'
            );

            AutoEcoleNotification::envoyer(
                $destinataire->id,
                'Transfert reçu',
                "Vous avez reçu {$montant} FCFA de {$expediteur->prenom}. Nouveau solde: {$soldeApresDest} FCFA",
                'paiement'
            );

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

            // Notification
            AutoEcoleNotification::envoyer(
                $user->id,
                'Paiement effectué',
                "{$frais['label']} ({$montant} FCFA) payés avec succès. Nouveau solde: {$soldeApres} FCFA",
                'paiement'
            );

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

    private function simulerPaiementMobile(float $montant, string $numero): bool
    {
        // Simulateur - Toujours retourne true
        // À remplacer par l'intégration avec une vraie API de paiement
        return true;
    }
}
