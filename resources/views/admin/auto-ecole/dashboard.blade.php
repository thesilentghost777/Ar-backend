@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@section('admin-content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        <div class="stat-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Utilisateurs</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_utilisateurs']) }}</p>
                    <p class="text-sm text-green-600 mt-2">
                        <i class="fas fa-arrow-up mr-1"></i>
                        +{{ $stats['utilisateurs_mois'] }} ce mois
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Dépôts</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_depots']) }} <span class="text-lg">FCFA</span></p>
                    <p class="text-sm text-green-600 mt-2">
                        <i class="fas fa-arrow-up mr-1"></i>
                        +{{ number_format($stats['depots_mois']) }} ce mois
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-white text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Modules de cours</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_modules'] }}</p>
                    <p class="text-sm text-blue-600 mt-2">
                        <i class="fas fa-book mr-1"></i>
                        Actifs
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                    <i class="fas fa-book-open text-white text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Quiz Réussis</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['quiz_passes']) }}</p>
                    <p class="text-sm text-purple-600 mt-2">
                        <i class="fas fa-check-circle mr-1"></i>
                        {{ $stats['sessions_actives'] }} sessions actives
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                    <i class="fas fa-trophy text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Répartition par niveau -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-chart-pie text-primary-500 mr-2"></i>
                Répartition par niveau de parrainage
            </h3>
            <div class="h-64">
                <canvas id="niveauxChart"></canvas>
            </div>
        </div>
        <!-- Paiements récents graphique -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-chart-line text-green-500 mr-2"></i>
                Évolution des inscriptions
            </h3>
            <div class="h-64">
                <canvas id="inscriptionsChart"></canvas>
            </div>
        </div>
    </div>
    <!-- Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Utilisateurs récents -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-user-plus text-primary-500 mr-2"></i>
                    Nouveaux utilisateurs
                </h3>
                <a href="{{ route('admin.auto-ecole.users.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Voir tout <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($utilisateursRecents as $user)
                    <a href="{{ route('admin.auto-ecole.users.show', $user) }}" class="flex items-center px-6 py-4 hover:bg-primary-50/50 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr($user->prenom ?? 'U', 0, 1)) }}
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $user->prenom }} {{ $user->nom }}</p>
                            <p class="text-xs text-gray-500">{{ $user->telephone }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->type_permis === 'permis_b' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ strtoupper(str_replace('_', ' ', $user->type_permis)) }}
                            </span>
                            <p class="text-xs text-gray-400 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-users text-4xl text-gray-300 mb-3"></i>
                        <p>Aucun utilisateur récent</p>
                    </div>
                @endforelse
            </div>
        </div>
        <!-- Paiements récents -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-credit-card text-green-500 mr-2"></i>
                    Paiements récents
                </h3>
                <a href="{{ route('admin.auto-ecole.paiements.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Voir tout <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($paiementsRecents as $paiement)
                    <a href="{{ route('admin.auto-ecole.paiements.show', $paiement) }}" class="flex items-center px-6 py-4 hover:bg-green-50/50 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                            <i class="fas fa-money-bill text-white"></i>
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $paiement->user->prenom ?? 'N/A' }} {{ $paiement->user->nom ?? '' }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $paiement->type)) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-green-600">+{{ number_format($paiement->montant) }} FCFA</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $paiement->created_at->diffForHumans() }}</p>
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-credit-card text-4xl text-gray-300 mb-3"></i>
                        <p>Aucun paiement récent</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique Niveaux
    const niveauxData = @json($repartitionNiveaux);
    const niveauxLabels = niveauxData.map(item => 'Niveau ' + item.niveau_parrainage);
    const niveauxValues = niveauxData.map(item => item.total);
    new Chart(document.getElementById('niveauxChart'), {
        type: 'doughnut',
        data: {
            labels: niveauxLabels,
            datasets: [{
                data: niveauxValues,
                backgroundColor: [
                    '#f59e0b',
                    '#d97706',
                    '#b45309',
                    '#92400e',
                    '#78350f'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Graphique inscriptions
    const inscriptionsLabels = @json($inscriptionsLabels);
    const inscriptionsValues = @json($inscriptionsData);
    new Chart(document.getElementById('inscriptionsChart'), {
        type: 'line',
        data: {
            labels: inscriptionsLabels,
            datasets: [{
                label: 'Inscriptions',
                data: inscriptionsValues,
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endpush
