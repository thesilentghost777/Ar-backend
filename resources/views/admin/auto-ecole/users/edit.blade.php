@extends('layouts.admin')

@section('title', 'Modifier utilisateur')
@section('page-title', 'Modifier ' . $user->prenom . ' ' . $user->nom)

@section('admin-content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.auto-ecole.users.show', $user) }}" class="inline-flex items-center text-gray-600 hover:text-primary-600">
            <i class="fas fa-arrow-left mr-2"></i> Retour au profil
        </a>
    </div>

    <!-- Formulaire -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
            <h2 class="text-xl font-semibold text-white">
                <i class="fas fa-user-edit mr-2"></i> Modifier les informations
            </h2>
        </div>

        <form action="{{ route('admin.auto-ecole.users.update', $user) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Informations personnelles -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                    <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('prenom') border-red-500 @enderror">
                    @error('prenom')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                    <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nom') border-red-500 @enderror">
                    @error('nom')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                    <input type="text" name="telephone" value="{{ old('telephone', $user->telephone) }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('telephone') border-red-500 @enderror">
                    @error('telephone')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quartier</label>
                    <input type="text" name="quartier" value="{{ old('quartier', $user->quartier) }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>

            <!-- Type de permis et cours -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de permis *</label>
                    <select name="type_permis" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="permis_a" {{ old('type_permis', $user->type_permis) === 'permis_a' ? 'selected' : '' }}>Permis A (Moto)</option>
                        <option value="permis_b" {{ old('type_permis', $user->type_permis) === 'permis_b' ? 'selected' : '' }}>Permis B (Voiture)</option>
                        <option value="permis_t" {{ old('type_permis', $user->type_permis) === 'permis_t' ? 'selected' : '' }}>Permis T (Transport)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de cours *</label>
                    <select name="type_cours" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="en_ligne" {{ old('type_cours', $user->type_cours) === 'en_ligne' ? 'selected' : '' }}>En ligne</option>
                        <option value="presentiel" {{ old('type_cours', $user->type_cours) === 'presentiel' ? 'selected' : '' }}>Présentiel</option>
                        <option value="les_deux" {{ old('type_cours', $user->type_cours) === 'les_deux' ? 'selected' : '' }}>Les deux</option>
                    </select>
                </div>
            </div>

            <!-- Session et Centre -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Session</label>
                    <select name="session_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Aucune session</option>
                        @foreach($sessions as $session)
                        <option value="{{ $session->id }}" {{ old('session_id', $user->session_id) == $session->id ? 'selected' : '' }}>{{ $session->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Centre d'examen</label>
                    <select name="centre_examen_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Aucun centre</option>
                        @foreach($centresExamen as $centre)
                        <option value="{{ $centre->id }}" {{ old('centre_examen_id', $user->centre_examen_id) == $centre->id ? 'selected' : '' }}>{{ $centre->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vague *</label>
                    <select name="vague" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="1" {{ old('vague', $user->vague) == 1 ? 'selected' : '' }}>Vague 1</option>
                        <option value="2" {{ old('vague', $user->vague) == 2 ? 'selected' : '' }}>Vague 2</option>
                    </select>
                </div>
            </div>

            <!-- Lieux de pratique -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-map-marker-alt mr-1"></i> Lieux de pratique
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($lieuxPratique as $lieu)
                    <label class="flex items-center p-3 border border-gray-300 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors">
                        <input type="checkbox"
                               name="lieux_pratique[]"
                               value="{{ $lieu->id }}"
                               {{ in_array($lieu->id, old('lieux_pratique', $user->lieuxPratique->pluck('id')->toArray())) ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-700">{{ $lieu->nom }}</span>
                    </label>
                    @endforeach
                </div>
                @error('lieux_pratique')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Validation -->
            <div class="flex items-center">
                <input type="checkbox" name="validated" id="validated" value="1" {{ old('validated', $user->validated) ? 'checked' : '' }}
                    class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                <label for="validated" class="ml-3 text-sm font-medium text-gray-700">Compte validé</label>
            </div>

            <!-- Boutons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.auto-ecole.users.show', $user) }}" class="px-6 py-2.5 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition-colors">
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
