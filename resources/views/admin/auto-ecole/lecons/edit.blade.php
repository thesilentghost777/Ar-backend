@extends('layouts.admin')

@section('title', 'Modifier leçon')
@section('page-title', 'Modifier: ' . $lecon->titre)

@section('admin-content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <a href="{{ route('admin.auto-ecole.lecons.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary-600">
        <i class="fas fa-arrow-left mr-2"></i> Retour aux leçons
    </a>

    <!-- Formulaire -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
            <h2 class="text-xl font-semibold text-white">
                <i class="fas fa-edit mr-2"></i> Modifier la leçon
            </h2>
        </div>

        <form action="{{ route('admin.auto-ecole.lecons.update', $lecon) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Chapitre *</label>
                    <select name="chapitre_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500">
                        @foreach($chapitres as $chapitre)
                        <option value="{{ $chapitre->id }}" {{ old('chapitre_id', $lecon->chapitre_id) == $chapitre->id ? 'selected' : '' }}>
                            {{ $chapitre->module->nom ?? '' }} > {{ $chapitre->nom }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Titre de la leçon *</label>
                    <input type="text" name="titre" value="{{ old('titre', $lecon->titre) }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 @error('titre') border-red-500 @enderror">
                    @error('titre')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ordre d'affichage *</label>
                    <input type="number" name="ordre" value="{{ old('ordre', $lecon->ordre) }}" required min="0"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Durée (minutes) *</label>
                    <input type="number" name="duree_minutes" value="{{ old('duree_minutes', $lecon->duree_minutes) }}" required min="1"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Contenu texte</label>
                <textarea name="contenu_texte" rows="8"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500">{{ old('contenu_texte', $lecon->contenu_texte) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-video text-red-500 mr-1"></i> URL Vidéo
                    </label>
                    <input type="url" name="url_video" value="{{ old('url_video', $lecon->url_video) }}"
                        placeholder="https://youtube.com/..."
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-link text-blue-500 mr-1"></i> URL Web
                    </label>
                    <input type="url" name="url_web" value="{{ old('url_web', $lecon->url_web) }}"
                        placeholder="https://..."
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500">
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="active" id="active" value="1" {{ old('active', $lecon->active) ? 'checked' : '' }}
                    class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                <label for="active" class="ml-3 text-sm font-medium text-gray-700">Leçon active</label>
            </div>

            <!-- Boutons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.auto-ecole.lecons.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    Annuler
                </a>
                <button type="submit" class="btn-primary text-white px-6 py-2.5 rounded-xl font-medium hover:shadow-lg transition-all">
                    <i class="fas fa-save mr-2"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
