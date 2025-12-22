@extends('layouts.admin')

@section('title', 'Configuration')
@section('page-title', $isFrench ?? true ? 'Configuration Auto-École' : 'Driving School Configuration')

@section('admin-content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Configuration</h2>
            <p class="text-gray-600">{{ $isFrench ?? true ? 'Paramètres généraux de l\'auto-école' : 'General driving school settings' }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Frais de formation -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-500 to-green-600">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-money-bill-wave mr-2"></i>
                    {{ $isFrench ?? true ? 'Frais de Formation' : 'Training Fees' }}
                </h3>
            </div>

            <form action="{{ route('admin.auto-ecole.config.frais') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $isFrench ?? true ? 'Frais de formation' : 'Training fee' }} (FCFA)
                    </label>
                    <input type="number" name="frais_formation" value="{{ old('frais_formation', $config->frais_formation) }}"
                           min="0" step="100" required
                           class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $isFrench ?? true ? 'Frais d\'inscription' : 'Registration fee' }} (FCFA)
                    </label>
                    <input type="number" name="frais_inscription" value="{{ old('frais_inscription', $config->frais_inscription) }}"
                           min="0" step="100" required
                           class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $isFrench ?? true ? 'Frais examen blanc' : 'Mock exam fee' }} (FCFA)
                    </label>
                    <input type="number" name="frais_examen_blanc" value="{{ old('frais_examen_blanc', $config->frais_examen_blanc) }}"
                           min="0" step="100" required
                           class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $isFrench ?? true ? 'Frais d\'examen' : 'Exam fee' }} (FCFA)
                    </label>
                    <input type="number" name="frais_examen" value="{{ old('frais_examen', $config->frais_examen) }}"
                           min="0" step="100" required
                           class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $isFrench ?? true ? 'Dépôt minimum' : 'Minimum deposit' }} (FCFA)
                    </label>
                    <input type="number" name="depot_minimum" value="{{ old('depot_minimum', $config->depot_minimum) }}"
                           min="1000" step="100" required
                           class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                </div>

                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-save mr-2"></i>
                    {{ $isFrench ?? true ? 'Enregistrer les frais' : 'Save fees' }}
                </button>
            </form>
        </div>

        <!-- Configuration générale -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-500 to-blue-600">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-cog mr-2"></i>
                    {{ $isFrench ?? true ? 'Configuration Générale' : 'General Configuration' }}
                </h3>
            </div>

            <form action="{{ route('admin.auto-ecole.config.general') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $isFrench ?? true ? 'Code parrainage par défaut' : 'Default referral code' }}
                    </label>
                    <input type="text" name="code_parrainage_defaut" value="{{ old('code_parrainage_defaut', $config->code_parrainage_defaut) }}"
                           placeholder="Ex: PROMO2024"
                           class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                    <p class="mt-1 text-sm text-gray-500">{{ $isFrench ?? true ? 'Utilisé quand aucun parrain n\'est spécifié' : 'Used when no sponsor is specified' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $isFrench ?? true ? 'WhatsApp Support' : 'Support WhatsApp' }}
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fab fa-whatsapp text-green-500"></i>
                        </span>
                        <input type="text" name="whatsapp_support" value="{{ old('whatsapp_support', $config->whatsapp_support) }}"
                               placeholder="237xxxxxxxxx"
                               class="w-full pl-10 rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $isFrench ?? true ? 'Lien téléchargement App' : 'App download link' }}
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-link"></i>
                        </span>
                        <input type="url" name="lien_telechargement_app" value="{{ old('lien_telechargement_app', $config->lien_telechargement_app) }}"
                               placeholder="https://play.google.com/..."
                               class="w-full pl-10 rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>

                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>
                    {{ $isFrench ?? true ? 'Enregistrer la configuration' : 'Save configuration' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Centres d'examen -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden" x-data="{ showForm: false }">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-building text-purple-500 mr-2"></i>
                {{ $isFrench ?? true ? 'Centres d\'Examen' : 'Exam Centers' }} ({{ $centresExamen->count() }})
            </h3>
            <button @click="showForm = !showForm"
                    class="px-3 py-1.5 text-sm bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-plus mr-1"></i> {{ $isFrench ?? true ? 'Ajouter' : 'Add' }}
            </button>
        </div>

        <!-- Add Form -->
        <div x-show="showForm" x-cloak class="p-4 bg-purple-50 border-b border-purple-200">
            <form action="{{ route('admin.auto-ecole.config.store-centre-examen') }}" method="POST" class="flex flex-wrap gap-4 items-end">
                @csrf
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFrench ?? true ? 'Nom' : 'Name' }} *</label>
                    <input type="text" name="nom" required class="w-full rounded-lg border-gray-300 text-sm">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFrench ?? true ? 'Adresse' : 'Address' }}</label>
                    <input type="text" name="adresse" class="w-full rounded-lg border-gray-300 text-sm">
                </div>
                <div class="w-32">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFrench ?? true ? 'Ville' : 'City' }}</label>
                    <input type="text" name="ville" class="w-full rounded-lg border-gray-300 text-sm">
                </div>
                <div class="flex items-center">
                    <label class="flex items-center">
                        <input type="checkbox" name="active" value="1" checked class="rounded border-gray-300 text-primary-600">
                        <span class="ml-2 text-sm text-gray-700">{{ $isFrench ?? true ? 'Actif' : 'Active' }}</span>
                    </label>
                </div>
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm">
                    <i class="fas fa-save mr-1"></i> {{ $isFrench ?? true ? 'Ajouter' : 'Add' }}
                </button>
            </form>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($centresExamen as $centre)
                <div class="px-6 py-3 flex items-center justify-between hover:bg-gray-50" x-data="{ editing: false }">
                    <div x-show="!editing" class="flex items-center space-x-4 flex-1">
                        <span class="w-8 h-8 flex items-center justify-center {{ $centre->active ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400' }} rounded-full">
                            <i class="fas fa-building"></i>
                        </span>
                        <div>
                            <span class="font-medium text-gray-900">{{ $centre->nom }}</span>
                            @if($centre->ville)
                                <span class="text-gray-500 text-sm ml-2">{{ $centre->ville }}</span>
                            @endif
                        </div>
                    </div>

                    <div x-show="!editing" class="flex items-center space-x-2">
                        <button @click="editing = true" class="p-2 text-gray-400 hover:text-primary-600">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('admin.auto-ecole.config.destroy-centre-examen', $centre->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce centre ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Edit Form -->
                    <form x-show="editing" x-cloak action="{{ route('admin.auto-ecole.config.update-centre-examen', $centre->id) }}" method="POST" class="flex-1 flex items-center gap-3">
                        @csrf
                        @method('PUT')
                        <input type="text" name="nom" value="{{ $centre->nom }}" required class="flex-1 rounded-lg border-gray-300 text-sm">
                        <input type="text" name="adresse" value="{{ $centre->adresse }}" placeholder="Adresse" class="flex-1 rounded-lg border-gray-300 text-sm">
                        <input type="text" name="ville" value="{{ $centre->ville }}" placeholder="Ville" class="w-32 rounded-lg border-gray-300 text-sm">
                        <label class="flex items-center">
                            <input type="checkbox" name="active" value="1" {{ $centre->active ? 'checked' : '' }} class="rounded border-gray-300 text-primary-600">
                            <span class="ml-1 text-sm">{{ $isFrench ?? true ? 'Actif' : 'Active' }}</span>
                        </label>
                        <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded">
                            <i class="fas fa-check"></i>
                        </button>
                        <button type="button" @click="editing = false" class="p-2 text-gray-400 hover:bg-gray-100 rounded">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-gray-500">
                    <i class="fas fa-building text-3xl mb-2 text-gray-300"></i>
                    <p>{{ $isFrench ?? true ? 'Aucun centre d\'examen' : 'No exam centers' }}</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Lieux de pratique -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden" x-data="{ showForm: false }">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                {{ $isFrench ?? true ? 'Lieux de Pratique' : 'Practice Locations' }} ({{ $lieuxPratique->count() }})
            </h3>
            <button @click="showForm = !showForm"
                    class="px-3 py-1.5 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-plus mr-1"></i> {{ $isFrench ?? true ? 'Ajouter' : 'Add' }}
            </button>
        </div>

        <!-- Add Form -->
        <div x-show="showForm" x-cloak class="p-4 bg-red-50 border-b border-red-200">
            <form action="{{ route('admin.auto-ecole.config.store-lieu-pratique') }}" method="POST" class="flex flex-wrap gap-4 items-end">
                @csrf
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFrench ?? true ? 'Nom' : 'Name' }} *</label>
                    <input type="text" name="nom" required class="w-full rounded-lg border-gray-300 text-sm">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFrench ?? true ? 'Adresse' : 'Address' }}</label>
                    <input type="text" name="adresse" class="w-full rounded-lg border-gray-300 text-sm">
                </div>
                <div class="w-32">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFrench ?? true ? 'Ville' : 'City' }}</label>
                    <input type="text" name="ville" class="w-full rounded-lg border-gray-300 text-sm">
                </div>
                <div class="flex items-center">
                    <label class="flex items-center">
                        <input type="checkbox" name="active" value="1" checked class="rounded border-gray-300 text-primary-600">
                        <span class="ml-2 text-sm text-gray-700">{{ $isFrench ?? true ? 'Actif' : 'Active' }}</span>
                    </label>
                </div>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                    <i class="fas fa-save mr-1"></i> {{ $isFrench ?? true ? 'Ajouter' : 'Add' }}
                </button>
            </form>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($lieuxPratique as $lieu)
                <div class="p-4" x-data="{ showJours: false, addJour: false, editing: false }">
                    <div class="flex items-center justify-between">
                        <div x-show="!editing" class="flex items-center space-x-4 flex-1">
                            <span class="w-10 h-10 flex items-center justify-center {{ $lieu->active ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-400' }} rounded-full">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <div>
                                <span class="font-medium text-gray-900">{{ $lieu->nom }}</span>
                                @if($lieu->ville)
                                    <span class="text-gray-500 text-sm ml-2">{{ $lieu->ville }}</span>
                                @endif
                                <span class="ml-2 text-xs px-2 py-0.5 rounded-full {{ $lieu->active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $lieu->joursPratique->count() }} {{ $isFrench ?? true ? 'jours' : 'days' }}
                                </span>
                            </div>
                        </div>

                        <!-- Edit Form -->
                        <form x-show="editing" x-cloak action="{{ route('admin.auto-ecole.config.update-lieu-pratique', $lieu->id) }}" method="POST" class="flex-1 flex items-center gap-3">
                            @csrf
                            @method('PUT')
                            <input type="text" name="nom" value="{{ $lieu->nom }}" required class="flex-1 rounded-lg border-gray-300 text-sm">
                            <input type="text" name="adresse" value="{{ $lieu->adresse }}" placeholder="Adresse" class="flex-1 rounded-lg border-gray-300 text-sm">
                            <input type="text" name="ville" value="{{ $lieu->ville }}" placeholder="Ville" class="w-32 rounded-lg border-gray-300 text-sm">
                            <label class="flex items-center">
                                <input type="checkbox" name="active" value="1" {{ $lieu->active ? 'checked' : '' }} class="rounded border-gray-300 text-primary-600">
                                <span class="ml-1 text-sm">{{ $isFrench ?? true ? 'Actif' : 'Active' }}</span>
                            </label>
                            <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded">
                                <i class="fas fa-check"></i>
                            </button>
                            <button type="button" @click="editing = false" class="p-2 text-gray-400 hover:bg-gray-100 rounded">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>

                        <div x-show="!editing" class="flex items-center space-x-2">
                            <button @click="editing = true" class="p-2 text-gray-400 hover:text-primary-600">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button @click="showJours = !showJours" class="px-3 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded">
                                <i :class="showJours ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas mr-1"></i>
                                {{ $isFrench ?? true ? 'Horaires' : 'Schedule' }}
                            </button>
                            <form action="{{ route('admin.auto-ecole.config.destroy-lieu-pratique', $lieu->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce lieu ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Jours de pratique -->
                    <div x-show="showJours" x-cloak class="mt-4 pl-14 space-y-2">
                        @foreach($lieu->joursPratique as $jour)
                            <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <span class="w-20 font-medium text-gray-700 capitalize">{{ $jour->jour }}</span>
                                    <span class="text-gray-600">{{ substr($jour->heure_debut, 0, 5) }} - {{ substr($jour->heure_fin, 0, 5) }}</span>
                                    @if(!$jour->active)
                                        <span class="px-2 py-0.5 text-xs bg-gray-200 text-gray-600 rounded">{{ $isFrench ?? true ? 'Inactif' : 'Inactive' }}</span>
                                    @endif
                                </div>
                                <form action="{{ route('admin.auto-ecole.config.destroy-jour-pratique', $jour->id) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce créneau ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-gray-400 hover:text-red-600">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach

                        <!-- Add jour form -->
                        <div x-show="addJour" x-cloak class="p-3 bg-blue-50 rounded-lg">
                            <form action="{{ route('admin.auto-ecole.config.store-jour-pratique') }}" method="POST" class="flex flex-wrap gap-3 items-end">
                                @csrf
                                <input type="hidden" name="lieu_pratique_id" value="{{ $lieu->id }}">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">{{ $isFrench ?? true ? 'Jour' : 'Day' }}</label>
                                    <select name="jour" required class="rounded border-gray-300 text-sm">
                                        @foreach(['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'] as $j)
                                            <option value="{{ $j }}">{{ ucfirst($j) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">{{ $isFrench ?? true ? 'Début' : 'Start' }}</label>
                                    <input type="time" name="heure_debut" required class="rounded border-gray-300 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">{{ $isFrench ?? true ? 'Fin' : 'End' }}</label>
                                    <input type="time" name="heure_fin" required class="rounded border-gray-300 text-sm">
                                </div>
                                <div class="flex items-center">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="active" value="1" checked class="rounded border-gray-300 text-primary-600">
                                        <span class="ml-1 text-xs">{{ $isFrench ?? true ? 'Actif' : 'Active' }}</span>
                                    </label>
                                </div>
                                <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded text-sm">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button type="button" @click="addJour = false" class="px-3 py-2 bg-gray-200 text-gray-700 rounded text-sm">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>

                        <button x-show="!addJour" @click="addJour = true" class="text-sm text-blue-600 hover:text-blue-700">
                            <i class="fas fa-plus mr-1"></i> {{ $isFrench ?? true ? 'Ajouter un créneau' : 'Add a slot' }}
                        </button>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-gray-500">
                    <i class="fas fa-map-marker-alt text-3xl mb-2 text-gray-300"></i>
                    <p>{{ $isFrench ?? true ? 'Aucun lieu de pratique' : 'No practice locations' }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection
