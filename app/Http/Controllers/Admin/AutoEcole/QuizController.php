<?php

namespace App\Http\Controllers\Admin\AutoEcole;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\Chapitre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $query = Quiz::with('chapitre.module')->withCount('questions');

        if ($request->filled('chapitre_id')) {
            $query->where('chapitre_id', $request->chapitre_id);
        }

        $quiz = $query->orderBy('ordre')->paginate(20);
        $chapitres = Chapitre::with('module')->where('active', true)->get();

        return view('admin.auto-ecole.quiz.index', compact('quiz', 'chapitres'));
    }

    public function create(Request $request)
    {
        $chapitres = Chapitre::with('module')
            ->where('active', true)
            ->orderBy('module_id')
            ->get();

        $chapitreSelectionne = $request->chapitre_id;

        return view('admin.auto-ecole.quiz.create', compact('chapitres', 'chapitreSelectionne'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'chapitre_id'    => 'required|exists:chapitres,id',
            'titre'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'note_passage'   => 'required|integer|min:1|max:20',
            'duree_minutes'  => 'required|integer|min:1',
            'ordre'          => 'required|integer|min:0',
            'active'         => 'nullable',
        ]);

        // Gérer le checkbox active correctement
        $validated['active'] = $request->has('active') ? true : false;

        $quiz = Quiz::create($validated);

        return redirect()->route('admin.auto-ecole.quiz.edit', $quiz)
            ->with('success', 'Quiz créé. Ajoutez maintenant les questions.');
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'chapitre_id'    => 'required|exists:chapitres,id',
            'titre'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'note_passage'   => 'required|integer|min:1|max:20',
            'duree_minutes'  => 'required|integer|min:1',
            'ordre'          => 'required|integer|min:0',
            'active'         => 'nullable',
        ]);

        // Gérer le checkbox active correctement
        $validated['active'] = $request->has('active') ? true : false;

        $quiz->update($validated);

        return redirect()->route('admin.auto-ecole.quiz.index')
            ->with('success', 'Quiz mis à jour avec succès');
    }

    public function show(Quiz $quiz)
    {
        $quiz->load(['chapitre.module', 'questions.reponses']);

        $stats = [
            'total_questions' => $quiz->questions->count(),
            'total_points' => $quiz->questions->sum('points'),
        ];

        return view('admin.auto-ecole.quiz.show', compact('quiz', 'stats'));
    }

    public function edit(Quiz $quiz)
    {
        $quiz->load('questions.reponses');
        $chapitres = Chapitre::with('module')->where('active', true)->get();

        return view('admin.auto-ecole.quiz.edit', compact('quiz', 'chapitres'));
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.auto-ecole.quiz.index')
            ->with('success', 'Quiz supprimé avec succès');
    }

    public function duplicate(Quiz $quiz)
    {
        try {
            DB::beginTransaction();

            $newQuiz = $quiz->replicate();
            $newQuiz->titre = $quiz->titre . ' (Copie)';
            $newQuiz->save();

            foreach ($quiz->questions as $question) {
                $newQuestion = $question->replicate();
                $newQuestion->quiz_id = $newQuiz->id;
                $newQuestion->save();

                foreach ($question->reponses as $reponse) {
                    $newReponse = $reponse->replicate();
                    $newReponse->question_id = $newQuestion->id;
                    $newReponse->save();
                }
            }

            DB::commit();

            return redirect()->route('admin.auto-ecole.quiz.edit', $newQuiz)
                ->with('success', 'Quiz dupliqué avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la duplication: ' . $e->getMessage());
        }
    }

    public function addQuestion(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'enonce' => 'required|string',
            'type' => 'required|in:qcm,vrai_faux',
            'image_url' => 'nullable|url',
            'explication' => 'nullable|string',
            'points' => 'required|integer|min:1',
            'reponses' => 'required|array|min:2',
            'reponses.*.texte' => 'required|string',
            'reponses.*.est_correcte' => 'nullable'
        ]);

        try {
            DB::beginTransaction();

            $ordre = $quiz->questions()->max('ordre') ?? 0;
            $ordre++;

            $question = Question::create([
                'quiz_id' => $quiz->id,
                'enonce' => $validated['enonce'],
                'type' => $validated['type'],
                'image_url' => $validated['image_url'] ?? null,
                'explication' => $validated['explication'] ?? null,
                'points' => $validated['points'],
                'ordre' => $ordre,
                'active' => true
            ]);

            foreach ($validated['reponses'] as $index => $rep) {
                $estCorrecte = false;
                if (isset($rep['est_correcte'])) {
                    $estCorrecte = in_array($rep['est_correcte'], [1, '1', true, 'true'], true);
                }

                Reponse::create([
                    'question_id' => $question->id,
                    'texte' => $rep['texte'],
                    'est_correcte' => $estCorrecte,
                    'ordre' => $index
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Question ajoutée avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout: ' . $e->getMessage());
        }
    }

    public function editQuestion(Question $question)
    {
        $isFrench = true;
        return view('admin.auto-ecole.quiz.partials.edit-question-form', compact('question', 'isFrench'));
    }

    public function updateQuestion(Request $request, Question $question)
    {
        $validated = $request->validate([
            'enonce' => 'required|string',
            'type' => 'required|in:qcm,vrai_faux',
            'image_url' => 'nullable|url',
            'explication' => 'nullable|string',
            'points' => 'required|integer|min:1',
            'reponses' => 'required|array|min:2',
            'reponses.*.texte' => 'required|string',
            'reponses.*.est_correcte' => 'nullable'
        ]);

        try {
            DB::beginTransaction();

            $question->update([
                'enonce' => $validated['enonce'],
                'type' => $validated['type'],
                'image_url' => $validated['image_url'] ?? null,
                'explication' => $validated['explication'] ?? null,
                'points' => $validated['points']
            ]);

            $question->reponses()->delete();

            foreach ($validated['reponses'] as $index => $rep) {
                $estCorrecte = false;
                if (isset($rep['est_correcte'])) {
                    $estCorrecte = in_array($rep['est_correcte'], [1, '1', true, 'true'], true);
                }

                Reponse::create([
                    'question_id' => $question->id,
                    'texte' => $rep['texte'],
                    'est_correcte' => $estCorrecte,
                    'ordre' => $index
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Question mise à jour avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    public function deleteQuestion(Question $question)
    {
        try {
            $quizId = $question->quiz_id;
            $question->delete();

            return redirect()->route('admin.auto-ecole.quiz.edit', $quizId)
                ->with('success', 'Question supprimée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
}
