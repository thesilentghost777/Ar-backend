<?php

namespace App\Services\AutoEcole;

use App\Models\AutoEcoleUser;
use App\Models\Filleul;
use App\Models\ConfigPaiement;
use App\Models\AutoEcoleNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthService
{
    public function inscription(array $data): array
    {
        DB::beginTransaction();

        try {
            // Générer un code de parrainage unique
            $codeParrainage = $this->genererCodeParrainage();

            // Rechercher le parrain par code
            $parrainId = null;
            $codeParrainageUtilise = false;

            if (!empty($data['code_parrainage'])) {
                $parrain = AutoEcoleUser::where('code_parrainage', $data['code_parrainage'])->first();
                $codeParrainageUtilise = true;

                if ($parrain) {
                    // Trouver l'emplacement dans l'arbre (DFS)
                    $parrainId = $this->trouverEmplacementFilleul($parrain);
                }
            }

            // Si pas de parrain trouvé, utiliser le code par défaut
            if (!$parrainId && !$codeParrainageUtilise) {
                $config = ConfigPaiement::getConfig();
                if ($config && $config->code_parrainage_defaut) {
                    $parrainDefaut = AutoEcoleUser::where('code_parrainage', $config->code_parrainage_defaut)->first();
                    if ($parrainDefaut) {
                        $parrainId = $this->trouverEmplacementFilleul($parrainDefaut);
                    }
                }
            }

            // Créer l'utilisateur
            $user = AutoEcoleUser::create([
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'telephone' => $data['telephone'],
                'password' => Hash::make($data['password']),
                'date_naissance' => $data['date_naissance'] ?? null,
                'quartier' => $data['quartier'] ?? null,
                'type_permis' => $data['type_permis'] ?? 'permis_b',
                'type_cours' => $data['type_cours'] ?? 'en_ligne',
                'vague' => $data['vague'] ?? '1',
                'session_id' => $data['session_id'] ?? null,
                'centre_examen_id' => $data['centre_examen_id'] ?? null,
                'code_parrainage' => $codeParrainage,
                'parrain_id' => $parrainId,
                'niveau_parrainage' => -1,
                'solde' => 0,
                'validated' => false,
                'cours_debloques' => false
            ]);

            // Enregistrer la relation filleul
            if ($parrainId) {
                Filleul::create([
                    'parrain_id' => $parrainId,
                    'filleul_id' => $user->id,
                    'niveau_parrain_lors_ajout' => AutoEcoleUser::find($parrainId)->niveau_parrainage ?? -1
                ]);

                // Vérifier et mettre à jour le niveau du parrain
                $this->verifierNiveauParrain($parrainId);

                // Notification au parrain
                AutoEcoleNotification::envoyer(
                    $parrainId,
                    'Nouveau filleul!',
                    "{$user->prenom} {$user->nom} s'est inscrit avec votre code de parrainage.",
                    'parrainage'
                );
            }

            // Attacher les lieux de pratique
            if (!empty($data['lieux_pratique']) && is_array($data['lieux_pratique'])) {
                $user->lieuxPratique()->attach($data['lieux_pratique']);
            }

            // Notification de bienvenue
            AutoEcoleNotification::envoyer(
                $user->id,
                'Bienvenue chez Ange Raphael!',
                'Votre inscription a été effectuée avec succès. Rechargez votre compte pour débloquer les cours.',
                'info'
            );

            DB::commit();

            return [
                'success' => true,
                'message' => 'Inscription réussie',
                'user' => $user->fresh()->load(['session', 'centreExamen', 'lieuxPratique', 'parrain']),
                'code_parrainage' => $codeParrainage
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Erreur lors de l\'inscription: ' . $e->getMessage()
            ];
        }
    }

    public function connexion(string $telephone, string $password): array
    {
        $user = AutoEcoleUser::where('telephone', $telephone)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return [
                'success' => false,
                'message' => 'Identifiants incorrects'
            ];
        }

        // Créer le token
        $token = $user->createToken('auto-ecole-token')->plainTextToken;

        return [
            'success' => true,
            'message' => 'Connexion réussie',
            'user' => $user->load(['session', 'centreExamen', 'parrain', 'lieuxPratique']),
            'token' => $token
        ];
    }

    public function deconnexion(AutoEcoleUser $user): array
    {
        $user->tokens()->delete();

        return [
            'success' => true,
            'message' => 'Déconnexion réussie'
        ];
    }

    public function profil(AutoEcoleUser $user): array
    {
        return [
            'success' => true,
            'user' => $user->load([
                'session',
                'centreExamen',
                'parrain',
                'filleuls',
                'lieuxPratique'
            ])
        ];
    }

    public function mettreAJourProfil(AutoEcoleUser $user, array $data): array
    {
        $champsModifiables = ['nom', 'prenom', 'telephone', 'quartier', 'type_cours'];

        foreach ($champsModifiables as $champ) {
            if (isset($data[$champ])) {
                $user->{$champ} = $data[$champ];
            }
        }

        if (isset($data['password']) && !empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        // Mettre à jour les lieux de pratique
        if (isset($data['lieux_pratique']) && is_array($data['lieux_pratique'])) {
            $user->lieuxPratique()->sync($data['lieux_pratique']);
        }

        $user->save();

        return [
            'success' => true,
            'message' => 'Profil mis à jour',
            'user' => $user->fresh()->load(['session', 'centreExamen', 'parrain', 'lieuxPratique'])
        ];
    }

    public function reinitialiserMotDePasse(string $telephone, string $nouveauPassword): array
    {
        $user = AutoEcoleUser::where('telephone', $telephone)->first();

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ];
        }

        $user->password = Hash::make($nouveauPassword);
        $user->save();

        return [
            'success' => true,
            'message' => 'Mot de passe réinitialisé avec succès'
        ];
    }

    public function getCodeParrainageDefaut(): array
    {
        $config = ConfigPaiement::getConfig();

        return [
            'success' => true,
            'code_parrainage' => $config->code_parrainage_defaut ?? null
        ];
    }

    private function genererCodeParrainage(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (AutoEcoleUser::where('code_parrainage', $code)->exists());

        return $code;
    }

    private function trouverEmplacementFilleul(AutoEcoleUser $parrain): ?int
    {
        // Si le parrain a moins de 3 filleuls directs
        $nbFilleuls = Filleul::where('parrain_id', $parrain->id)->count();

        if ($nbFilleuls < 3) {
            return $parrain->id;
        }

        // Recherche en profondeur (DFS)
        $filleuls = Filleul::where('parrain_id', $parrain->id)
            ->orderBy('created_at')
            ->get();

        foreach ($filleuls as $filleul) {
            $sousParrain = AutoEcoleUser::find($filleul->filleul_id);
            if ($sousParrain) {
                $emplacement = $this->trouverEmplacementFilleul($sousParrain);
                if ($emplacement) {
                    return $emplacement;
                }
            }
        }

        return null;
    }

    private function verifierNiveauParrain(int $parrainId): void
    {
        $parrain = AutoEcoleUser::find($parrainId);
        if (!$parrain) return;

        $nbFilleuls = Filleul::where('parrain_id', $parrainId)->count();
        $ancienNiveau = $parrain->niveau_parrainage;

        // Niveau 0 : 3 filleuls inscrits
        if ($nbFilleuls >= 3 && $ancienNiveau < 0) {
            $parrain->niveau_parrainage = 0;
            $parrain->status_frais_formation = 'dispense';
            $parrain->description_paiement_formation = 'Dispensé - Niveau 0 atteint (3 filleuls inscrits)';
            $parrain->save();

            AutoEcoleNotification::envoyer(
                $parrainId,
                'Félicitations! Niveau 0 atteint!',
                'Vous avez 3 filleuls inscrits. Les frais de formation (40 000 FCFA) sont maintenant dispensés!',
                'parrainage'
            );
        }
    }

    public function verifierEtMettreAJourNiveauApresDepot(int $parrainId): void
    {
        $parrain = AutoEcoleUser::find($parrainId);
        if (!$parrain) return;

        $filleuls = Filleul::where('parrain_id', $parrainId)->get();
        $filleulsAvecDepot = 0;
        $filleulsNiveau1 = 0;
        $filleulsNiveau2 = 0;

        foreach ($filleuls as $f) {
            $filleul = AutoEcoleUser::find($f->filleul_id);
            if ($filleul) {
                if ($filleul->premier_depot_at) {
                    $filleulsAvecDepot++;
                }
                if ($filleul->niveau_parrainage >= 1) {
                    $filleulsNiveau1++;
                }
                if ($filleul->niveau_parrainage >= 2) {
                    $filleulsNiveau2++;
                }
            }
        }

        $ancienNiveau = $parrain->niveau_parrainage;

        // Niveau 1 : 3 filleuls ayant fait un dépôt
        if ($filleulsAvecDepot >= 3 && $ancienNiveau < 1) {
            $parrain->niveau_parrainage = 1;
            $parrain->status_frais_inscription = 'dispense';
            $parrain->description_paiement_inscription = 'Dispensé - Niveau 1 atteint (3 filleuls avec dépôt)';
            $parrain->save();

            AutoEcoleNotification::envoyer(
                $parrainId,
                'Félicitations! Niveau 1 atteint!',
                'Vos 3 filleuls ont fait un dépôt. Les frais d\'inscription (10 000 FCFA) sont maintenant dispensés!',
                'parrainage'
            );
        }

        // Niveau 2 : 3 filleuls au niveau 1+
        if ($filleulsNiveau1 >= 3 && $ancienNiveau < 2) {
            $parrain->niveau_parrainage = 2;
            $parrain->status_examen_blanc = 'dispense';
            $parrain->description_paiement_examen_blanc = 'Dispensé - Niveau 2 atteint (3 filleuls niveau 1+)';
            $parrain->save();

            AutoEcoleNotification::envoyer(
                $parrainId,
                'Félicitations! Niveau 2 atteint!',
                'Vos 3 filleuls sont au niveau 1. Les frais d\'examen blanc (12 500 FCFA) sont maintenant dispensés!',
                'parrainage'
            );
        }

        // Niveau 3 : 3 filleuls au niveau 2+
        if ($filleulsNiveau2 >= 3 && $ancienNiveau < 3) {
            $parrain->niveau_parrainage = 3;
            $parrain->status_frais_examen = 'dispense';
            $parrain->description_paiement_examen = 'Dispensé - Niveau 3 atteint (3 filleuls niveau 2+)';
            $parrain->save();

            AutoEcoleNotification::envoyer(
                $parrainId,
                'Félicitations! Niveau 3 atteint!',
                'Vos 3 filleuls sont au niveau 2. Tous vos frais sont maintenant dispensés! Formation 100% gratuite!',
                'parrainage'
            );
        }

        // Propager vers le parrain du parrain
        if ($parrain->parrain_id && $parrain->niveau_parrainage > $ancienNiveau) {
            $this->verifierEtMettreAJourNiveauApresDepot($parrain->parrain_id);
        }
    }
}
