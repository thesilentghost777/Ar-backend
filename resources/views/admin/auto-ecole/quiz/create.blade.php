@extends('layouts.admin')
@php
    $isFrench = true;
@endphp
@section('title', $isFrench ? 'Nouveau Quiz' : 'New Quiz')

@section('admin-content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-blue-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex items-center gap-2 text-sm mb-4" aria-label="Breadcrumb">
                <a href="{{ route('admin.auto-ecole.quiz.index') }}"
                   class="text-gray-600 hover:text-amber-600 transition-colors">
                    {{ $isFrench ? 'Quiz' : 'Quizzes' }}
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-amber-600 font-semibold">{{ $isFrench ? 'Nouveau' : 'New' }}</span>
            </nav>

            <h1 class="text-3xl md:text-4xl font-bold text-gray-900">
                <i class="fas fa-plus-circle text-amber-600 mr-3"></i>
                {{ $isFrench ? 'Créer un Nouveau Quiz' : 'Create New Quiz' }}
            </h1>
            <p class="text-gray-600 mt-2">
                {{ $isFrench ? 'Remplissez les informations du quiz, puis ajoutez les questions' : 'Fill in the quiz information, then add questions' }}
            </p>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <form action="{{ route('admin.auto-ecole.quiz.store') }}" method="POST" class="p-6 md:p-8">
                @csrf

                <div class="space-y-6">
                    <!-- Chapitre -->
                    <div>
                        <label for="chapitre_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-book text-blue-600 mr-2"></i>
                            {{ $isFrench ? 'Chapitre' : 'Chapter' }} *
                        </label>
                        <select name="chapitre_id"
                                id="chapitre_id"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-200 @error('chapitre_id') border-red-500 @enderror">
                            <option value="">{{ $isFrench ? 'Sélectionnez un chapitre' : 'Select a chapter' }}</option>
                            @foreach($chapitres as $chapitre)
                                <option value="{{ $chapitre->id }}" {{ old('chapitre_id', $chapitreSelectionne) == $chapitre->id ? 'selected' : '' }}>
                                    {{ $chapitre->module->nom }} - {{ $chapitre->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('chapitre_id')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Titre -->
                    <div>
                        <label for="titre" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-heading text-purple-600 mr-2"></i>
                            {{ $isFrench ? 'Titre du Quiz' : 'Quiz Title' }} *
                        </label>
                        <input type="text"
                               name="titre"
                               id="titre"
                               required
                               value="{{ old('titre') }}"
                               placeholder="{{ $isFrench ? 'Ex: Quiz sur la signalisation routière' : 'Ex: Road Signs Quiz' }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-200 @error('titre') border-red-500 @enderror">
                        @error('titre')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-align-left text-green-600 mr-2"></i>
                            {{ $isFrench ? 'Description (optionnelle)' : 'Description (optional)' }}
                        </label>
                        <textarea name="description"
                                  id="description"
                                  rows="3"
                                  placeholder="{{ $isFrench ? 'Décrivez le contenu et les objectifs du quiz...' : 'Describe the content and objectives of the quiz...' }}"
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-200 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Paramètres du Quiz -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="note_passage" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-flag text-red-600 mr-2"></i>
                                {{ $isFrench ? 'Note de passage' : 'Passing grade' }} *
                            </label>
                            <div class="relative">
                                <input type="number"
                                       name="note_passage"
                                       id="note_passage"
                                       required
                                       min="1"
                                       max="20"
                                       value="{{ old('note_passage', 12) }}"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-200 @error('note_passage') border-red-500 @enderror">
                                <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">/20</span>
                            </div>
                            @error('note_passage')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="duree_minutes" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-clock text-blue-600 mr-2"></i>
                                {{ $isFrench ? 'Durée (minutes)' : 'Duration (minutes)' }} *
                            </label>
                            <input type="number"
                                   name="duree_minutes"
                                   id="duree_minutes"
                                   required
                                   min="1"
                                   value="{{ old('duree_minutes', 30) }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-200 @error('duree_minutes') border-red-500 @enderror">
                            @error('duree_minutes')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="ordre" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-sort-numeric-up text-green-600 mr-2"></i>
                                {{ $isFrench ? 'Ordre d\'affichage' : 'Display order' }} *
                            </label>
                            <input type="number"
                                   name="ordre"
                                   id="ordre"
                                   required
                                   min="0"
                                   value="{{ old('ordre', 0) }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-200 @error('ordre') border-red-500 @enderror">
                            @error('ordre')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Statut Actif -->
                    <div class="bg-gray-50 rounded-lg p-4 border-2 border-gray-200">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox"
                                   name="active"
                                   id="active"
                                   value="1"
                                   {{ old('active', true) ? 'checked' : '' }}
                                   class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <span class="ml-3 text-sm font-semibold text-gray-700">
                                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                {{ $isFrench ? 'Quiz actif (visible pour les étudiants)' : 'Active quiz (visible to students)' }}
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 mt-8 pt-6 border-t border-gray-200">
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-amber-600 to-amber-700 text-white px-6 py-3 rounded-lg font-semibold hover:from-amber-700 hover:to-amber-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200 shadow-lg">
                        <i class="fas fa-arrow-right mr-2"></i>
                        {{ $isFrench ? 'Créer et ajouter des questions' : 'Create and add questions' }}
                    </button>

                    <a href="{{ route('admin.auto-ecole.quiz.index') }}"
                       class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 text-center">
                        <i class="fas fa-times mr-2"></i>
                        {{ $isFrench ? 'Annuler' : 'Cancel' }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
