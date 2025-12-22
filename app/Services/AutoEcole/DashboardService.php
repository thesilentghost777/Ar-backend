<?php

namespace App\Services\AutoEcole;

use App\Models\AutoEcoleUser;
use App\Models\Session;
use App\Models\ConfigPaiement;
use Carbon\Carbon;

class DashboardService
{
    private CoursService $coursService;
    private ParrainageService $parrainageService;
    private PaiementService $paiementService;

    public function __construct(
        CoursService $coursService,
        ParrainageService $parrainageService,
        PaiementService $paiementService
    ) {
        $this->coursService = $coursService;
        $this->parrainageService = $parrainageService;
        $this->paiementService = $paiementService;
    }

    public function getDashboard(AutoEcoleUser $user): array
    {
        $user->load(['session', 'centreExamen', 'parrain']);

        \Log::info('Session renvoyée dans dashboard:', [
    'session_raw' => $user->session ? $user->session->toArray() : null,
    'session_formatted' => $this->getInfoSession($user)
]);
        return [
            'success' => true,
            'utilisateur' => [
                'id' => $user->id,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'initiales' => $this->getInitiales($user),
                'solde' => $user->solde,
                'type_permis' => $user->type_permis,
                'vague' => $user->vague,
                'niveau_parrainage' => $user->niveau_parrainage,
                'cours_debloques' => $user->cours_debloques
            ],
            'compte_a_rebours' => $this->getCompteARebours($user),
            'session' => $this->getInfoSession($user),
            'frais' => $this->paiementService->getStatusFrais($user)['frais'],
            'pret_pour_examen' => $this->coursService->estPretPourExamen($user),
            'progression' => [
                'theorique' => $this->coursService->calculerProgression($user, 'theorique'),
                'pratique' => $this->coursService->calculerProgression($user, 'pratique')
            ],
            'parcours_formation' => $this->getParcoursFormation($user)
        ];
    }

    private function getInitiales(AutoEcoleUser $user): string
    {
        $prenoms = explode(' ', $user->prenom);
        $noms = explode(' ', $user->nom);

        $initialePrenom = !empty($prenoms[0]) ? strtoupper(substr($prenoms[0], 0, 1)) : '';
        $initialeNom = !empty($noms[0]) ? strtoupper(substr($noms[0], 0, 1)) : '';

        return $initialePrenom . $initialeNom;
    }

    private function getCompteARebours(AutoEcoleUser $user): ?array
    {
        if (!$user->session || !$user->session->date_examen_theorique) {
            return null;
        }

        $dateExamen = Carbon::parse($user->session->date_examen_theorique);
        $maintenant = now();

        if ($dateExamen->isPast()) {
            return [
                'date_examen' => $dateExamen->format('d/m/Y'),
                'passe' => true,
                'message' => 'L\'examen est passé'
            ];
        }

        $diff = $maintenant->diff($dateExamen);

        return [
            'date_examen' => $dateExamen->format('d/m/Y'),
            'passe' => false,
            'jours' => $diff->days,
            'heures' => $diff->h,
            'minutes' => $diff->i,
            'secondes' => $diff->s,
            'timestamp_cible' => $dateExamen->timestamp
        ];
    }

    private function getInfoSession(AutoEcoleUser $user): ?array
{
    if (!$user->session) {
        return null;
    }
    $session = $user->session;


    return [
        'id' => $session->id,
        'nom' => $session->nom,
        'vague' => $user->vague, // Tu peux garder ça ou le supprimer, c'est déjà dans utilisateur
        'date_communication_enregistrement' => $session->date_communication_enregistrement,
        'date_enregistrement_vague1' => $session->date_enregistrement_vague1,
        'date_enregistrement_vague2' => $session->date_enregistrement_vague2,
        'date_transfert_reconduction' => $session->date_transfert_reconduction,
        'date_depot_departemental' => $session->date_depot_departemental,
        'date_depot_regional' => $session->date_depot_regional,
        'date_examen_theorique' => $session->date_examen_theorique,
        'date_examen_pratique' => $session->date_examen_pratique,
    ];
}

    private function getParcoursFormation(AutoEcoleUser $user): array
    {
        $progressionTheorique = $this->coursService->calculerProgression($user, 'theorique');
        $progressionPratique = $this->coursService->calculerProgression($user, 'pratique');
        $frais = $this->paiementService->getStatusFrais($user)['frais'];

        $tousLesFraisPayes = true;
        foreach ($frais as $type => $info) {
            if ($info['status'] === 'non_paye') {
                $tousLesFraisPayes = false;
                break;
            }
        }

        return [
            [
                'etape' => 1,
                'titre' => 'S\'inscrire',
                'description' => 'Créer votre compte Ange Raphael',
                'complete' => true,
                'date' => $user->created_at?->format('d/m/Y')
            ],
            [
                'etape' => 2,
                'titre' => 'Effectuer les paiements',
                'description' => 'Régler les différents frais de formation',
                'complete' => $tousLesFraisPayes,
                'sous_etapes' => [
                    [
                        'titre' => 'Frais de formation',
                        'complete' => $frais['formation']['status'] !== 'non_paye',
                        'montant' => $frais['formation']['montant']
                    ],
                    [
                        'titre' => 'Frais d\'inscription',
                        'complete' => $frais['inscription']['status'] !== 'non_paye',
                        'montant' => $frais['inscription']['montant']
                    ],
                    [
                        'titre' => 'Frais examen blanc',
                        'complete' => $frais['examen_blanc']['status'] !== 'non_paye',
                        'montant' => $frais['examen_blanc']['montant']
                    ],
                    [
                        'titre' => 'Frais d\'examen',
                        'complete' => $frais['examen']['status'] !== 'non_paye',
                        'montant' => $frais['examen']['montant']
                    ]
                ]
            ],
            [
                'etape' => 3,
                'titre' => 'Suivre les cours',
                'description' => 'Compléter les cours théoriques et pratiques',
                'complete' => $progressionTheorique['global']['termine'] && $progressionPratique['global']['termine'],
                'sous_etapes' => [
                    [
                        'titre' => 'Cours théoriques',
                        'complete' => $progressionTheorique['global']['termine'],
                        'pourcentage' => $progressionTheorique['global']['pourcentage']
                    ],
                    [
                        'titre' => 'Cours pratiques',
                        'complete' => $progressionPratique['global']['termine'],
                        'pourcentage' => $progressionPratique['global']['pourcentage']
                    ]
                ]
            ],
            [
                'etape' => 4,
                'titre' => 'Présenter l\'examen',
                'description' => 'Passer l\'examen officiel du permis',
                'complete' => false,
                'date_prevue' => $user->session?->date_examen_theorique?->format('d/m/Y')
            ]
        ];
    }

    public function getConfiguration(): array
    {
        $config = ConfigPaiement::getConfig();

        $sessionsDisponibles = Session::disponiblesPourInscription()->orderBy('date_examen_theorique')->get();

        return [
            'success' => true,
            'frais' => [
                'formation' => $config->frais_formation,
                'inscription' => $config->frais_inscription,
                'examen_blanc' => $config->frais_examen_blanc,
                'examen' => $config->frais_examen
            ],
            'depot_minimum' => $config->depot_minimum,
            'whatsapp_support' => $config->whatsapp_support,
            'lien_telechargement' => $config->lien_telechargement_app,
            'sessions_disponibles' => $sessionsDisponibles,
            'types_permis' => [
                ['value' => 'permis_a', 'label' => 'Permis A (Moto)', 'disponible' => true],
                ['value' => 'permis_b', 'label' => 'Permis B (Voiture)', 'disponible' => true],
                ['value' => 'permis_t', 'label' => 'Permis T (Tracteur)', 'disponible' => true],
                ['value' => 'permis_c', 'label' => 'Permis C (Poids lourd)', 'disponible' => false],
                ['value' => 'permis_d', 'label' => 'Permis D (Transport en commun)', 'disponible' => false],
                ['value' => 'permis_e', 'label' => 'Permis E (Remorque)', 'disponible' => false]
            ],
            'types_cours' => [
                ['value' => 'en_ligne', 'label' => 'En ligne'],
                ['value' => 'presentiel', 'label' => 'En présentiel (Samedi)'],
                ['value' => 'les_deux', 'label' => 'Les deux']
            ]
        ];
    }
}
