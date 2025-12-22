@extends('layouts.admin')

@section('title', $isFrench ?? true ? 'Codes Caisse' : 'Cash Codes')
@section('page-title', $isFrench ?? true ? 'Gestion des Codes Caisse' : 'Cash Code Management')

@section('admin-content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-100 font-medium">{{ $isFrench ?? true ? 'Total générés' : 'Total generated' }}</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_generes']) }}</p>
                </div>
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-100 font-medium">{{ $isFrench ?? true ? 'Utilisés' : 'Used' }}</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['utilises']) }}</p>
                </div>
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-amber-100 font-medium">{{ $isFrench ?? true ? 'Disponibles' : 'Available' }}</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['disponibles']) }}</p>
                </div>
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <i class="fas fa-hourglass-half text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-100 font-medium">{{ $isFrench ?? true ? 'Montant total' : 'Total amount' }}</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['montant_total']) }} F</p>
                </div>
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Header & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">{{ $isFrench ?? true ? 'Codes Caisse' : 'Cash Codes' }}</h2>
            <p class="text-gray-600 mt-1">{{ $isFrench ?? true ? 'Générez et gérez les codes de recharge' : 'Generate and manage recharge codes' }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.auto-ecole.codes-caisse.export') }}"
               class="inline-flex items-center px-5 py-2.5 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium shadow-sm">
                <i class="fas fa-download mr-2"></i>
                {{ $isFrench ?? true ? 'Exporter CSV' : 'Export CSV' }}
            </a>
            <a href="{{ route('admin.auto-ecole.codes-caisse.create') }}"
               class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-plus-circle mr-2"></i>
                {{ $isFrench ?? true ? 'Générer des codes' : 'Generate codes' }}
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100">
        <form method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="{{ $isFrench ?? true ? 'Rechercher un code...' : 'Search a code...' }}"
                           class="w-full pl-10 pr-4 py-2.5 rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 focus:ring-2">
                </div>
            </div>
            <div class="sm:w-52">
                <select name="status" onchange="this.form.submit()"
                        class="w-full py-2.5 rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 focus:ring-2">
                    <option value="">{{ $isFrench ?? true ? 'Tous les statuts' : 'All statuses' }}</option>
                    <option value="disponible" {{ request('status') === 'disponible' ? 'selected' : '' }}>
                        {{ $isFrench ?? true ? 'Disponible' : 'Available' }}
                    </option>
                    <option value="utilise" {{ request('status') === 'utilise' ? 'selected' : '' }}>
                        {{ $isFrench ?? true ? 'Utilisé' : 'Used' }}
                    </option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-all duration-200 font-medium shadow-sm hover:shadow-md">
                <i class="fas fa-search mr-2"></i> {{ $isFrench ?? true ? 'Filtrer' : 'Filter' }}
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">{{ $isFrench ?? true ? 'Montant' : 'Amount' }}</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">{{ $isFrench ?? true ? 'Statut' : 'Status' }}</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">{{ $isFrench ?? true ? 'Utilisateur' : 'User' }}</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">{{ $isFrench ?? true ? 'Créé par' : 'Created by' }}</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">{{ $isFrench ?? true ? 'Date' : 'Date' }}</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($codes as $code)
                        <tr class="hover:bg-orange-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <code class="px-3 py-2 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 rounded-lg font-mono text-sm font-bold shadow-sm border border-gray-300">
                                        {{ $code->code }}
                                    </code>
                                    <button onclick="copyToClipboard('{{ $code->code }}')"
                                            class="p-2 text-gray-400 hover:text-orange-600 hover:bg-orange-100 rounded-lg transition-all duration-200" title="Copier">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-lg text-gray-900">{{ number_format($code->montant) }} <span class="text-sm text-gray-500">F</span></span>
                            </td>
                            <td class="px-6 py-4">
                                @if($code->utilise)
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                        <i class="fas fa-check-circle mr-1.5"></i> {{ $isFrench ?? true ? 'Utilisé' : 'Used' }}
                                    </span>
                                @elseif($code->expire_at && $code->expire_at < now())
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                        <i class="fas fa-times-circle mr-1.5"></i> {{ $isFrench ?? true ? 'Expiré' : 'Expired' }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                        <i class="fas fa-clock mr-1.5"></i> {{ $isFrench ?? true ? 'Disponible' : 'Available' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($code->user)
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-sm mr-3 shadow-md">
                                            {{ substr($code->user->prenom, 0, 1) }}{{ substr($code->user->nom, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $code->user->prenom }} {{ $code->user->nom }}</div>
                                            <div class="text-xs text-gray-500">{{ $code->user->telephone }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($code->createur)
                                    <span class="text-gray-700 font-medium">{{ $code->createur->name }}</span>
                                @else
                                    <span class="text-gray-400 italic">{{ $isFrench ?? true ? 'Système' : 'System' }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700 font-medium">{{ $code->created_at ? $code->created_at->format('d/m/Y H:i') : '-' }}</div>
                                @if($code->utilise_at)
                                    <div class="text-xs text-green-600 mt-1 flex items-center">
                                        <i class="fas fa-check mr-1"></i>{{ $code->utilise_at->format('d/m/Y H:i') }}
                                    </div>
                                @elseif($code->expire_at)
                                    <div class="text-xs {{ $code->expire_at < now() ? 'text-red-600' : 'text-amber-600' }} mt-1 flex items-center">
                                        <i class="fas fa-hourglass-end mr-1"></i>{{ $code->expire_at->format('d/m/Y') }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">

                                    @if(!$code->utilise)
                                        <button type="button" onclick="confirmDelete({{ $code->id }})"
                                                class="p-2.5 text-red-600 hover:bg-red-100 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $code->id }}"
                                              action="{{ route('admin.auto-ecole.codes-caisse.destroy', $code) }}"
                                              method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-ticket-alt text-5xl text-gray-300"></i>
                                    </div>
                                    <p class="text-gray-500 text-lg font-medium">{{ $isFrench ?? true ? 'Aucun code caisse trouvé' : 'No cash codes found' }}</p>
                                    <p class="text-gray-400 text-sm mt-2">{{ $isFrench ?? true ? 'Commencez par générer des codes' : 'Start by generating codes' }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($codes->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $codes->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({
                icon: 'success',
                title: '{{ $isFrench ?? true ? "Code copié !" : "Code copied!" }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        });
    }

    function confirmDelete(codeId) {
        Swal.fire({
            title: '{{ $isFrench ?? true ? "Êtes-vous sûr ?" : "Are you sure?" }}',
            text: '{{ $isFrench ?? true ? "Cette action est irréversible !" : "This action cannot be undone!" }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '{{ $isFrench ?? true ? "Oui, supprimer" : "Yes, delete" }}',
            cancelButtonText: '{{ $isFrench ?? true ? "Annuler" : "Cancel" }}'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + codeId).submit();
            }
        });
    }
</script>
@endsection
