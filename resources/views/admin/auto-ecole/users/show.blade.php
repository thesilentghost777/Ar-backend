@extends('layouts.admin')

@section('title', 'Détails utilisateur')
@section('page-title', 'Profil de ' . $user->prenom . ' ' . $user->nom)

@section('admin-content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="{{ route('admin.auto-ecole.users.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary-600">
            <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
        </a>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.auto-ecole.users.edit', $user) }}" class="btn-primary text-white px-4 py-2 rounded-xl font-medium hover:shadow-lg transition-all">
                <i class="fas fa-edit mr-2"></i> Modifier
            </a>
            <button onclick="deleteUser({{ $user->id }})" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl font-medium transition-all">
                <i class="fas fa-trash mr-2"></i> Supprimer
            </button>
        </div>
    </div>

    <!-- Profil Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-8">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <div class="w-24 h-24 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center">
                    <span class="text-4xl font-bold text-white">{{ strtoupper(substr($user->prenom ?? 'U', 0, 1)) }}{{ strtoupper(substr($user->nom ?? '', 0, 1)) }}</span>
                </div>
                <div class="text-center sm:text-left text-white">
                    <h2 class="text-2xl font-bold">{{ $user->prenom }} {{ $user->nom }}</h2>
                    <p class="text-white/80 mt-1">{{ $user->telephone }}</p>
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20">
                            <i class="fas fa-id-card mr-1"></i> {{ strtoupper(str_replace('_', ' ', $user->type_permis)) }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20">
                            <i class="fas fa-layer-group mr-1"></i> Niveau {{ $user->niveau_parrainage ?? 1 }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20">
                            <i class="fas fa-key mr-1"></i> {{ $user->code_parrainage }}
                        </span>
                    </div>
                </div>
                <div class="sm:ml-auto text-center">
                    <p class="text-white/60 text-sm">Solde</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($user->solde ?? 0) }}</p>
                    <p class="text-white/80">FCFA</p>
                </div>
            </div>
        </div>

        <!-- Informations détaillées -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-100 pb-2">
                    <i class="fas fa-user text-primary-500 mr-2"></i> Informations personnelles
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Quartier</span>
                        <span class="font-medium text-gray-900">{{ $user->quartier ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Type de cours</span>
                        <span class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $user->type_cours)) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Vague</span>
                        <span class="font-medium text-gray-900">{{ $user->vague }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Inscrit le</span>
                        <span class="font-medium text-gray-900">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-100 pb-2">
                    <i class="fas fa-calendar text-blue-500 mr-2"></i> Session & Centre
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Session</span>
                        <span class="font-medium text-gray-900">{{ $user->session->nom ?? 'Non assigné' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Centre d'examen</span>
                        <span class="font-medium text-gray-900">{{ $user->centreExamen->nom ?? 'Non assigné' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Parrain</span>
                        <span class="font-medium text-gray-900">{{ $user->parrain ? $user->parrain->prenom . ' ' . $user->parrain->nom : 'Aucun' }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-gray-500">Lieux de pratique</span>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @forelse($user->lieuxPratique as $lieu)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-map-marker-alt mr-1"></i> {{ $lieu->nom }}
                                </span>
                            @empty
                                <span class="text-sm text-gray-500">Aucun lieu assigné</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-100 pb-2">
                    <i class="fas fa-money-bill text-green-500 mr-2"></i> Status des frais
                </h3>
                <div class="space-y-3">
                    @php
                        $fraisTypes = [
                            'formation' => 'Formation',
                            'inscription' => 'Inscription',
                            'examen_blanc' => 'Examen blanc',
                            'examen' => 'Examen'
                        ];
                    @endphp
                    @foreach($fraisTypes as $key => $label)
                    @php
                        $statusField = match($key) {
                            'formation' => 'status_frais_formation',
                            'inscription' => 'status_frais_inscription',
                            'examen_blanc' => 'status_examen_blanc',
                            'examen' => 'status_frais_examen'
                        };
                        $status = $user->{$statusField} ?? 'non_paye';
                    @endphp
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">{{ $label }}</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $status === 'paye' ? 'bg-green-100 text-green-800' : ($status === 'dispense' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs de données -->
    <div x-data="{ activeTab: 'filleuls' }" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Tab Headers -->
        <div class="border-b border-gray-100 flex overflow-x-auto">
            <button @click="activeTab = 'filleuls'" :class="activeTab === 'filleuls' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="px-6 py-4 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">
                <i class="fas fa-users mr-2"></i> Filleuls ({{ $filleuls->count() }})
            </button>
            <button @click="activeTab = 'quiz'" :class="activeTab === 'quiz' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="px-6 py-4 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">
                <i class="fas fa-question-circle mr-2"></i> Résultats Quiz ({{ $resultatsQuiz->count() }})
            </button>
            <button @click="activeTab = 'progression'" :class="activeTab === 'progression' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="px-6 py-4 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">
                <i class="fas fa-tasks mr-2"></i> Progression ({{ $progressionLecons->count() }})
            </button>
        </div>

        <!-- Tab Contents -->
        <div class="p-6">
            <!-- Filleuls -->
            <div x-show="activeTab === 'filleuls'" class="space-y-4">
                @forelse($filleuls as $filleul)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold">
                            {{ strtoupper(substr($filleul->filleul->prenom ?? 'U', 0, 1)) }}
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">{{ $filleul->filleul->prenom ?? '' }} {{ $filleul->filleul->nom ?? '' }}</p>
                            <p class="text-sm text-gray-500">{{ $filleul->filleul->telephone ?? '' }}</p>
                        </div>
                    </div>
                    <span class="text-sm text-gray-500">{{ $filleul->created_at->format('d/m/Y') }}</span>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-users text-4xl text-gray-300 mb-3"></i>
                    <p>Aucun filleul</p>
                </div>
                @endforelse
            </div>

            <!-- Résultats Quiz -->
            <div x-show="activeTab === 'quiz'" x-cloak class="space-y-4">
                @forelse($resultatsQuiz as $resultat)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div>
                        <p class="font-medium text-gray-900">{{ $resultat->quiz->titre ?? 'Quiz' }}</p>
                        <p class="text-sm text-gray-500">{{ $resultat->quiz->chapitre->module->nom ?? '' }} > {{ $resultat->quiz->chapitre->nom ?? '' }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $resultat->reussi ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $resultat->note }}/20
                        </span>
                        <p class="text-xs text-gray-500 mt-1">{{ $resultat->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-question-circle text-4xl text-gray-300 mb-3"></i>
                    <p>Aucun quiz passé</p>
                </div>
                @endforelse
            </div>

            <!-- Progression -->
            <div x-show="activeTab === 'progression'" x-cloak class="space-y-4">
                @forelse($progressionLecons as $progression)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">{{ $progression->lecon->titre ?? 'Leçon' }}</p>
                            <p class="text-sm text-gray-500">{{ $progression->lecon->chapitre->module->nom ?? '' }} > {{ $progression->lecon->chapitre->nom ?? '' }}</p>
                        </div>
                    </div>
                    <span class="text-sm text-gray-500">{{ $progression->date_completion ? $progression->date_completion->format('d/m/Y') : $progression->updated_at->format('d/m/Y') }}</span>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-tasks text-4xl text-gray-300 mb-3"></i>
                    <p>Aucune leçon complétée</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


        <!-- Réinitialiser mot de passe -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-key text-red-500 mr-2"></i> Réinitialiser le mot de passe
            </h3>
            <form action="{{ route('admin.auto-ecole.users.reset-password', $user) }}" method="POST" class="space-y-4">
                @csrf
                <input type="password" name="password" required minlength="6" placeholder="Nouveau mot de passe" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <input type="password" name="password_confirmation" required minlength="6" placeholder="Confirmer le mot de passe" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2.5 rounded-xl font-medium transition-all">
                    Réinitialiser
                </button>
            </form>
        </div>
    </div>
</div>

<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function deleteUser(id) {
    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/auto-ecole/users/${id}`;
            form.submit();
        }
    });
}
</script>
@endpush
