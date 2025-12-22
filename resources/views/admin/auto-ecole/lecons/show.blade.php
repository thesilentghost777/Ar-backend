@extends('layouts.admin')

@section('title', $lecon->titre)
@section('page-title', 'Aperçu de la leçon')

@section('admin-content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="{{ route('admin.auto-ecole.lecons.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary-600">
            <i class="fas fa-arrow-left mr-2"></i> Retour aux leçons
        </a>
        <a href="{{ route('admin.auto-ecole.lecons.edit', $lecon) }}" class="btn-primary text-white px-4 py-2 rounded-xl font-medium hover:shadow-lg transition-all">
            <i class="fas fa-edit mr-2"></i> Modifier
        </a>
    </div>

    <!-- Leçon Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-6">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-white/20 text-white">
                            {{ $lecon->chapitre->module->nom ?? 'Module' }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-white/20 text-white">
                            {{ $lecon->chapitre->nom ?? 'Chapitre' }}
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold text-white">{{ $lecon->titre }}</h2>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm {{ $lecon->active ? 'bg-white/30 text-white' : 'bg-red-500/50 text-white' }}">
                    {{ $lecon->active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="flex items-center space-x-4 mt-4 text-white/80">
                <span><i class="fas fa-sort-numeric-up mr-1"></i> Ordre {{ $lecon->ordre }}</span>
                <span><i class="fas fa-clock mr-1"></i> {{ $lecon->duree_minutes }} minutes</span>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Contenu texte -->
            @if($lecon->contenu_texte)
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-3">
                    <i class="fas fa-file-alt text-primary-500 mr-2"></i> Contenu
                </h3>
                <div class="prose max-w-none p-4 bg-gray-50 rounded-xl text-gray-700">
                    {!! nl2br(e($lecon->contenu_texte)) !!}
                </div>
            </div>
            @endif

            <!-- Ressources -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($lecon->url_video)
                <a href="{{ $lecon->url_video }}" target="_blank" class="flex items-center p-4 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center mr-4">
                        <i class="fas fa-video text-red-600 text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900">Vidéo de la leçon</p>
                        <p class="text-sm text-gray-500 truncate">{{ $lecon->url_video }}</p>
                    </div>
                    <i class="fas fa-external-link-alt text-red-600 group-hover:translate-x-1 transition-transform"></i>
                </a>
                @endif

                @if($lecon->url_web)
                <a href="{{ $lecon->url_web }}" target="_blank" class="flex items-center p-4 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mr-4">
                        <i class="fas fa-link text-blue-600 text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900">Ressource web</p>
                        <p class="text-sm text-gray-500 truncate">{{ $lecon->url_web }}</p>
                    </div>
                    <i class="fas fa-external-link-alt text-blue-600 group-hover:translate-x-1 transition-transform"></i>
                </a>
                @endif
            </div>

            @if(!$lecon->contenu_texte && !$lecon->url_video && !$lecon->url_web)
            <div class="text-center py-8">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-file-alt text-2xl text-gray-400"></i>
                </div>
                <p class="text-gray-500">Aucun contenu n'a été ajouté à cette leçon</p>
                <a href="{{ route('admin.auto-ecole.lecons.edit', $lecon) }}" class="btn-primary text-white px-4 py-2 rounded-xl text-sm font-medium inline-flex items-center mt-4">
                    <i class="fas fa-plus mr-1"></i> Ajouter du contenu
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
