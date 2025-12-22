@extends('layouts.admin')

@section('title', 'Paiements')
@section('page-title', 'Gestion des paiements')

@section('admin-content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total dépôts</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_depots']) }} <span class="text-sm">FCFA</span></p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Dépôts aujourd'hui</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['depots_jour']) }} <span class="text-sm">FCFA</span></p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-calendar-day text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Transferts</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_transferts']) }} <span class="text-sm">FCFA</span></p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                    <i class="fas fa-exchange-alt text-purple-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Frais collectés</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_frais']) }} <span class="text-sm">FCFA</span></p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-primary-100 flex items-center justify-center">
                    <i class="fas fa-percentage text-primary-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.auto-ecole.paiements.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, téléphone..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Tous</option>
                        <option value="depot" {{ request('type') === 'depot' ? 'selected' : '' }}>Dépôt</option>
                        <option value="transfert_sortant" {{ request('type') === 'transfert_sortant' ? 'selected' : '' }}>Transfert sortant</option>
                        <option value="transfert_entrant" {{ request('type') === 'transfert_entrant' ? 'selected' : '' }}>Transfert entrant</option>
                        <option value="paiement_frais" {{ request('type') === 'paiement_frais' ? 'selected' : '' }}>Paiement frais</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Tous</option>
                        <option value="valide" {{ request('status') === 'valide' ? 'selected' : '' }}>Validé</option>
                        <option value="en_attente" {{ request('status') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="echoue" {{ request('status') === 'echoue' ? 'selected' : '' }}>Échoué</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date début</label>
                    <input type="date" name="date_debut" value="{{ request('date_debut') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date fin</label>
                    <input type="date" name="date_fin" value="{{ request('date_fin') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full btn-primary text-white px-4 py-2 rounded-xl font-medium">
                        <i class="fas fa-filter mr-2"></i> Filtrer
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Utilisateur</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Montant</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Méthode</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($paiements as $paiement)
                    <tr class="hover:bg-primary-50/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold">
                                    {{ strtoupper(substr($paiement->user->prenom ?? 'U', 0, 1)) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $paiement->user->prenom ?? '' }} {{ $paiement->user->nom ?? '' }}</p>
                                    <p class="text-xs text-gray-500">{{ $paiement->reference }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $typeColors = [
                                    'depot' => 'bg-green-100 text-green-800',
                                    'transfert_sortant' => 'bg-red-100 text-red-800',
                                    'transfert_entrant' => 'bg-blue-100 text-blue-800',
                                    'paiement_frais' => 'bg-purple-100 text-purple-800',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $typeColors[$paiement->type] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst(str_replace('_', ' ', $paiement->type)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold {{ $paiement->type === 'depot' || $paiement->type === 'transfert_entrant' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $paiement->type === 'depot' || $paiement->type === 'transfert_entrant' ? '+' : '-' }}{{ number_format($paiement->montant) }} FCFA
                            </p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $paiement->methode ?? 'N/A')) }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'valide' => 'bg-green-100 text-green-800',
                                    'en_attente' => 'bg-yellow-100 text-yellow-800',
                                    'echoue' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$paiement->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst(str_replace('_', ' ', $paiement->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">{{ $paiement->created_at->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $paiement->created_at->format('H:i') }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.auto-ecole.paiements.show', $paiement) }}" class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 inline-flex items-center justify-center transition-colors">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                    <i class="fas fa-credit-card text-2xl text-gray-400"></i>
                                </div>
                                <p class="text-gray-500 font-medium">Aucun paiement trouvé</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($paiements->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $paiements->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
