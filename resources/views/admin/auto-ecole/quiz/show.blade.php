@extends('layouts.admin')
@php
    $isFrench = true;
@endphp
@section('title', $isFrench ? 'Détails du Quiz' : 'Quiz Details')

@section('admin-content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-blue-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex items-center gap-2 text-sm mb-4" aria-label="Breadcrumb">
                <a href="{{ route('admin.auto-ecole.quiz.index') }}"
                   class="text-gray-600 hover:text-amber-600 transition-colors">
                    <i class="fas fa-arrow-left mr-1"></i>
                    {{ $isFrench ? 'Retour aux quiz' : 'Back to quizzes' }}
                </a>
            </nav>

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900">
                        <i class="fas fa-question-circle text-amber-600 mr-3"></i>
                        {{ $quiz->titre }}
                    </h1>
                    <p class="text-gray-600 mt-2">{{ $quiz->description }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.auto-ecole.quiz.edit', $quiz->id) }}"
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        {{ $isFrench ? 'Modifier' : 'Edit' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between mb-2">
                    <i class="fas fa-list text-blue-600 text-2xl"></i>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['total_questions'] }}</p>
                <p class="text-sm text-gray-600">{{ $isFrench ? 'Questions totales' : 'Total questions' }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-amber-500">
                <div class="flex items-center justify-between mb-2">
                    <i class="fas fa-star text-amber-600 text-2xl"></i>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['total_points'] }}</p>
                <p class="text-sm text-gray-600">{{ $isFrench ? 'Points totaux' : 'Total points' }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between mb-2">
                    <i class="fas fa-clock text-green-600 text-2xl"></i>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $quiz->duree_minutes }}</p>
                <p class="text-sm text-gray-600">{{ $isFrench ? 'Minutes' : 'Minutes' }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between mb-2">
                    <i class="fas fa-flag text-red-600 text-2xl"></i>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $quiz->note_passage }}/20</p>
                <p class="text-sm text-gray-600">{{ $isFrench ? 'Note de passage' : 'Passing grade' }}</p>
            </div>
        </div>

        <!-- Informations du chapitre -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">
                <i class="fas fa-book text-blue-600 mr-2"></i>
                {{ $isFrench ? 'Chapitre' : 'Chapter' }}
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-sm text-gray-600 mb-1">{{ $isFrench ? 'Module' : 'Module' }}</p>
                    <p class="font-semibold text-gray-900 text-lg">{{ $quiz->chapitre->module->nom }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-sm text-gray-600 mb-1">{{ $isFrench ? 'Chapitre' : 'Chapter' }}</p>
                    <p class="font-semibold text-gray-900 text-lg">{{ $quiz->chapitre->nom }}</p>
                </div>
            </div>
        </div>

        <!-- Questions -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">
                    <i class="fas fa-list mr-2"></i>
                    {{ $isFrench ? 'Questions du Quiz' : 'Quiz Questions' }}
                </h2>
            </div>

            <div class="p-6">
                @if($quiz->questions->count() > 0)
                    <div class="space-y-6">
                        @foreach($quiz->questions as $index => $question)
                            <div class="bg-gray-50 rounded-xl overflow-hidden border-2 border-gray-200">
                                <!-- En-tête de la question -->
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-white font-bold text-sm">
                                                    {{ $isFrench ? 'Question' : 'Question' }} #{{ $question->ordre }}
                                                </span>
                                                <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-white text-sm">
                                                    <i class="fas fa-star mr-1"></i>
                                                    {{ $question->points }} {{ $isFrench ? 'points' : 'points' }}
                                                </span>
                                                <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-white text-sm">
                                                    <i class="fas fa-{{ $question->type == 'qcm' ? 'list' : 'check-circle' }} mr-1"></i>
                                                    {{ $question->type == 'qcm' ? 'QCM' : ($isFrench ? 'Vrai/Faux' : 'True/False') }}
                                                </span>
                                            </div>
                                            <p class="text-white text-lg font-semibold">{{ $question->enonce }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Image (si présente) -->
                                @if($question->image_url)
                                    <div class="px-6 pt-4">
                                        <img src="{{ $question->image_url }}"
                                             alt="Image de la question"
                                             class="w-full max-w-md mx-auto rounded-lg shadow-md">
                                    </div>
                                @endif

                                <!-- Réponses -->
                                <div class="p-6">
                                    <h4 class="text-sm font-semibold text-gray-700 mb-3">
                                        <i class="fas fa-list text-green-600 mr-2"></i>
                                        {{ $isFrench ? 'Réponses' : 'Answers' }}
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach($question->reponses as $repIndex => $reponse)
                                            <div class="flex items-start gap-3 p-4 rounded-lg {{ $reponse->est_correcte ? 'bg-green-50 border-2 border-green-500' : 'bg-white border-2 border-gray-200' }}">
                                                <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full {{ $reponse->est_correcte ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600' }} font-bold text-sm">
                                                    {{ chr(65 + $repIndex) }}
                                                </span>
                                                <div class="flex-1">
                                                    <p class="text-gray-900 font-medium">{{ $reponse->texte }}</p>
                                                    @if($reponse->est_correcte)
                                                        <span class="inline-flex items-center mt-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                                            <i class="fas fa-check mr-1"></i>
                                                            {{ $isFrench ? 'Réponse correcte' : 'Correct answer' }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Explication -->
                                    @if($question->explication)
                                        <div class="mt-4 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                                            <h5 class="text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                                                {{ $isFrench ? 'Explication' : 'Explanation' }}
                                            </h5>
                                            <p class="text-gray-700">{{ $question->explication }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-question-circle text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            {{ $isFrench ? 'Aucune question' : 'No questions' }}
                        </h3>
                        <p class="text-gray-600 mb-6">
                            {{ $isFrench ? 'Ce quiz ne contient pas encore de questions' : 'This quiz does not contain any questions yet' }}
                        </p>
                        <a href="{{ route('admin.auto-ecole.quiz.edit', $quiz->id) }}"
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            {{ $isFrench ? 'Ajouter des questions' : 'Add questions' }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 mt-8">
            <a href="{{ route('admin.auto-ecole.quiz.edit', $quiz->id) }}"
               class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-200 text-center">
                <i class="fas fa-edit mr-2"></i>
                {{ $isFrench ? 'Modifier le quiz' : 'Edit quiz' }}
            </a>

            <form action="{{ route('admin.auto-ecole.quiz.duplicate', $quiz->id) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit"
                        class="w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white px-6 py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-purple-800 transition-all duration-200">
                    <i class="fas fa-copy mr-2"></i>
                    {{ $isFrench ? 'Dupliquer le quiz' : 'Duplicate quiz' }}
                </button>
            </form>

            <button onclick="deleteQuiz()"
                    class="flex-1 bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-3 rounded-lg font-semibold hover:from-red-700 hover:to-red-800 transition-all duration-200">
                <i class="fas fa-trash mr-2"></i>
                {{ $isFrench ? 'Supprimer' : 'Delete' }}
            </button>
        </div>
    </div>
</div>

<script>
function deleteQuiz() {
    Swal.fire({
        title: '{{ $isFrench ? "Êtes-vous sûr ?" : "Are you sure?" }}',
        text: '{{ $isFrench ? "Cette action supprimera également toutes les questions et réponses associées" : "This will also delete all associated questions and answers" }}',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '{{ $isFrench ? "Oui, supprimer" : "Yes, delete" }}',
        cancelButtonText: '{{ $isFrench ? "Annuler" : "Cancel" }}'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.auto-ecole.quiz.destroy", $quiz->id) }}';
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endsection
