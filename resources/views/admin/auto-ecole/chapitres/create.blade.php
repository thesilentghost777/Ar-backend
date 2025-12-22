@extends('layouts.admin')

@section('title', $isFrench ?? true ? 'Nouveau Chapitre' : 'New Chapter')
@section('page-title', $isFrench ?? true ? 'Nouveau Chapitre' : 'New Chapter')

@section('admin-content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb Navigation -->
    <nav class="mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm">
            <li>
                <a href="{{ route('admin.auto-ecole.chapitres.index') }}"
                   class="flex items-center text-gray-600 hover:text-teal-600 transition-colors duration-200">
                    <i class="fas fa-bookmark mr-2"></i>
                    <span>{{ $isFrench ?? true ? 'Chapitres' : 'Chapters' }}</span>
                </a>
            </li>
            <li class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                <span class="text-gray-900 font-medium">{{ $isFrench ?? true ? 'Nouveau' : 'New' }}</span>
            </li>
        </ol>
    </nav>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <!-- Card Header -->
        <div class="px-8 py-6 bg-gradient-to-r from-teal-500 via-teal-600 to-cyan-600">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-12 h-12 bg-white/20 rounded-xl backdrop-blur-sm">
                    <i class="fas fa-plus-circle text-2xl text-white"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-bold text-white">
                        {{ $isFrench ?? true ? 'Créer un nouveau chapitre' : 'Create a new chapter' }}
                    </h3>
                    <p class="text-teal-100 text-sm mt-1">
                        {{ $isFrench ?? true ? 'Remplissez les informations ci-dessous' : 'Fill in the information below' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <form action="{{ route('admin.auto-ecole.chapitres.store') }}" method="POST" class="p-8">
            @csrf

            <div class="space-y-8">
                <!-- Module Selection -->
                <div class="form-group">
                    <label for="module_id" class="block text-sm font-semibold text-gray-800 mb-2">
                        Module <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="module_id" id="module_id" required
                                class="w-full px-4 py-3 pr-10 rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition-all duration-200 appearance-none bg-white @error('module_id') border-red-300 focus:border-red-500 focus:ring-red-100 @enderror">
                            <option value="">{{ $isFrench ?? true ? '-- Sélectionner un module --' : '-- Select a module --' }}</option>
                            @foreach($modules as $module)
                                <option value="{{ $module->id }}" {{ old('module_id', $moduleSelectionne) == $module->id ? 'selected' : '' }}>
                                    {{ $module->nom }} • {{ ucfirst($module->type) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </div>
                    @error('module_id')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Chapter Name -->
                <div class="form-group">
                    <label for="nom" class="block text-sm font-semibold text-gray-800 mb-2">
                        {{ $isFrench ?? true ? 'Nom du chapitre' : 'Chapter name' }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                           placeholder="{{ $isFrench ?? true ? 'Ex: Le code de la route' : 'Ex: The highway code' }}"
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition-all duration-200 placeholder-gray-400 @error('nom') border-red-300 focus:border-red-500 focus:ring-red-100 @enderror">
                    @error('nom')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">
                        Description
                        <span class="text-gray-500 font-normal ml-1">({{ $isFrench ?? true ? 'Optionnel' : 'Optional' }})</span>
                    </label>
                    <textarea name="description" id="description" rows="5"
                              placeholder="{{ $isFrench ?? true ? 'Décrivez le contenu et les objectifs de ce chapitre...' : 'Describe the content and objectives of this chapter...' }}"
                              class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition-all duration-200 placeholder-gray-400 resize-none @error('description') border-red-300 focus:border-red-500 focus:ring-red-100 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Order and Active Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Display Order -->
                    <div class="form-group">
                        <label for="ordre" class="block text-sm font-semibold text-gray-800 mb-2">
                            {{ $isFrench ?? true ? 'Ordre d\'affichage' : 'Display order' }} <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="ordre" id="ordre" value="{{ old('ordre', 0) }}" min="0" required
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition-all duration-200 @error('ordre') border-red-300 focus:border-red-500 focus:ring-red-100 @enderror">
                        <p class="mt-2 text-xs text-gray-500">
                            {{ $isFrench ?? true ? 'Position du chapitre dans la liste (0 = premier)' : 'Chapter position in the list (0 = first)' }}
                        </p>
                        @error('ordre')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Active Status Toggle -->
                    <div class="form-group">
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            {{ $isFrench ?? true ? 'Statut' : 'Status' }}
                        </label>
                        <div class="flex items-center h-12 px-4 bg-gray-50 rounded-xl border-2 border-gray-200">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="active" value="1" class="sr-only peer" {{ old('active', true) ? 'checked' : '' }}>
                                <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-teal-200 rounded-full peer transition-all duration-300 peer-checked:after:translate-x-7 peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all after:shadow-sm peer-checked:bg-teal-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-700">
                                    {{ $isFrench ?? true ? 'Chapitre actif' : 'Active chapter' }}
                                </span>
                            </label>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            {{ $isFrench ?? true ? 'Les chapitres inactifs ne sont pas visibles aux étudiants' : 'Inactive chapters are not visible to students' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-8 mt-8 border-t-2 border-gray-100">
                <a href="{{ route('admin.auto-ecole.chapitres.index') }}"
                   class="inline-flex items-center px-6 py-3 text-gray-700 font-medium bg-gray-100 rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-200 transition-all duration-200">
                    <i class="fas fa-times mr-2"></i>
                    {{ $isFrench ?? true ? 'Annuler' : 'Cancel' }}
                </a>
                <button type="submit"
                        class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 text-white font-semibold rounded-xl hover:from-teal-700 hover:to-cyan-700 focus:outline-none focus:ring-4 focus:ring-teal-200 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i>
                    {{ $isFrench ?? true ? 'Créer le chapitre' : 'Create chapter' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
