@extends('layouts.admin')

@section('title', 'Modifier module')
@section('page-title', 'Modifier: ' . $module->nom)

@section('admin-content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <a href="{{ route('admin.auto-ecole.modules.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary-600">
        <i class="fas fa-arrow-left mr-2"></i> Retour aux modules
    </a>

    <!-- Formulaire -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
            <h2 class="text-xl font-semibold text-white">
                <i class="fas fa-edit mr-2"></i> Modifier le module
            </h2>
        </div>

        <form action="{{ route('admin.auto-ecole.modules.update', $module) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom du module *</label>
                <input type="text" name="nom" value="{{ old('nom', $module->nom) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nom') border-red-500 @enderror">
                @error('nom')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                    <select name="type" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="theorique" {{ old('type', $module->type) === 'theorique' ? 'selected' : '' }}>Théorique</option>
                        <option value="pratique" {{ old('type', $module->type) === 'pratique' ? 'selected' : '' }}>Pratique</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de permis *</label>
                    <select name="type_permis" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="tous" {{ old('type_permis', $module->type_permis) === 'tous' ? 'selected' : '' }}>Tous</option>
                        <option value="permis_a" {{ old('type_permis', $module->type_permis) === 'permis_a' ? 'selected' : '' }}>Permis A</option>
                        <option value="permis_b" {{ old('type_permis', $module->type_permis) === 'permis_b' ? 'selected' : '' }}>Permis B</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ordre d'affichage *</label>
                    <input type="number" name="ordre" value="{{ old('ordre', $module->ordre) }}" required min="0"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('description', $module->description) }}</textarea>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="active" id="active" value="1" {{ old('active', $module->active) ? 'checked' : '' }}
                    class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                <label for="active" class="ml-3 text-sm font-medium text-gray-700">Module actif</label>
            </div>

            <!-- Boutons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.auto-ecole.modules.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition-colors">
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
