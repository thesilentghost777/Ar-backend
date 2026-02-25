<?php

namespace App\Services\AutoEcole;

use App\Models\AutoEcoleUser;
use App\Models\Filleul;
use App\Models\ConfigPaiement;
use App\Models\AutoEcoleNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ParrainageService
{
    // Nombre de filleuls avec dépôt requis pour gagner la prime
    const FILLEULS_REQUIS = 3;
    // Montant de la prime en FCFA
    const PRIME_MONTANT = 5000;

    public function getInfoParrainage(AutoEcoleUser $user): array
    {
        $filleuls = Filleul::where('parrain_id', $user->id)
            ->with('filleul')
            ->get();

        $filleulsAvecDepot = $filleuls->filter(fn($f) => $f->filleul?->premier_depot_at !== null)->count();

        $filleulsInfo = $filleuls->map(function ($f) {
            return [
                'id'               => $f->filleul->id,
                'nom'              => $f->filleul->nom,
                'prenom'           => $f->filleul->prenom,
                'a_fait_depot'     => $f->filleul->premier_depot_at !== null,
                'date_inscription' => $f->created_at,
            ];
        });

        return [
            'success'              => true,
            'code_parrainage'      => $user->code_parrainage,
            'solde'                => $user->solde ?? 0,
            'nombre_filleuls'      => $filleuls->count(),
            'filleuls_avec_depot'  => $filleulsAvecDepot,
            'filleuls_restants'    => max(0, self::FILLEULS_REQUIS - $filleulsAvecDepot),
            'prime_disponible'     => self::PRIME_MONTANT,
            'filleuls'             => $filleulsInfo,
            'explication_systeme'  => $this->getExplicationSysteme(),
        ];
    }

    public function getMessagePartage(AutoEcoleUser $user): array
    {
        $config = ConfigPaiement::getConfig();

        $message = "😊 Inscris-toi à l'Auto-École Ange Raphael avec mon code de parrainage : {$user->code_parrainage} 🚗\n\n" .
                   "🚘 Apprends à conduire et obtiens ton permis A & B ! 🥳\n\n" .
                   "📲 Clique sur le lien pour télécharger l'application et t'inscrire 👉 {$config->lien_telechargement_app}";

        return [
            'success'         => true,
            'message'         => $message,
            'code_parrainage' => $user->code_parrainage,
            'lien_app'        => $config->lien_telechargement_app,
        ];
    }

    public function getListeFilleuls(AutoEcoleUser $user): array
    {
        $filleuls = Filleul::where('parrain_id', $user->id)
            ->with('filleul')
            ->orderBy('created_at', 'desc')
            ->get();

        $filleulsDetails = $filleuls->map(function ($f) {
            $filleul = $f->filleul;
            return [
                'id'               => $filleul->id,
                'nom'              => $filleul->nom,
                'prenom'           => $filleul->prenom,
                'telephone'        => substr($filleul->telephone, 0, 4) . '****' . substr($filleul->telephone, -2),
                'a_fait_depot'     => $filleul->premier_depot_at !== null,
                'date_depot'       => $filleul->premier_depot_at,
                'date_inscription' => $f->created_at,
                'nombre_filleuls'  => Filleul::where('parrain_id', $filleul->id)->count(),
            ];
        });

        return [
            'success'  => true,
            'filleuls' => $filleulsDetails,
            'total'    => $filleuls->count(),
        ];
    }

    public function getArbreParrainage(AutoEcoleUser $user, int $profondeur = 3): array
    {
        return [
            'success' => true,
            'arbre'   => $this->construireArbre($user, $profondeur),
        ];
    }

    /**
     * Appelée après chaque dépôt d'un filleul pour vérifier si la prime doit être créditée.
     * À appeler depuis le service de paiement/dépôt.
     */
    public function verifierEtCrediterPrime(int $parrainId): void
    {
        $parrain = AutoEcoleUser::find($parrainId);
        if (!$parrain) return;

        $filleuls = Filleul::where('parrain_id', $parrainId)->with('filleul')->get();
        $filleulsAvecDepot = $filleuls->filter(fn($f) => $f->filleul?->premier_depot_at !== null)->count();

        // On crédite la prime uniquement quand on atteint exactement le seuil
        // (pour éviter de créditer plusieurs fois)
        if ($filleulsAvecDepot === self::FILLEULS_REQUIS && !$parrain->prime_parrainage_creditee) {
            DB::transaction(function () use ($parrain) {
                $parrain->solde = ($parrain->solde ?? 0) + self::PRIME_MONTANT;
                $parrain->prime_parrainage_creditee = true;
                $parrain->save();

                Log::info('Prime de parrainage créditée', [
                    'parrain_id' => $parrain->id,
                    'montant'    => self::PRIME_MONTANT,
                    'nouveau_solde' => $parrain->solde,
                ]);

                AutoEcoleNotification::envoyer(
                    $parrain->id,
                    '🎉 Prime de parrainage créditée !',
                    'Félicitations ! Vos ' . self::FILLEULS_REQUIS . ' filleuls ont effectué un dépôt. ' .
                    self::PRIME_MONTANT . ' FCFA ont été ajoutés à votre solde. ' .
                    'Vous pouvez retirer cette somme en vous présentant au CFPAM.',
                    'parrainage'
                );
            });
        }
    }

    // -------------------------------------------------------------------------
    // Méthodes privées
    // -------------------------------------------------------------------------

    private function construireArbre(AutoEcoleUser $user, int $profondeur): array
    {
        if ($profondeur <= 0) {
            return [
                'id'      => $user->id,
                'nom'     => $user->nom,
                'prenom'  => $user->prenom,
                'enfants' => [],
            ];
        }

        $filleuls = Filleul::where('parrain_id', $user->id)
            ->with('filleul')
            ->get();

        $enfants = $filleuls->map(fn($f) => $this->construireArbre($f->filleul, $profondeur - 1))->toArray();

        return [
            'id'           => $user->id,
            'nom'          => $user->nom,
            'prenom'       => $user->prenom,
            'a_fait_depot' => $user->premier_depot_at !== null,
            'enfants'      => $enfants,
        ];
    }

    private function getExplicationSysteme(): array
    {
        return [
            'intro'   => 'Le système de parrainage Ange Raphael est simple : parrainez 3 personnes qui effectuent un dépôt et gagnez une prime !',
            'regles'  => [
                [
                    'condition' => '3 filleuls ont chacun effectué un dépôt',
                    'avantage'  => self::PRIME_MONTANT . ' FCFA crédités sur votre solde',
                ],
            ],
            'retrait' => 'Le retrait de votre solde se fait exclusivement en présentiel au CFPAM.',
            'important' => [
                'Chaque membre peut avoir maximum 3 filleuls directs.',
                'Les filleuls supplémentaires sont placés sous vos filleuls existants (structure en arbre).',
                'La prime de ' . self::PRIME_MONTANT . ' FCFA est créditée une seule fois, dès que vos 3 filleuls ont fait un dépôt.',
                'Le retrait se fait uniquement en présentiel au CFPAM.',
            ],
        ];
    }
}