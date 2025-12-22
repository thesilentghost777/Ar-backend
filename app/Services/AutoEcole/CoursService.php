<?php

namespace App\Services\AutoEcole;

use App\Models\AutoEcoleUser;
use App\Models\Module;
use App\Models\Chapitre;
use App\Models\Lecon;
use App\Models\Quiz;
use App\Models\ProgressionLecon;
use App\Models\ResultatQuiz;
use App\Models\AutoEcoleNotification;
use Illuminate\Support\Facades\DB;

class CoursService
{
    public function getStructureCours(AutoEcoleUser $user, string $type = 'theorique'): array
    {
        // ✅ Nouveau: Vérifier si l'utilisateur a fait son premier dépôt
        $premierDepotEffectue = $user->premier_depot_at !== null;

        $modules = Module::where('type', $type)
            ->where('active', true)
            ->where(function ($query) use ($user) {
                $query->where('type_permis', 'tous')
                      ->orWhere('type_permis', $user->type_permis);
            })
            ->orderBy('ordre')
            ->with(['chapitres' => function ($query) {
                $query->where('active', true)->orderBy('ordre');
            }, 'chapitres.lecons' => function ($query) {
                $query->where('active', true)->orderBy('ordre');
            }, 'chapitres.quiz' => function ($query) {
                $query->where('active', true)->orderBy('ordre');
            }])
            ->get();

        $structuredModules = [];
        $modulesPrecedentsCompletes = true;

        foreach ($modules as $module) {
            $chapitres = [];
            $chapitresPrecedentsCompletes = true;
            $moduleComplete = true;

            foreach ($module->chapitres as $chapitre) {
                $lecons = [];
                $toutesLeconsCompletes = true;

                foreach ($chapitre->lecons as $lecon) {
                    $progression = ProgressionLecon::where('user_id', $user->id)
                        ->where('lecon_id', $lecon->id)
                        ->first();

                    $leconComplete = $progression && $progression->completee;
                    if (!$leconComplete) {
                        $toutesLeconsCompletes = false;
                    }

                    // ✅ Nouveau: Si pas de premier dépôt, masquer le contenu mais montrer la structure
                    if (!$premierDepotEffectue) {
                        $lecons[] = [
                            'id' => $lecon->id,
                            'titre' => $lecon->titre,
                            'contenu_texte' => null,
                            'url_web' => null,
                            'url_video' => null,
                            'duree_minutes' => $lecon->duree_minutes,
                            'completee' => false,
                            'date_completion' => null,
                            'accessible' => false // ❌ Contenu verrouillé
                        ];
                    } else {
                        // ✅ Avec premier dépôt: contenu complet
                        $lecons[] = [
                            'id' => $lecon->id,
                            'titre' => $lecon->titre,
                            'contenu_texte' => $lecon->contenu_texte,
                            'url_web' => $type === 'theorique' ? $lecon->url_web : null,
                            'url_video' => $type === 'pratique' ? $lecon->url_video : null,
                            'duree_minutes' => $lecon->duree_minutes,
                            'completee' => $leconComplete,
                            'date_completion' => $progression?->date_completion,
                            'accessible' => $modulesPrecedentsCompletes && $chapitresPrecedentsCompletes
                        ];
                    }
                }

                // Vérifier si le quiz du chapitre est réussi
                $quizReussi = $premierDepotEffectue ? $this->chapitreQuizReussi($user->id, $chapitre->id) : false;
                $chapitreComplete = $toutesLeconsCompletes && $quizReussi;

                if (!$chapitreComplete) {
                    $moduleComplete = false;
                }

                // Quiz du chapitre
                $quizInfo = null;
                $quiz = $chapitre->quiz->first();
                if ($quiz) {
                    $resultatQuiz = null;
                    if ($premierDepotEffectue) {
                        $resultatQuiz = ResultatQuiz::where('user_id', $user->id)
                            ->where('quiz_id', $quiz->id)
                            ->where('reussi', true)
                            ->first();
                    }

                    $quizInfo = [
                        'id' => $quiz->id,
                        'titre' => $quiz->titre,
                        'note_passage' => $quiz->note_passage,
                        'duree_minutes' => $quiz->duree_minutes,
                        'disponible' => $premierDepotEffectue && $toutesLeconsCompletes && $chapitresPrecedentsCompletes && $modulesPrecedentsCompletes,
                        'reussi' => $resultatQuiz !== null,
                        'meilleure_note' => $resultatQuiz?->note
                    ];
                }

                $chapitres[] = [
                    'id' => $chapitre->id,
                    'nom' => $chapitre->nom,
                    'description' => $chapitre->description,
                    'lecons' => $lecons,
                    'quiz' => $quizInfo,
                    'complete' => $chapitreComplete,
                    'accessible' => $premierDepotEffectue && $modulesPrecedentsCompletes && $chapitresPrecedentsCompletes
                ];

                if (!$chapitreComplete) {
                    $chapitresPrecedentsCompletes = false;
                }
            }

            $structuredModules[] = [
                'id' => $module->id,
                'nom' => $module->nom,
                'description' => $module->description,
                'type' => $module->type,
                'chapitres' => $chapitres,
                'complete' => $moduleComplete,
                'accessible' => true // ✅ Module toujours accessible pour voir la structure
            ];

            if (!$moduleComplete) {
                $modulesPrecedentsCompletes = false;
            }
        }

        return [
            'success' => true,
            'premier_depot_effectue' => $premierDepotEffectue, // ✅ Nouveau champ
            'modules' => $structuredModules,
            'progression' => $premierDepotEffectue ? $this->calculerProgression($user, $type) : [
                'lecons' => ['total' => 0, 'completes' => 0, 'pourcentage' => 0.0],
                'quiz' => ['total' => 0, 'reussis' => 0, 'pourcentage' => 0.0],
                'global' => ['pourcentage' => 0.0, 'termine' => false]
            ]
        ];
    }

    public function getLecon(AutoEcoleUser $user, int $leconId): array
    {
        // ✅ Nouveau: Vérifier le premier dépôt pour accès au contenu
        $premierDepotEffectue = $user->premier_depot_at !== null;

        if (!$premierDepotEffectue) {
            return [
                'success' => false,
                'message' => 'Effectuez un premier dépôt pour accéder au contenu des leçons'
            ];
        }

        $lecon = Lecon::with(['chapitre.module'])->find($leconId);

        if (!$lecon) {
            return [
                'success' => false,
                'message' => 'Leçon non trouvée'
            ];
        }

        // Vérifier l'accessibilité
        $accessible = $this->leconAccessible($user, $lecon);

        if (!$accessible) {
            return [
                'success' => false,
                'message' => 'Terminez les leçons précédentes pour accéder à celle-ci'
            ];
        }

        $progression = ProgressionLecon::where('user_id', $user->id)
            ->where('lecon_id', $leconId)
            ->first();

        return [
            'success' => true,
            'lecon' => [
                'id' => $lecon->id,
                'titre' => $lecon->titre,
                'contenu_texte' => $lecon->contenu_texte,
                'url_web' => $lecon->chapitre->module->type === 'theorique' ? $lecon->url_web : null,
                'url_video' => $lecon->chapitre->module->type === 'pratique' ? $lecon->url_video : null,
                'duree_minutes' => $lecon->duree_minutes,
                'completee' => $progression && $progression->completee,
                'chapitre' => [
                    'id' => $lecon->chapitre->id,
                    'nom' => $lecon->chapitre->nom
                ],
                'module' => [
                    'id' => $lecon->chapitre->module->id,
                    'nom' => $lecon->chapitre->module->nom,
                    'type' => $lecon->chapitre->module->type
                ]
            ]
        ];
    }

    public function marquerLeconTerminee(AutoEcoleUser $user, int $leconId): array
    {
        // ✅ Vérifier le premier dépôt
        if (!$user->premier_depot_at) {
            return [
                'success' => false,
                'message' => 'Effectuez un premier dépôt pour accéder aux cours'
            ];
        }

        $lecon = Lecon::with('chapitre.module')->find($leconId);

        if (!$lecon) {
            return [
                'success' => false,
                'message' => 'Leçon non trouvée'
            ];
        }

        // Vérifier l'accessibilité
        if (!$this->leconAccessible($user, $lecon)) {
            return [
                'success' => false,
                'message' => 'Terminez les leçons précédentes pour accéder à celle-ci'
            ];
        }

        $progression = ProgressionLecon::updateOrCreate(
            ['user_id' => $user->id, 'lecon_id' => $leconId],
            ['completee' => true, 'date_completion' => now()]
        );

        // Vérifier si toutes les leçons du chapitre sont terminées
        $toutesLeconsTerminees = $this->toutesLeconsChapitreTerminees($user->id, $lecon->chapitre_id);

        return [
            'success' => true,
            'message' => 'Leçon marquée comme terminée',
            'progression' => $progression,
            'quiz_disponible' => $toutesLeconsTerminees,
            'progression_globale' => $this->calculerProgression($user, $lecon->chapitre->module->type)
        ];
    }

    public function getQuiz(AutoEcoleUser $user, int $quizId): array
    {
        // ✅ Vérifier le premier dépôt
        if (!$user->premier_depot_at) {
            return [
                'success' => false,
                'message' => 'Effectuez un premier dépôt pour accéder aux quiz'
            ];
        }

        $quiz = Quiz::with(['chapitre', 'questions.reponses'])->find($quizId);

        if (!$quiz) {
            return [
                'success' => false,
                'message' => 'Quiz non trouvé'
            ];
        }

        // Vérifier si toutes les leçons du chapitre sont terminées
        if (!$this->toutesLeconsChapitreTerminees($user->id, $quiz->chapitre_id)) {
            return [
                'success' => false,
                'message' => 'Terminez toutes les leçons du chapitre avant de passer le quiz'
            ];
        }

        // Vérifier si le quiz est déjà réussi
        $resultatReussi = ResultatQuiz::where('user_id', $user->id)
            ->where('quiz_id', $quizId)
            ->where('reussi', true)
            ->first();

        $questions = $quiz->questions->map(function ($question) {
            return [
                'id' => $question->id,
                'enonce' => $question->enonce,
                'image_url' => $question->image_url,
                'type' => $question->type,
                'points' => $question->points,
                'reponses' => $question->reponses->map(function ($reponse) {
                    return [
                        'id' => $reponse->id,
                        'texte' => $reponse->texte
                        // Ne pas envoyer est_correcte
                    ];
                })
            ];
        });

        return [
            'success' => true,
            'quiz' => [
                'id' => $quiz->id,
                'titre' => $quiz->titre,
                'description' => $quiz->description,
                'note_passage' => $quiz->note_passage,
                'duree_minutes' => $quiz->duree_minutes,
                'questions' => $questions,
                'deja_reussi' => $resultatReussi !== null,
                'meilleure_note' => $resultatReussi?->note
            ]
        ];
    }

    public function soumettreQuiz(AutoEcoleUser $user, int $quizId, array $reponses): array
    {
        // ✅ Vérifier le premier dépôt
        if (!$user->premier_depot_at) {
            return [
                'success' => false,
                'message' => 'Effectuez un premier dépôt pour passer les quiz'
            ];
        }

        $quiz = Quiz::with(['questions.reponses', 'chapitre.module'])->find($quizId);

        if (!$quiz) {
            return [
                'success' => false,
                'message' => 'Quiz non trouvé'
            ];
        }

        try {
            DB::beginTransaction();

            $totalPoints = 0;
            $pointsObtenus = 0;
            $corrections = [];

            foreach ($quiz->questions as $question) {
                $totalPoints += $question->points;
                $reponseUtilisateur = $reponses[$question->id] ?? null;
                $bonneReponse = $question->reponses->where('est_correcte', true)->first();

                $estCorrect = $reponseUtilisateur == $bonneReponse?->id;
                if ($estCorrect) {
                    $pointsObtenus += $question->points;
                }

                $corrections[] = [
                    'question_id' => $question->id,
                    'enonce' => $question->enonce,
                    'reponse_utilisateur' => $reponseUtilisateur,
                    'bonne_reponse' => $bonneReponse?->id,
                    'bonne_reponse_texte' => $bonneReponse?->texte,
                    'est_correct' => $estCorrect,
                    'explication' => $question->explication,
                    'points' => $estCorrect ? $question->points : 0
                ];
            }

            // Calculer la note sur 20
            $note = ($totalPoints > 0) ? round(($pointsObtenus / $totalPoints) * 20, 2) : 0;
            $reussi = $note >= $quiz->note_passage;

            // Compter les tentatives
            $nbTentatives = ResultatQuiz::where('user_id', $user->id)
                ->where('quiz_id', $quizId)
                ->count();

            // Vérifier si l'utilisateur avait déjà réussi
            $dejaReussi = ResultatQuiz::where('user_id', $user->id)
                ->where('quiz_id', $quizId)
                ->where('reussi', true)
                ->exists();

            // Enregistrer le résultat
            $resultat = ResultatQuiz::create([
                'user_id' => $user->id,
                'quiz_id' => $quizId,
                'note' => $note,
                'total_questions' => $quiz->questions->count(),
                'bonnes_reponses' => collect($corrections)->where('est_correct', true)->count(),
                'reussi' => $reussi,
                'reponses_utilisateur' => $reponses,
                'tentative' => $nbTentatives + 1
            ]);

            // Notification
            if ($reussi && !$dejaReussi) {
                AutoEcoleNotification::envoyer(
                    $user->id,
                    'Quiz réussi!',
                    "Félicitations! Vous avez réussi le quiz \"{$quiz->titre}\" avec {$note}/20",
                    'cours'
                );
            }

            DB::commit();

            return [
                'success' => true,
                'resultat' => [
                    'note' => $note,
                    'note_passage' => $quiz->note_passage,
                    'reussi' => $reussi,
                    'total_questions' => $quiz->questions->count(),
                    'bonnes_reponses' => collect($corrections)->where('est_correct', true)->count(),
                    'tentative' => $nbTentatives + 1
                ],
                'corrections' => $corrections,
                'progression_globale' => $this->calculerProgression($user, $quiz->chapitre->module->type)
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Erreur lors de la soumission du quiz: ' . $e->getMessage()
            ];
        }
    }

    public function calculerProgression(AutoEcoleUser $user, string $type = 'theorique'): array
    {
        $modules = Module::where('type', $type)
            ->where('active', true)
            ->where(function ($query) use ($user) {
                $query->where('type_permis', 'tous')
                      ->orWhere('type_permis', $user->type_permis);
            })
            ->with('chapitres.lecons')
            ->get();

        $totalLecons = 0;
        $leconsCompletes = 0;
        $totalQuiz = 0;
        $quizReussis = 0;

        foreach ($modules as $module) {
            foreach ($module->chapitres as $chapitre) {
                // Leçons
                $totalLecons += $chapitre->lecons->count();
                $leconsCompletes += ProgressionLecon::where('user_id', $user->id)
                    ->whereIn('lecon_id', $chapitre->lecons->pluck('id'))
                    ->where('completee', true)
                    ->count();

                // Quiz
                $quiz = Quiz::where('chapitre_id', $chapitre->id)->where('active', true)->first();
                if ($quiz) {
                    $totalQuiz++;
                    if (ResultatQuiz::where('user_id', $user->id)
                        ->where('quiz_id', $quiz->id)
                        ->where('reussi', true)
                        ->exists()) {
                        $quizReussis++;
                    }
                }
            }
        }

        $pourcentageLecons = $totalLecons > 0 ? round(($leconsCompletes / $totalLecons) * 100, 1) : 0;
        $pourcentageQuiz = $totalQuiz > 0 ? round(($quizReussis / $totalQuiz) * 100, 1) : 0;
        $pourcentageGlobal = ($totalLecons + $totalQuiz) > 0
            ? round((($leconsCompletes + $quizReussis) / ($totalLecons + $totalQuiz)) * 100, 1)
            : 0;

        return [
            'lecons' => [
                'total' => $totalLecons,
                'completes' => $leconsCompletes,
                'pourcentage' => $pourcentageLecons
            ],
            'quiz' => [
                'total' => $totalQuiz,
                'reussis' => $quizReussis,
                'pourcentage' => $pourcentageQuiz
            ],
            'global' => [
                'pourcentage' => $pourcentageGlobal,
                'termine' => $pourcentageGlobal === 100.0
            ]
        ];
    }

    public function estPretPourExamen(AutoEcoleUser $user): array
    {
        // Vérifier les paiements
        $fraisPayes = $user->status_frais_formation !== 'non_paye' &&
                      $user->status_frais_inscription !== 'non_paye' &&
                      $user->status_examen_blanc !== 'non_paye' &&
                      $user->status_frais_examen !== 'non_paye';

        // Vérifier la progression des cours
        $progressionTheorique = $this->calculerProgression($user, 'theorique');
        $progressionPratique = $this->calculerProgression($user, 'pratique');

        $coursTermines = $progressionTheorique['global']['termine'] &&
                         $progressionPratique['global']['termine'];

        $pret = $fraisPayes && $coursTermines;

        return [
            'success' => true,
            'pret_pour_examen' => $pret,
            'details' => [
                'frais_payes' => $fraisPayes,
                'cours_theorique_termine' => $progressionTheorique['global']['termine'],
                'cours_pratique_termine' => $progressionPratique['global']['termine'],
                'progression_theorique' => $progressionTheorique['global']['pourcentage'],
                'progression_pratique' => $progressionPratique['global']['pourcentage']
            ]
        ];
    }

    private function leconAccessible(AutoEcoleUser $user, Lecon $lecon): bool
    {
        $chapitre = $lecon->chapitre;
        $module = $chapitre->module;

        // Vérifier les modules précédents
        $modulesPrecedents = Module::where('type', $module->type)
            ->where('ordre', '<', $module->ordre)
            ->where('active', true)
            ->get();

        foreach ($modulesPrecedents as $modulePrecedent) {
            foreach ($modulePrecedent->chapitres as $chap) {
                if (!$this->chapitreQuizReussi($user->id, $chap->id)) {
                    return false;
                }
            }
        }

        // Vérifier les chapitres précédents du même module
        $chapitresPrecedents = Chapitre::where('module_id', $module->id)
            ->where('ordre', '<', $chapitre->ordre)
            ->where('active', true)
            ->get();

        foreach ($chapitresPrecedents as $chapPrecedent) {
            if (!$this->chapitreQuizReussi($user->id, $chapPrecedent->id)) {
                return false;
            }
        }

        // Vérifier les leçons précédentes du même chapitre
        $leconsPrecedentes = Lecon::where('chapitre_id', $chapitre->id)
            ->where('ordre', '<', $lecon->ordre)
            ->where('active', true)
            ->get();

        foreach ($leconsPrecedentes as $leconPrecedente) {
            $progression = ProgressionLecon::where('user_id', $user->id)
                ->where('lecon_id', $leconPrecedente->id)
                ->where('completee', true)
                ->first();

            if (!$progression) {
                return false;
            }
        }

        return true;
    }

    private function toutesLeconsChapitreTerminees(int $userId, int $chapitreId): bool
    {
        $lecons = Lecon::where('chapitre_id', $chapitreId)
            ->where('active', true)
            ->get();

        foreach ($lecons as $lecon) {
            $progression = ProgressionLecon::where('user_id', $userId)
                ->where('lecon_id', $lecon->id)
                ->where('completee', true)
                ->first();

            if (!$progression) {
                return false;
            }
        }

        return true;
    }

    private function chapitreQuizReussi(int $userId, int $chapitreId): bool
    {
        $quiz = Quiz::where('chapitre_id', $chapitreId)->where('active', true)->first();

        if (!$quiz) {
            // Si pas de quiz, le chapitre est considéré comme réussi
            return $this->toutesLeconsChapitreTerminees($userId, $chapitreId);
        }

        return ResultatQuiz::where('user_id', $userId)
            ->where('quiz_id', $quiz->id)
            ->where('reussi', true)
            ->exists();
    }
}
