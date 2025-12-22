@extends('layouts.admin')
@php
    $isFrench = true;
@endphp
@section('title', $isFrench ? 'Modifier le Quiz' : 'Edit Quiz')

@section('admin-content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-blue-50 py-8 px-4 sm:px-6 lg:px-8" x-data="questionsManager()">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex items-center gap-2 text-sm mb-4" aria-label="Breadcrumb">
                <a href="{{ route('admin.auto-ecole.quiz.index') }}"
                   class="text-gray-600 hover:text-amber-600 transition-colors">
                    {{ $isFrench ? 'Quiz' : 'Quizzes' }}
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-amber-600 font-semibold">{{ $isFrench ? 'Modifier' : 'Edit' }}</span>
            </nav>

            <h1 class="text-3xl md:text-4xl font-bold text-gray-900">
                <i class="fas fa-edit text-amber-600 mr-3"></i>
                {{ $isFrench ? 'Modifier le Quiz' : 'Edit Quiz' }}
            </h1>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm" x-data="{ show: true }" x-show="show">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-green-500 hover:text-green-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm" x-data="{ show: true }" x-show="show">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        <p class="text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm" x-data="{ show: true }" x-show="show">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                            <p class="text-red-700 font-medium">{{ $isFrench ? 'Erreurs de validation :' : 'Validation errors:' }}</p>
                        </div>
                        <ul class="ml-10 list-disc text-red-600 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button @click="show = false" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informations du Quiz -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden sticky top-6">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">
                            <i class="fas fa-info-circle mr-2"></i>
                            {{ $isFrench ? 'Informations' : 'Information' }}
                        </h2>
                    </div>

                    <form action="{{ route('admin.auto-ecole.quiz.update', $quiz->id) }}" method="POST" class="p-6">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <!-- Chapitre -->
                            <div>
                                <label for="chapitre_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-book text-blue-600 mr-1"></i>
                                    {{ $isFrench ? 'Chapitre' : 'Chapter' }} *
                                </label>
                                <select name="chapitre_id"
                                        id="chapitre_id"
                                        required
                                        class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm @error('chapitre_id') border-red-500 @enderror">
                                    @foreach($chapitres as $chapitre)
                                        <option value="{{ $chapitre->id }}" {{ old('chapitre_id', $quiz->chapitre_id) == $chapitre->id ? 'selected' : '' }}>
                                            {{ $chapitre->module->nom }} - {{ $chapitre->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Titre -->
                            <div>
                                <label for="titre" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-heading text-purple-600 mr-1"></i>
                                    {{ $isFrench ? 'Titre' : 'Title' }} *
                                </label>
                                <input type="text"
                                       name="titre"
                                       id="titre"
                                       required
                                       value="{{ old('titre', $quiz->titre) }}"
                                       class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm @error('titre') border-red-500 @enderror">
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-align-left text-green-600 mr-1"></i>
                                    {{ $isFrench ? 'Description' : 'Description' }}
                                </label>
                                <textarea name="description"
                                          id="description"
                                          rows="3"
                                          class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm">{{ old('description', $quiz->description) }}</textarea>
                            </div>

                            <!-- Paramètres -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="note_passage" class="block text-xs font-semibold text-gray-700 mb-1">
                                        {{ $isFrench ? 'Note passage' : 'Passing grade' }}
                                    </label>
                                    <div class="relative">
                                        <input type="number"
                                               name="note_passage"
                                               id="note_passage"
                                               required
                                               min="1"
                                               max="20"
                                               value="{{ old('note_passage', $quiz->note_passage) }}"
                                               class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-amber-500 text-sm">
                                        <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-xs text-gray-500">/20</span>
                                    </div>
                                </div>

                                <div>
                                    <label for="duree_minutes" class="block text-xs font-semibold text-gray-700 mb-1">
                                        {{ $isFrench ? 'Durée (min)' : 'Duration (min)' }}
                                    </label>
                                    <input type="number"
                                           name="duree_minutes"
                                           id="duree_minutes"
                                           required
                                           min="1"
                                           value="{{ old('duree_minutes', $quiz->duree_minutes) }}"
                                           class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-amber-500 text-sm">
                                </div>
                            </div>

                            <div>
                                <label for="ordre" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-sort-numeric-up text-green-600 mr-1"></i>
                                    {{ $isFrench ? 'Ordre' : 'Order' }}
                                </label>
                                <input type="number"
                                       name="ordre"
                                       id="ordre"
                                       required
                                       min="0"
                                       value="{{ old('ordre', $quiz->ordre) }}"
                                       class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-amber-500 text-sm">
                            </div>

                            <!-- Statut -->
                            <div class="bg-gray-50 rounded-lg p-3">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox"
                                           name="active"
                                           id="active"
                                           value="1"
                                           {{ old('active', $quiz->active) ? 'checked' : '' }}
                                           class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                    <span class="ml-2 text-sm font-semibold text-gray-700">
                                        {{ $isFrench ? 'Quiz actif' : 'Active quiz' }}
                                    </span>
                                </label>
                            </div>

                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                                <i class="fas fa-save mr-2"></i>
                                {{ $isFrench ? 'Enregistrer' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Questions -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4 flex items-center justify-between">
                        <h2 class="text-xl font-bold text-white">
                            <i class="fas fa-list mr-2"></i>
                            {{ $isFrench ? 'Questions' : 'Questions' }}
                            <span class="ml-2 bg-white/20 px-3 py-1 rounded-full text-sm">{{ $quiz->questions->count() }}</span>
                        </h2>
                        <button @click="showAddQuestion = true"
                                class="bg-white text-purple-600 px-4 py-2 rounded-lg font-semibold hover:bg-purple-50 transition-all duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            {{ $isFrench ? 'Ajouter' : 'Add' }}
                        </button>
                    </div>

                    <div class="p-6">
                        <!-- Liste des questions -->
                        @if($quiz->questions->count() > 0)
                            <div class="space-y-4">
                                @foreach($quiz->questions as $index => $question)
                                    <div class="bg-gray-50 rounded-xl p-5 border-2 border-gray-200 hover:border-purple-300 transition-all duration-200">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex items-start gap-3 flex-1">
                                                <span class="flex-shrink-0 bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">
                                                    #{{ $question->ordre }}
                                                </span>
                                                <div class="flex-1">
                                                    <h3 class="font-semibold text-gray-900 mb-2">{{ $question->enonce }}</h3>
                                                    <div class="flex flex-wrap gap-2 mb-3">
                                                        <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">
                                                            <i class="fas fa-star mr-1"></i>
                                                            {{ $question->points }} {{ $isFrench ? 'pts' : 'pts' }}
                                                        </span>
                                                        <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">
                                                            <i class="fas fa-{{ $question->type == 'qcm' ? 'list' : 'check-circle' }} mr-1"></i>
                                                            {{ $question->type == 'qcm' ? 'QCM' : ($isFrench ? 'Vrai/Faux' : 'True/False') }}
                                                        </span>
                                                        <span class="inline-flex items-center px-2 py-1 bg-amber-100 text-amber-700 rounded text-xs font-semibold">
                                                            <i class="fas fa-list mr-1"></i>
                                                            {{ $question->reponses->count() }} {{ $isFrench ? 'réponses' : 'answers' }}
                                                        </span>
                                                    </div>

                                                    <!-- Réponses -->
                                                    <div class="space-y-2">
                                                        @foreach($question->reponses as $reponse)
                                                            <div class="flex items-center gap-2 text-sm">
                                                                @if($reponse->est_correcte)
                                                                    <i class="fas fa-check-circle text-green-600"></i>
                                                                @else
                                                                    <i class="fas fa-times-circle text-red-400"></i>
                                                                @endif
                                                                <span class="{{ $reponse->est_correcte ? 'text-green-700 font-semibold' : 'text-gray-600' }}">
                                                                    {{ $reponse->texte }}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    @if($question->explication)
                                                        <div class="mt-3 p-3 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                                                            <p class="text-sm text-gray-700">
                                                                <i class="fas fa-info-circle text-blue-600 mr-1"></i>
                                                                {{ $question->explication }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="flex gap-2 ml-3">
                                                <button @click="editQuestion({{ $question->id }})"
                                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button onclick="deleteQuestion({{ $question->id }})"
                                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <i class="fas fa-question-circle text-gray-300 text-5xl mb-4"></i>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">
                                    {{ $isFrench ? 'Aucune question' : 'No questions' }}
                                </h3>
                                <p class="text-gray-600 mb-4">
                                    {{ $isFrench ? 'Commencez par ajouter une question à ce quiz' : 'Start by adding a question to this quiz' }}
                                </p>
                                <button @click="showAddQuestion = true"
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all duration-200">
                                    <i class="fas fa-plus mr-2"></i>
                                    {{ $isFrench ? 'Ajouter une question' : 'Add a question' }}
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ajouter Question -->
        <div x-show="showAddQuestion"
             x-cloak
             @close-modal.window="showAddQuestion = false"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
            <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto"
                 @click.away="showAddQuestion = false"
                 @click.stop>
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fas fa-plus-circle mr-2"></i>
                        {{ $isFrench ? 'Nouvelle Question' : 'New Question' }}
                    </h3>
                    <button @click="showAddQuestion = false"
                            class="text-white hover:text-gray-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <form action="{{ route('admin.auto-ecole.quiz.add-question', $quiz->id) }}" method="POST" class="p-6">
                    @csrf
                    @include('admin.auto-ecole.quiz.partials.question-form')
                </form>
            </div>
        </div>

        <!-- Modal Éditer Question -->
        <div x-show="showEditQuestion"
             x-cloak
             @close-modal.window="showEditQuestion = false"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
            <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto"
                 @click.away="showEditQuestion = false"
                 @click.stop>
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fas fa-edit mr-2"></i>
                        {{ $isFrench ? 'Modifier la Question' : 'Edit Question' }}
                    </h3>
                    <button @click="showEditQuestion = false"
                            class="text-white hover:text-gray-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="p-6" id="edit-question-content">
                    <div class="text-center py-8">
                        <i class="fas fa-spinner fa-spin text-4xl text-purple-600"></i>
                        <p class="mt-3 text-gray-600">{{ $isFrench ? 'Chargement...' : 'Loading...' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function questionsManager() {
    return {
        showAddQuestion: false,
        showEditQuestion: false,

        async editQuestion(id) {
            this.showEditQuestion = true;

            try {
                const response = await fetch(`/admin/auto-ecole/quiz/questions/${id}/edit`);
                const html = await response.text();
                document.getElementById('edit-question-content').innerHTML = html;
            } catch (error) {
                console.error('Erreur:', error);
                this.showEditQuestion = false;
                alert('{{ $isFrench ? "Erreur lors du chargement de la question" : "Error loading question" }}');
            }
        }
    }
}

function deleteQuestion(id) {
    Swal.fire({
        title: '{{ $isFrench ? "Êtes-vous sûr ?" : "Are you sure?" }}',
        text: '{{ $isFrench ? "Cette action supprimera également toutes les réponses associées" : "This will also delete all associated answers" }}',
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
            form.action = `/admin/auto-ecole/quiz/questions/${id}`;
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

<style>
[x-cloak] { display: none !important; }
</style>
@endsection
