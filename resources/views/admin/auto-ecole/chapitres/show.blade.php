@extends('layouts.admin')

@section('title', $chapitre->nom)
@section('page-title', $isFrench ?? true ? 'Détails du Chapitre' : 'Chapter Details')

@section('admin-content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
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

    <!-- Header Card -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-teal-500 to-teal-600">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="text-white">
                    <h2 class="text-2xl font-bold">{{ $chapitre->nom }}</h2>
                    <p class="text-teal-100 mt-1">
                        <i class="fas fa-book mr-1"></i> {{ $chapitre->module->nom }}
                    </p>
                </div>
                <div class="flex space-x-3 mt-4 md:mt-0">
                    <a href="{{ route('admin.auto-ecole.chapitres.edit', $chapitre) }}"
                       class="px-4 py-2 bg-white/20 text-white rounded-lg hover:bg-white/30 transition">
                        <i class="fas fa-edit mr-1"></i> {{ $isFrench ?? true ? 'Modifier' : 'Edit' }}
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-3xl font-bold text-gray-800">{{ $chapitre->ordre }}</div>
                    <div class="text-sm text-gray-500">{{ $isFrench ?? true ? 'Ordre' : 'Order' }}</div>
                </div>
                <div class="text-center p-4 bg-indigo-50 rounded-lg">
                    <div class="text-3xl font-bold text-indigo-600">{{ $chapitre->lecons->count() }}</div>
                    <div class="text-sm text-indigo-500">{{ $isFrench ?? true ? 'Leçons' : 'Lessons' }}</div>
                </div>
                <div class="text-center p-4 bg-amber-50 rounded-lg">
                    <div class="text-3xl font-bold text-amber-600">{{ $chapitre->quiz->count() }}</div>
                    <div class="text-sm text-amber-500">Quiz</div>
                </div>
                <div class="text-center p-4 {{ $chapitre->active ? 'bg-green-50' : 'bg-gray-50' }} rounded-lg">
                    <div class="text-3xl font-bold {{ $chapitre->active ? 'text-green-600' : 'text-gray-600' }}">
                        <i class="fas {{ $chapitre->active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                    </div>
                    <div class="text-sm {{ $chapitre->active ? 'text-green-500' : 'text-gray-500' }}">
                        {{ $chapitre->active ? ($isFrench ?? true ? 'Actif' : 'Active') : ($isFrench ?? true ? 'Inactif' : 'Inactive') }}
                    </div>
                </div>
            </div>

            @if($chapitre->description)
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h4 class="font-medium text-gray-700 mb-2">Description</h4>
                    <p class="text-gray-600">{{ $chapitre->description }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Leçons -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-graduation-cap text-indigo-500 mr-2"></i>
                {{ $isFrench ?? true ? 'Leçons' : 'Lessons' }} ({{ $chapitre->lecons->count() }})
            </h3>
            <a href="{{ route('admin.auto-ecole.lecons.create', ['chapitre_id' => $chapitre->id]) }}"
               class="px-3 py-1.5 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-1"></i> {{ $isFrench ?? true ? 'Ajouter' : 'Add' }}
            </a>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($chapitre->lecons as $lecon)
                <div class="p-4 hover:bg-gray-50 transition flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <span class="w-8 h-8 flex items-center justify-center bg-indigo-100 text-indigo-600 rounded-full font-semibold text-sm">
                            {{ $lecon->ordre }}
                        </span>
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $lecon->titre }}</h4>
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-clock mr-1"></i> {{ $lecon->duree_minutes }} min
                                @if($lecon->url_video)
                                    <span class="ml-2"><i class="fas fa-video text-blue-500"></i></span>
                                @endif
                                @if($lecon->url_web)
                                    <span class="ml-2"><i class="fas fa-link text-green-500"></i></span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if(!$lecon->active)
                            <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">{{ $isFrench ?? true ? 'Inactif' : 'Inactive' }}</span>
                        @endif
                        <a href="{{ route('admin.auto-ecole.lecons.edit', $lecon) }}" class="p-2 text-gray-400 hover:text-primary-600">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="fas fa-book-open text-3xl mb-2 text-gray-300"></i>
                    <p>{{ $isFrench ?? true ? 'Aucune leçon dans ce chapitre' : 'No lessons in this chapter' }}</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Quiz -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-question-circle text-amber-500 mr-2"></i>
                Quiz ({{ $chapitre->quiz->count() }})
            </h3>
            <a href="{{ route('admin.auto-ecole.quiz.create', ['chapitre_id' => $chapitre->id]) }}"
               class="px-3 py-1.5 text-sm bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">
                <i class="fas fa-plus mr-1"></i> {{ $isFrench ?? true ? 'Ajouter' : 'Add' }}
            </a>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($chapitre->quiz as $quiz)
                <div class="p-4 hover:bg-gray-50 transition flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <span class="w-10 h-10 flex items-center justify-center bg-amber-100 text-amber-600 rounded-full">
                            <i class="fas fa-question"></i>
                        </span>
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $quiz->titre }}</h4>
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-list-ol mr-1"></i> {{ $quiz->questions->count() }} questions
                                <span class="mx-2">•</span>
                                <i class="fas fa-clock mr-1"></i> {{ $quiz->duree_minutes }} min
                                <span class="mx-2">•</span>
                                <i class="fas fa-star mr-1"></i> {{ $quiz->note_passage }}/20
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if(!$quiz->active)
                            <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">{{ $isFrench ?? true ? 'Inactif' : 'Inactive' }}</span>
                        @endif
                        <a href="{{ route('admin.auto-ecole.quiz.edit', $quiz) }}" class="p-2 text-gray-400 hover:text-primary-600">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="fas fa-question-circle text-3xl mb-2 text-gray-300"></i>
                    <p>{{ $isFrench ?? true ? 'Aucun quiz dans ce chapitre' : 'No quizzes in this chapter' }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
