@extends('layouts.admin')

@section('title', 'Rapport mensuel')
@section('page-title', 'Rapport mensuel des paiements')

@section('admin-content')
<div class="space-y-6">
    <!-- Sélecteur de période -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.auto-ecole.paiements.rapport') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mois</label>
                <select name="mois" class="px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $mois == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Année</label>
                <select name="annee" class="px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @foreach(range(now()->year - 2, now()->year + 1) as $a)
                    <option value="{{ $a }}" {{ $annee == $a ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-primary text-white px-6 py-2.5 rounded-xl font-medium hover:shadow-lg transition-all">
                <i class="fas fa-sync mr-2"></i> Actualiser
            </button>
        </form>
    </div>

    <!-- Total du mois -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-white/80">Total des dépôts validés</p>
                <p class="text-4xl font-bold mt-2">{{ number_format($totalMois) }} FCFA</p>
                <p class="text-white/60 text-sm mt-1">
                    {{ \Carbon\Carbon::create($annee, $mois)->translatedFormat('F Y') }}
                </p>
            </div>
            <div class="w-20 h-20 rounded-2xl bg-white/20 flex items-center justify-center">
                <i class="fas fa-chart-line text-3xl"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Graphique évolution -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-chart-bar text-primary-500 mr-2"></i> Évolution journalière
            </h3>
            <div class="h-64">
                <canvas id="evolutionChart"></canvas>
            </div>
        </div>

        <!-- Frais payés -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-receipt text-green-500 mr-2"></i> Répartition des frais
            </h3>
            <div class="h-64">
                <canvas id="fraisChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tableau détaillé -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-table text-gray-500 mr-2"></i> Détails par jour
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nombre</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($depots as $depot)
                    <tr class="hover:bg-primary-50/30 transition-colors">
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($depot->date)->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($depot->date)->translatedFormat('l') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $depot->nombre }} dépôts
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-green-600">{{ number_format($depot->total) }} FCFA</p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                            Aucune donnée pour cette période
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Frais par type -->
    @if($fraisPayes->count() > 0)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-coins text-primary-500 mr-2"></i> Frais par catégorie
            </h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($fraisPayes as $frais)
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $frais->frais_type ?? 'Autre')) }}</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($frais->total) }} FCFA</p>
                <p class="text-xs text-gray-400 mt-1">{{ $frais->nombre }} paiements</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Données pour le graphique d'évolution
    const evolutionData = @json($depots);
    const labels = evolutionData.map(item => item.date);
    const totaux = evolutionData.map(item => item.total);

    new Chart(document.getElementById('evolutionChart'), {
        type: 'bar',
        data: {
            labels: labels.map(d => {
                const date = new Date(d);
                return date.getDate() + '/' + (date.getMonth() + 1);
            }),
            datasets: [{
                label: 'Dépôts (FCFA)',
                data: totaux,
                backgroundColor: 'rgba(245, 158, 11, 0.8)',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Données pour le graphique des frais
    const fraisData = @json($fraisPayes);
    if (fraisData.length > 0) {
        new Chart(document.getElementById('fraisChart'), {
            type: 'doughnut',
            data: {
                labels: fraisData.map(item => item.frais_type || 'Autre'),
                datasets: [{
                    data: fraisData.map(item => item.total),
                    backgroundColor: [
                        '#f59e0b',
                        '#10b981',
                        '#3b82f6',
                        '#8b5cf6',
                        '#ef4444'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }
});
</script>
@endpush
