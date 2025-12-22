@extends('layouts.admin')

@section('title', $isFrench ?? true ? 'Modifier Chapitre' : 'Edit Chapter')
@section('page-title', $isFrench ?? true ? 'Modifier Chapitre' : 'Edit Chapter')

@section('admin-content')
<div class="max-w-3xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li>
                <a href="{{ route('admin.auto-ecole.chapitres.index') }}" class="text-gray-500 hover:text-primary-600">
                    <i class="fas fa-bookmark mr-1"></i> {{ $isFrench ?? true ? 'Chapitres' : 'Chapters' }}
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                    <span class="text-gray-700 font-medium">{{ Str::limit($chapitre->nom, 30) }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-amber-500 to-amber-600">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-edit mr-2"></i>
                {{ $isFrench ?? true ? 'Modifier le chapitre' : 'Edit chapter' }}
            </h3>
        </div>

        <form action="{{ route('admin.auto-ecole.chapitres.update', $chapitre) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="module_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Module <span class="text-red-500">*</span>
                </label>
                <select name="module_id" id="module_id" required
                        class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 @error('module_id') border-red-500 @enderror">
                    <option value="">{{ $isFrench ?? true ? 'Sélectionner un module' : 'Select a module' }}</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}" {{ old('module_id', $chapitre->module_id) == $module->id ? 'selected' : '' }}>
                            {{ $module->nom }} ({{ ucfirst($module->type) }})
                        </option>
                    @endforeach
                </select>
                @error('module_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ $isFrench ?? true ? 'Nom du chapitre' : 'Chapter name' }} <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nom" id="nom" value="{{ old('nom', $chapitre->nom) }}" required
                       class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 @error('nom') border-red-500 @enderror">
                @error('nom')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    Description
                </label>
                <textarea name="description" id="description" rows="4"
                          class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 @error('description') border-red-500 @enderror">{{ old('description', $chapitre->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="ordre" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $isFrench ?? true ? 'Ordre d\'affichage' : 'Display order' }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="ordre" id="ordre" value="{{ old('ordre', $chapitre->ordre) }}" min="0" required
                           class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 @error('ordre') border-red-500 @enderror">
                    @error('ordre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center pt-6">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="active" value="1" class="sr-only peer" {{ old('active', $chapitre->active) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-700">{{ $isFrench ?? true ? 'Chapitre actif' : 'Active chapter' }}</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <form id="delete-form-{{ $chapitre->id }}"
                      action="{{ route('admin.auto-ecole.chapitres.destroy', $chapitre) }}"
                      method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            onclick="confirmDelete('delete-form-{{ $chapitre->id }}')"
                            class="px-4 py-2 text-red-600 border border-red-300 rounded-lg hover:bg-red-50 transition">
                        <i class="fas fa-trash mr-2"></i>
                        {{ $isFrench ?? true ? 'Supprimer' : 'Delete' }}
                    </button>
                </form>

                <div class="flex space-x-4">
                    <a href="{{ route('admin.auto-ecole.chapitres.index') }}"
                       class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        {{ $isFrench ?? true ? 'Annuler' : 'Cancel' }}
                    </a>
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                        <i class="fas fa-save mr-2"></i>
                        {{ $isFrench ?? true ? 'Enregistrer' : 'Save' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
