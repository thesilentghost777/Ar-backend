@extends('layouts.admin')

@section('title', $module->nom)
@section('page-title', $module->nom)

@section('admin-content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="{{ route('admin.auto-ecole.modules.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary-600">
            <i class="fas fa-arrow-left mr-2"></i> Retour aux modules
        </a>
        <a href="{{ route('admin.auto-ecole.modules.edit', $module) }}" class="btn-primary text-white px-4 py-2 rounded-xl font-medium hover:shadow-lg transition-all">
            <i class="fas fa-edit mr-2"></i> Modifier
        </a>
    </div>

    <!-- Module Info -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r {{ $module->type === 'theorique' ? 'from-blue-500 to-blue-600' : 'from-green-500 to-green-600' }} px-6 py-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="fas {{ $module->type === 'theorique' ? 'fa-book' : 'fa-car' }} text-white text-2xl"></i>
                </div>
                <div class="text-white">
                    <h2 class="text-2xl font-bold">{{ $module->nom }}</h2>
                    <div class="flex items-center space-x-3 mt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-white/20">
                            {{ ucfirst($module->type) }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-white/20">
                            {{ strtoupper(str_replace('_', ' ', $module->type_permis ?? 'tous')) }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm {{ $module->active ? 'bg-white/30' : 'bg-red-500/50' }}">
                            {{ $module->active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>
            </div>
            @if($module->description)
            <p class="text-white/80 mt-4">{{ $module->description }}</p>
            @endif
        </div>
    </div>

    <!-- Chapitres -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-layer-group text-primary-500 mr-2"></i> Chapitres ({{ $module->chapitres->count() }})
            </h3>
            <a href="{{ route('admin.auto-ecole.chapitres.create', ['module_id' => $module->id]) }}" class="btn-primary text-white px-4 py-2 rounded-xl text-sm font-medium">
                <i class="fas fa-plus mr-1"></i> Ajouter
            </a>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($module->chapitres as $chapitre)
            <div class="p-6 hover:bg-gray-50 transition-colors">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3">
                            <span class="w-8 h-8 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-sm">
                                {{ $chapitre->ordre }}
                            </span>
                            <h4 class="text-lg font-medium text-gray-900">{{ $chapitre->nom }}</h4>
                        </div>
                        @if($chapitre->description)
                        <p class="text-sm text-gray-500 mt-2 ml-11">{{ Str::limit($chapitre->description, 100) }}</p>
                        @endif
                        <p class="text-sm text-gray-400 mt-2 ml-11">
                            <i class="fas fa-file-alt mr-1"></i> {{ $chapitre->lecons->count() }} leçons
                            @if($chapitre->quiz)
                            <span class="ml-3"><i class="fas fa-question-circle mr-1"></i> Quiz disponible</span>
                            @endif
                        </p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.auto-ecole.chapitres.edit', $chapitre) }}" class="w-8 h-8 rounded-lg bg-primary-100 text-primary-600 hover:bg-primary-200 flex items-center justify-center">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Leçons du chapitre -->
                @if($chapitre->lecons->count() > 0)
                <div class="mt-4 ml-11 space-y-2">
                    @foreach($chapitre->lecons as $lecon)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <span class="w-6 h-6 rounded bg-gray-200 text-gray-600 flex items-center justify-center text-xs font-medium">
                                {{ $lecon->ordre }}
                            </span>
                            <span class="text-sm text-gray-700">{{ $lecon->titre }}</span>
                            <span class="text-xs text-gray-400">{{ $lecon->duree_minutes }} min</span>
                        </div>
                        <a href="{{ route('admin.auto-ecole.lecons.edit', $lecon) }}" class="text-primary-600 hover:text-primary-700 text-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @empty
            <div class="p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-layer-group text-2xl text-gray-400"></i>
                </div>
                <p class="text-gray-500">Aucun chapitre dans ce module</p>
                <a href="{{ route('admin.auto-ecole.chapitres.create', ['module_id' => $module->id]) }}" class="btn-primary text-white px-4 py-2 rounded-xl text-sm font-medium inline-flex items-center mt-4">
                    <i class="fas fa-plus mr-1"></i> Créer le premier chapitre
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
