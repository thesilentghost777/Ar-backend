<?php

namespace App\Services\AutoEcole;

use App\Models\AutoEcoleUser;
use App\Models\Filleul;
use App\Models\ConfigPaiement;
use App\Models\AutoEcoleNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Kreait\Firebase\Factory;

class AuthService
{
    // =========================================================================
    // INSCRIPTION
    // =========================================================================

    public function inscription(array $data): array
    {
        Log::info('Début inscription', [
            'telephone'       => $data['telephone'] ?? 'non fourni',
            'email'           => $data['email'] ?? 'non fourni',
            'code_parrainage' => $data['code_parrainage'] ?? 'absent',
            'nom_prenom'      => trim(($data['nom'] ?? '') . ' ' . ($data['prenom'] ?? '')),
        ]);

        DB::beginTransaction();

        try {
            $codeParrainage = $this->genererCodeParrainage();

            $parrain = AutoEcoleUser::where('code_parrainage', $data['code_parrainage'])->first();

            if (!$parrain) {
                Log::warning('Code de parrainage invalide', ['code_saisi' => $data['code_parrainage']]);
                DB::rollBack();
                return ['success' => false, 'message' => 'Code de parrainage invalide.'];
            }

            $parrainId = $this->trouverEmplacementFilleul($parrain);

            $isEmail     = isset($data['email']) && !isset($data['telephone']);
            $authProvider = $isEmail ? 'email' : 'telephone';

            $user = AutoEcoleUser::create([
                'nom'                => $data['nom'],
                'prenom'             => $data['prenom'],
                'telephone'          => $data['telephone'] ?? null,
                'email'              => $data['email'] ?? null,
                'password'           => Hash::make($data['password']),
                'auth_provider'      => $authProvider,
                'date_naissance'     => $data['date_naissance'] ?? null,
                'type_permis'        => $data['type_permis'] ?? 'permis_b',
                'centre_examen_id'   => $data['centre_examen_id'] ?? null,
                'code_parrainage'    => $codeParrainage,
                'parrain_id'         => $parrainId,
                'profil_complet'     => true,
                // Téléphone : directement vérifié, pas besoin d'OTP
                'telephone_verified' => !$isEmail,
                // Email : nécessite vérification OTP
                'email_verified'     => false,
                'solde'              => 0,
                'validated'          => false,
                'cours_debloques'    => false,
            ]);

            Log::info('Utilisateur créé', [
                'user_id'       => $user->id,
                'auth_provider' => $authProvider,
                'parrain_id'    => $parrainId,
            ]);

            if ($parrainId) {
                Filleul::create([
                    'parrain_id' => $parrainId,
                    'filleul_id' => $user->id,
                ]);

                AutoEcoleNotification::envoyer(
                    $parrainId,
                    'Nouveau filleul !',
                    "{$user->prenom} {$user->nom} s'est inscrit avec votre code de parrainage.",
                    'parrainage'
                );
            }

            DB::commit();

            Log::info('Inscription terminée avec succès', ['user_id' => $user->id]);

            // ── Inscription par téléphone : on génère directement le token ──
            if (!$isEmail) {
                $token = $user->createToken('auto-ecole-token')->plainTextToken;

                return [
                    'success'         => true,
                    'message'         => 'Inscription réussie',
                    'user'            => $user->fresh()->load(['centreExamen', 'parrain']),
                    'token'           => $token,
                    'code_parrainage' => $codeParrainage,
                ];
            }

            // ── Inscription par email : envoi OTP mail ──
            $this->envoyerOtpEmail($user->email);

            return [
                'success'                  => true,
                'message'                  => 'Inscription réussie. Vérifiez votre boîte mail pour confirmer votre compte.',
                'user'                     => $user->fresh()->load(['centreExamen', 'parrain']),
                'needs_email_verification' => true,
                'email'                    => $user->email,
                'code_parrainage'          => $codeParrainage,
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Échec inscription', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);
            return ['success' => false, 'message' => 'Erreur lors de l\'inscription : ' . $e->getMessage()];
        }
    }

    // =========================================================================
    // CONNEXION CLASSIQUE (téléphone ou email)
    // =========================================================================

    public function connexion(?string $telephone, ?string $email, string $password): array
    {
        Log::debug('Service Auth - Tentative de connexion', [
            'telephone' => $telephone,
            'email'     => $email,
        ]);

        $user = $telephone
            ? AutoEcoleUser::where('telephone', $telephone)->first()
            : AutoEcoleUser::where('email', $email)->first();

        if (!$user) {
            Log::warning('Utilisateur non trouvé', ['telephone' => $telephone, 'email' => $email]);
            return ['success' => false, 'message' => 'Identifiants incorrects'];
        }

        // Téléphone : pas de vérification requise (vérifié à l'inscription)
        // Email : vérification OTP obligatoire avant connexion
        if ($user->auth_provider === 'email' && !$user->email_verified) {
            return [
                'success'                  => false,
                'message'                  => 'Email non vérifié. Vérifiez votre boîte mail.',
                'needs_email_verification' => true,
                'email'                    => $user->email,
            ];
        }

        if (!Hash::check($password, $user->password)) {
            Log::warning('Mot de passe incorrect', ['user_id' => $user->id]);
            return ['success' => false, 'message' => 'Identifiants incorrects'];
        }

        Log::info('Mot de passe vérifié', ['user_id' => $user->id]);

        try {
            $token = $user->createToken('auto-ecole-token')->plainTextToken;

            return [
                'success' => true,
                'message' => 'Connexion réussie',
                'user'    => $user->load(['session', 'centreExamen', 'parrain', 'lieuxPratique']),
                'token'   => $token,
            ];

        } catch (\Exception $e) {
            Log::error('Erreur création token', ['user_id' => $user->id, 'exception' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Erreur lors de la création de la session'];
        }
    }

    // =========================================================================
    // OTP EMAIL (remplace Twilio pour la vérification email)
    // =========================================================================

    /**
     * Génère un code OTP à 6 chiffres, le stocke en cache 10 min et l'envoie par mail.
     */
    public function envoyerOtpEmail(string $email): array
    {
        try {
            $code      = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $cacheKey  = 'otp_email_' . md5($email);

            // Stockage 10 minutes
            Cache::put($cacheKey, $code, now()->addMinutes(10));

            Mail::send([], [], function ($message) use ($email, $code) {
                $message
                    ->to($email)
                    ->subject('Votre code de vérification')
                    ->html(
                        '<div style="font-family:sans-serif;max-width:480px;margin:auto;padding:32px;border:1px solid #e2e8f0;border-radius:12px;">'
                        . '<h2 style="color:#1D4ED8;margin-bottom:8px;">Vérification de votre compte</h2>'
                        . '<p style="color:#64748B;">Utilisez ce code pour confirmer votre adresse e-mail. Il expire dans <strong>10 minutes</strong>.</p>'
                        . '<div style="font-size:36px;font-weight:800;letter-spacing:10px;color:#0F172A;text-align:center;padding:24px 0;">'
                        . $code
                        . '</div>'
                        . '<p style="color:#94A3B8;font-size:12px;">Si vous n\'avez pas créé de compte, ignorez cet email.</p>'
                        . '</div>'
                    );
            });

            Log::info('OTP email envoyé', ['email' => $email]);

            return ['success' => true, 'message' => 'Code OTP envoyé par email'];

        } catch (\Exception $e) {
            Log::error('Erreur envoi OTP email', ['message' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Impossible d\'envoyer le code OTP par email'];
        }
    }

    /**
     * Vérifie le code OTP email, marque l'email comme vérifié et retourne un token.
     */
    public function verifierOtpEmail(string $email, string $code): array
    {
        try {
            $cacheKey = 'otp_email_' . md5($email);
            $stored   = Cache::get($cacheKey);

            if (!$stored || $stored !== $code) {
                return ['success' => false, 'message' => 'Code OTP invalide ou expiré'];
            }

            // Invalider le code après usage
            Cache::forget($cacheKey);

            $user = AutoEcoleUser::where('email', $email)->first();

            if (!$user) {
                return ['success' => false, 'message' => 'Utilisateur introuvable'];
            }

            $user->email_verified    = true;
            $user->email_verified_at = now();
            $user->save();

            $token = $user->createToken('auto-ecole-token')->plainTextToken;

            Log::info('OTP email vérifié, token créé', ['user_id' => $user->id]);

            return [
                'success' => true,
                'message' => 'Email vérifié avec succès',
                'token'   => $token,
                'user'    => $user->fresh()->load(['session', 'centreExamen', 'parrain']),
            ];

        } catch (\Exception $e) {
            Log::error('Erreur vérif OTP email', ['message' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Erreur lors de la vérification'];
        }
    }

    // =========================================================================
    // SOCIAL LOGIN (Google / Apple via Firebase)
    // =========================================================================

    public function socialLogin(string $firebaseToken, string $provider): array
    {
        try {
            $firebaseUser = $this->verifierTokenFirebase($firebaseToken);

            if (!$firebaseUser) {
                return ['success' => false, 'message' => 'Token Firebase invalide'];
            }

            $firebaseUid = $firebaseUser['uid'];
            $email       = $firebaseUser['email'] ?? null;
            $nomComplet  = $firebaseUser['name'] ?? '';
            $prenom      = '';
            $nom         = $nomComplet;

            if ($nomComplet && str_contains($nomComplet, ' ')) {
                $parts  = explode(' ', $nomComplet, 2);
                $prenom = $parts[0];
                $nom    = $parts[1];
            }

            $user = AutoEcoleUser::where('firebase_uid', $firebaseUid)->first();

            if (!$user && $email) {
                $user = AutoEcoleUser::where('email', $email)->first();
                if ($user) {
                    $user->firebase_uid  = $firebaseUid;
                    $user->auth_provider = $provider;
                    $user->save();
                }
            }

            if (!$user) {
                $codeParrainage = $this->genererCodeParrainage();

                $user = AutoEcoleUser::create([
                    'nom'             => $nom    ?: 'À définir',
                    'prenom'          => $prenom ?: 'À définir',
                    'telephone'       => null,
                    'email'           => $email,
                    'password'        => Hash::make(Str::random(32)),
                    'auth_provider'   => $provider,
                    'firebase_uid'    => $firebaseUid,
                    'code_parrainage' => $codeParrainage,
                    'email_verified'  => true,
                    'profil_complet'  => false,
                    'solde'           => 0,
                    'validated'       => false,
                    'cours_debloques' => false,
                ]);

                Log::info('Compte social créé (profil incomplet)', [
                    'user_id'  => $user->id,
                    'provider' => $provider,
                ]);
            }

            $token = $user->createToken('auto-ecole-token')->plainTextToken;

            return [
                'success'          => true,
                'message'          => 'Connexion réussie',
                'token'            => $token,
                'user'             => $user->fresh()->load(['session', 'centreExamen', 'parrain']),
                'profil_complet'   => (bool) $user->profil_complet,
                'needs_completion' => !$user->profil_complet,
            ];

        } catch (\Exception $e) {
            Log::error('Erreur social login', ['message' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Erreur lors de la connexion sociale'];
        }
    }

    // =========================================================================
    // COMPLÉTION PROFIL SOCIAL
    // =========================================================================

    public function completerProfilSocial(AutoEcoleUser $user, array $data): array
    {
        DB::beginTransaction();

        try {
            $parrain = AutoEcoleUser::where('code_parrainage', $data['code_parrainage'])->first();

            if (!$parrain) {
                DB::rollBack();
                return ['success' => false, 'message' => 'Code de parrainage invalide'];
            }

            $parrainId = $this->trouverEmplacementFilleul($parrain);

            $user->nom              = $data['nom'];
            $user->prenom           = $data['prenom'];
            $user->telephone        = $data['telephone'];
            $user->type_permis      = $data['type_permis'];
            $user->centre_examen_id = $data['centre_examen_id'] ?? null;
            $user->date_naissance   = $data['date_naissance'] ?? null;
            $user->parrain_id       = $parrainId;
            $user->profil_complet   = true;
            $user->save();

            if ($parrainId) {
                Filleul::firstOrCreate([
                    'parrain_id' => $parrainId,
                    'filleul_id' => $user->id,
                ]);

                AutoEcoleNotification::envoyer(
                    $parrainId,
                    'Nouveau filleul !',
                    "{$user->prenom} {$user->nom} a rejoint avec votre code.",
                    'parrainage'
                );
            }

            DB::commit();

            Log::info('Profil social complété', ['user_id' => $user->id]);

            return [
                'success' => true,
                'message' => 'Profil complété avec succès',
                'user'    => $user->fresh()->load(['session', 'centreExamen', 'parrain']),
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur complétion profil', ['message' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    // =========================================================================
    // PROFIL & MISE À JOUR
    // =========================================================================

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

    // =========================================================================
    // MÉTHODES PRIVÉES
    // =========================================================================

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

    private function normaliserTelephone(string $telephone): string
    {
        $chiffres = preg_replace('/\D/', '', $telephone);

        if (strlen($chiffres) === 9) {
            return '+237' . $chiffres;
        }

        if (strlen($chiffres) === 12 && str_starts_with($chiffres, '237')) {
            return '+' . $chiffres;
        }

        return '+' . $chiffres;
    }

    private function verifierTokenFirebase(string $token): ?array
{
    try {
        $credentials = config('services.firebase.credentials');
        if (!file_exists($credentials) && !is_readable($credentials)) {
            Log::error('Fichier Firebase credentials introuvable ou illisible', ['path' => $credentials]);
            return null;
        }

        $factory = (new Factory)->withServiceAccount($credentials);
        $auth = $factory->createAuth();
        $verified = $auth->verifyIdToken($token);

        return [
            'uid'   => $verified->claims()->get('sub'),
            'email' => $verified->claims()->get('email'),
            'name'  => $verified->claims()->get('name'),
        ];
    } catch (\Exception $e) {
        Log::error('Erreur vérification token Firebase', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        return null;
    }
}
}