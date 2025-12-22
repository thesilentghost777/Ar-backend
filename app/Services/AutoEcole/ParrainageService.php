<?php

namespace App\Services\AutoEcole;

use App\Models\AutoEcoleUser;
use App\Models\Filleul;
use App\Models\ConfigPaiement;

class ParrainageService
{
    public function getInfoParrainage(AutoEcoleUser $user): array
    {
        $filleuls = Filleul::where('parrain_id', $user->id)
            ->with('filleul')
            ->get();

        $filleulsInfo = $filleuls->map(function ($f) {
            return [
                'id' => $f->filleul->id,
                'nom' => $f->filleul->nom,
                'prenom' => $f->filleul->prenom,
                'niveau' => $f->filleul->niveau_parrainage,
                'a_fait_depot' => $f->filleul->premier_depot_at !== null,
                'date_inscription' => $f->created_at
            ];
        });

        return [
            'success' => true,
            'niveau_actuel' => $user->niveau_parrainage,
            'code_parrainage' => $user->code_parrainage,
            'filleuls' => $filleulsInfo,
            'nombre_filleuls' => $filleuls->count(),
            'avantages_niveau_suivant' => $this->getAvantagesNiveauSuivant($user->niveau_parrainage),
            'explication_systeme' => $this->getExplicationSysteme()
        ];
    }

    public function getMessagePartage(AutoEcoleUser $user): array
    {
        $config = ConfigPaiement::getConfig();

        $message = "😊 Inscris-toi à l'Auto-École Ange Raphael avec mon code de parrainage : {$user->code_parrainage} 🚗\n\n" .
                   "🚘 Apprends à conduire et obtiens ton permis A & B GRATUITEMENT 🥳\n\n" .
                   "📲Cliquez sur le lien pour télécharger l'application et vous inscrire 👉 {$config->lien_telechargement_app}";

        return [
            'success' => true,
            'message' => $message,
            'code_parrainage' => $user->code_parrainage,
            'lien_app' => $config->lien_telechargement_app
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
                'id' => $filleul->id,
                'nom' => $filleul->nom,
                'prenom' => $filleul->prenom,
                'telephone' => substr($filleul->telephone, 0, 4) . '****' . substr($filleul->telephone, -2),
                'niveau' => $filleul->niveau_parrainage,
                'niveau_label' => $this->getNiveauLabel($filleul->niveau_parrainage),
                'a_fait_depot' => $filleul->premier_depot_at !== null,
                'date_depot' => $filleul->premier_depot_at,
                'date_inscription' => $f->created_at,
                'nombre_filleuls' => Filleul::where('parrain_id', $filleul->id)->count()
            ];
        });

        return [
            'success' => true,
            'filleuls' => $filleulsDetails,
            'total' => $filleuls->count()
        ];
    }

    public function getArbreParrainage(AutoEcoleUser $user, int $profondeur = 3): array
    {
        return [
            'success' => true,
            'arbre' => $this->construireArbre($user, $profondeur)
        ];
    }

    private function construireArbre(AutoEcoleUser $user, int $profondeur): array
    {
        if ($profondeur <= 0) {
            return [
                'id' => $user->id,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'niveau' => $user->niveau_parrainage,
                'enfants' => []
            ];
        }

        $filleuls = Filleul::where('parrain_id', $user->id)
            ->with('filleul')
            ->get();

        $enfants = $filleuls->map(function ($f) use ($profondeur) {
            return $this->construireArbre($f->filleul, $profondeur - 1);
        })->toArray();

        return [
            'id' => $user->id,
            'nom' => $user->nom,
            'prenom' => $user->prenom,
            'niveau' => $user->niveau_parrainage,
            'enfants' => $enfants
        ];
    }

    private function getNiveauLabel(int $niveau): string
    {
        return match ($niveau) {
            -1 => 'Nouveau membre',
            0 => 'Niveau 0',
            1 => 'Niveau 1',
            2 => 'Niveau 2',
            3 => 'Niveau 3 (Maximum)',
            default => 'Niveau inconnu'
        };
    }

    private function getAvantagesNiveauSuivant(int $niveauActuel): ?array
    {
        $config = ConfigPaiement::getConfig();

        return match ($niveauActuel) {
            -1 => [
                'niveau_cible' => 0,
                'condition' => 'Parrainez 3 personnes qui s\'inscrivent',
                'avantage' => "Frais de formation ({$config->frais_formation} FCFA) dispensés"
            ],
            0 => [
                'niveau_cible' => 1,
                'condition' => 'Vos 3 filleuls font chacun un dépôt',
                'avantage' => "Frais d'inscription ({$config->frais_inscription} FCFA) dispensés"
            ],
            1 => [
                'niveau_cible' => 2,
                'condition' => 'Vos 3 filleuls atteignent le niveau 1',
                'avantage' => "Frais d'examen blanc ({$config->frais_examen_blanc} FCFA) dispensés"
            ],
            2 => [
                'niveau_cible' => 3,
                'condition' => 'Vos 3 filleuls atteignent le niveau 2',
                'avantage' => "Frais d'examen ({$config->frais_examen} FCFA) dispensés - Formation 100% gratuite!"
            ],
            3 => null, // Niveau maximum atteint
            default => null
        };
    }

    private function getExplicationSysteme(): array
    {
        $config = ConfigPaiement::getConfig();

        return [
            'intro' => 'Le système de parrainage Ange Raphael vous permet d\'obtenir votre permis gratuitement!',
            'niveaux' => [
                [
                    'niveau' => 0,
                    'condition' => '3 filleuls inscrits',
                    'avantage' => "Frais de formation dispensés ({$config->frais_formation} FCFA)"
                ],
                [
                    'niveau' => 1,
                    'condition' => '3 filleuls ayant fait un dépôt',
                    'avantage' => "Frais d'inscription dispensés ({$config->frais_inscription} FCFA)"
                ],
                [
                    'niveau' => 2,
                    'condition' => '3 filleuls au niveau 1',
                    'avantage' => "Frais d'examen blanc dispensés ({$config->frais_examen_blanc} FCFA)"
                ],
                [
                    'niveau' => 3,
                    'condition' => '3 filleuls au niveau 2',
                    'avantage' => "Frais d'examen dispensés ({$config->frais_examen} FCFA) - Formation 100% gratuite!"
                ]
            ],
            'important' => [
                'Chaque membre peut avoir maximum 3 filleuls directs',
                'Les filleuls supplémentaires sont placés sous vos filleuls (arbre)',
                'Les niveaux de vos filleuls impactent votre propre niveau'
            ]
        ];
    }
}
