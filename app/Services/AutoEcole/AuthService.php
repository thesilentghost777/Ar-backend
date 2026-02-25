<?php

namespace App\Services\AutoEcole;

use App\Models\AutoEcoleUser;
use App\Models\Filleul;
use App\Models\ConfigPaiement;
use App\Models\AutoEcoleNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthService
{
    public function inscription(array $data): array
    {
        Log::info('Début inscription', [
            'telephone'       => $data['telephone'] ?? 'non fourni',
            'code_parrainage' => $data['code_parrainage'] ?? 'absent',
            'nom_prenom'      => trim(($data['nom'] ?? '') . ' ' . ($data['prenom'] ?? '')),
        ]);

        DB::beginTransaction();

        try {
            $codeParrainage = $this->genererCodeParrainage();
            Log::info('Code parrainage généré pour le nouvel utilisateur', ['code' => $codeParrainage]);

            // Le code est obligatoire — on cherche le parrain
            $parrain = AutoEcoleUser::where('code_parrainage', $data['code_parrainage'])->first();

            if (!$parrain) {
                Log::warning('Code de parrainage invalide', [
                    'code_saisi' => $data['code_parrainage'],
                    'telephone'  => $data['telephone'] ?? 'inconnu',
                ]);
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => 'Code de parrainage invalide.',
                ];
            }

            Log::info('Parrain trouvé', [
                'parrain_id'  => $parrain->id,
                'parrain_nom' => $parrain->nom . ' ' . $parrain->prenom,
            ]);

            $parrainId = $this->trouverEmplacementFilleul($parrain);

            Log::info('Emplacement filleul déterminé', [
                'parrain_id'         => $parrain->id,
                'filleul_placé_sous' => $parrainId,
            ]);

            $user = AutoEcoleUser::create([
                'nom'            => $data['nom'],
                'prenom'         => $data['prenom'],
                'telephone'      => $data['telephone'],
                'password'       => Hash::make($data['password']),
                'date_naissance' => $data['date_naissance'] ?? null,
                'type_permis'    => $data['type_permis'] ?? 'permis_b',
                'centre_examen_id' => $data['centre_examen_id'] ?? null,
                'code_parrainage'  => $codeParrainage,
                'parrain_id'       => $parrainId,
                'solde'            => 0,
                'validated'        => false,
                'cours_debloques'  => false,
            ]);

            Log::info('Utilisateur créé', [
                'user_id'       => $user->id,
                'telephone'     => $user->telephone,
                'parrain_id'    => $parrainId,
                'code_genere'   => $codeParrainage,
            ]);

            if ($parrainId) {
                Filleul::create([
                    'parrain_id'  => $parrainId,
                    'filleul_id'  => $user->id,
                ]);

                Log::info('Lien filleul enregistré', [
                    'parrain_id' => $parrainId,
                    'filleul_id' => $user->id,
                ]);

                AutoEcoleNotification::envoyer(
                    $parrainId,
                    'Nouveau filleul !',
                    "{$user->prenom} {$user->nom} s'est inscrit avec votre code de parrainage.",
                    'parrainage'
                );

                Log::info('Notification parrain envoyée', [
                    'parrain_id' => $parrainId,
                    'filleul_id' => $user->id,
                ]);
            }

            DB::commit();

            Log::info('Inscription terminée avec succès', ['user_id' => $user->id]);

            return [
                'success'         => true,
                'message'         => 'Inscription réussie',
                'user'            => $user->fresh()->load(['centreExamen', 'parrain']),
                'code_parrainage' => $codeParrainage,
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Échec inscription', [
                'telephone'       => $data['telephone'] ?? 'inconnu',
                'code_parrainage' => $data['code_parrainage'] ?? 'absent',
                'message'         => $e->getMessage(),
                'file'            => $e->getFile(),
                'line'            => $e->getLine(),
                'trace'           => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Erreur lors de l\'inscription : ' . $e->getMessage(),
            ];
        }
    }

    public function connexion(string $telephone, string $password): array
    {
        Log::debug('Service Auth - Recherche utilisateur', ['telephone' => $telephone]);

        $user = AutoEcoleUser::where('telephone', $telephone)->first();

        if (!$user) {
            Log::warning('✗ Utilisateur non trouvé', ['telephone' => $telephone]);
            return ['success' => false, 'message' => 'Identifiants incorrects'];
        }

        Log::debug('Utilisateur trouvé', [
            'user_id'          => $user->id,
            'telephone'        => $telephone,
            'has_password_hash' => !empty($user->password),
            'hash_starts_with'  => substr($user->password ?? '', 0, 7),
            'is_bcrypt_hash'    => str_starts_with($user->password ?? '', '$2y$'),
        ]);

        if (!Hash::check($password, $user->password)) {
            Log::warning('✗ Mot de passe incorrect', [
                'user_id'      => $user->id,
                'telephone'    => $telephone,
                'probable_cause' => str_starts_with($user->password ?? '', '$2y$')
                    ? 'Mot de passe erroné'
                    : 'ATTENTION: Mot de passe stocké en clair!',
            ]);
            return ['success' => false, 'message' => 'Identifiants incorrects'];
        }

        Log::info('✓ Mot de passe vérifié avec succès', ['user_id' => $user->id, 'telephone' => $telephone]);

        try {
            $token = $user->createToken('auto-ecole-token')->plainTextToken;

            Log::info('✓ Token créé avec succès', [
                'user_id'      => $user->id,
                'token_prefix' => substr($token, 0, 10) . '...',
            ]);

            return [
                'success' => true,
                'message' => 'Connexion réussie',
                'user'    => $user->load(['session', 'centreExamen', 'parrain', 'lieuxPratique']),
                'token'   => $token,
            ];

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du token', [
                'user_id'   => $user->id,
                'telephone' => $telephone,
                'exception' => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
            ]);

            return ['success' => false, 'message' => 'Erreur lors de la création de la session'];
        }
    }

    public function deconnexion(AutoEcoleUser $user): array
    {
        $user->tokens()->delete();
        return ['success' => true, 'message' => 'Déconnexion réussie'];
    }

    public function profil(AutoEcoleUser $user): array
    {
        return [
            'success' => true,
            'user'    => $user->load(['session', 'centreExamen', 'parrain', 'filleuls', 'lieuxPratique']),
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

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if (isset($data['lieux_pratique']) && is_array($data['lieux_pratique'])) {
            $user->lieuxPratique()->sync($data['lieux_pratique']);
        }

        $user->save();

        return [
            'success' => true,
            'message' => 'Profil mis à jour',
            'user'    => $user->fresh()->load(['session', 'centreExamen', 'parrain', 'lieuxPratique']),
        ];
    }

    public function reinitialiserMotDePasse(string $telephone, string $nouveauPassword): array
    {
        $user = AutoEcoleUser::where('telephone', $telephone)->first();

        if (!$user) {
            return ['success' => false, 'message' => 'Utilisateur non trouvé'];
        }

        $user->password = Hash::make($nouveauPassword);
        $user->save();

        return ['success' => true, 'message' => 'Mot de passe réinitialisé avec succès'];
    }

    public function getCodeParrainageDefaut(): array
    {
        $config = ConfigPaiement::getConfig();
        return [
            'success'         => true,
            'code_parrainage' => $config->code_parrainage_defaut ?? null,
        ];
    }

    // -------------------------------------------------------------------------
    // Méthodes privées
    // -------------------------------------------------------------------------

    private function genererCodeParrainage(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (AutoEcoleUser::where('code_parrainage', $code)->exists());

        return $code;
    }

    private function trouverEmplacementFilleul(AutoEcoleUser $parrain): ?int
    {
        $nbFilleuls = Filleul::where('parrain_id', $parrain->id)->count();

        if ($nbFilleuls < 3) {
            return $parrain->id;
        }

        // Recherche en profondeur (DFS) pour placer sous un filleul existant
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
}