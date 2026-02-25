{{-- resources/views/admin/cni/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Gestion des CNI')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap');

    body { font-family: 'DM Sans', sans-serif; }
    .font-display { font-family: 'Syne', sans-serif; }

    .stat-card { transition: all 0.2s ease; }
    .stat-card:hover { transform: translateY(-2px); }

    .table-row-hover { transition: background 0.15s ease; }

    .badge-chip {
        letter-spacing: 0.03em;
        font-size: 0.72rem;
    }

    .btn-action {
        transition: all 0.15s ease;
    }
    .btn-action:hover {
        transform: translateX(2px);
    }
</style>
@endpush

@section('admin-content')
<div class="min-h-screen bg-slate-50 px-6 py-8">

    {{-- En-tête --}}
    <div class="flex items-start justify-between mb-8">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow-md shadow-indigo-200">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                    </svg>
                </div>
                <h1 class="font-display text-2xl font-bold text-slate-800 tracking-tight">Gestion des CNI</h1>
            </div>
            <p class="text-slate-400 text-sm ml-[52px]">Vérification et validation des pièces d'identité des apprenants</p>
        </div>
    </div>

    {{-- Alertes --}}
    @if(session('success'))
    <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 mb-6 text-sm font-medium">
        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm font-medium">
        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Statistiques --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-8">

        {{-- Total --}}
        <div class="stat-card bg-white rounded-2xl p-5 shadow-sm border border-slate-100 text-center">
            <div class="font-display text-3xl font-bold text-slate-800 mb-0.5">{{ $stats['total'] }}</div>
            <div class="text-slate-400 text-xs font-medium uppercase tracking-wide">Total</div>
        </div>

        {{-- Sans CNI --}}
        <a href="{{ route('admin.auto-ecole.cni.index', ['statut' => 'sans_cni']) }}" class="stat-card bg-white rounded-2xl p-5 shadow-sm border border-slate-100 text-center block group">
            <div class="font-display text-3xl font-bold text-slate-500 mb-0.5 group-hover:text-slate-700 transition-colors">{{ $stats['sans_cni'] }}</div>
            <div class="text-slate-400 text-xs font-medium uppercase tracking-wide">Sans CNI</div>
        </a>

        {{-- En attente --}}
        <a href="{{ route('admin.auto-ecole.cni.index', ['statut' => 'en_attente']) }}" class="stat-card bg-amber-50 rounded-2xl p-5 shadow-sm border border-amber-100 text-center block group">
            <div class="font-display text-3xl font-bold text-amber-500 mb-0.5 group-hover:text-amber-600 transition-colors">{{ $stats['en_attente'] }}</div>
            <div class="text-amber-400 text-xs font-medium uppercase tracking-wide">En attente</div>
        </a>

        {{-- Validées --}}
        <a href="{{ route('admin.auto-ecole.cni.index', ['statut' => 'valide']) }}" class="stat-card bg-emerald-50 rounded-2xl p-5 shadow-sm border border-emerald-100 text-center block group">
            <div class="font-display text-3xl font-bold text-emerald-500 mb-0.5 group-hover:text-emerald-600 transition-colors">{{ $stats['valide'] }}</div>
            <div class="text-emerald-400 text-xs font-medium uppercase tracking-wide">Validées</div>
        </a>

        {{-- Rejetées --}}
        <a href="{{ route('admin.auto-ecole.cni.index', ['statut' => 'rejete']) }}" class="stat-card bg-red-50 rounded-2xl p-5 shadow-sm border border-red-100 text-center block group">
            <div class="font-display text-3xl font-bold text-red-400 mb-0.5 group-hover:text-red-500 transition-colors">{{ $stats['rejete'] }}</div>
            <div class="text-red-300 text-xs font-medium uppercase tracking-wide">Rejetées</div>
        </a>

    </div>

    {{-- Filtres --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 mb-6">
        <form method="GET" action="{{ route('admin.auto-ecole.cni.index') }}" class="flex flex-wrap gap-3 items-end">

            <div class="flex-1 min-w-[220px]">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Rechercher</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                    <input type="text" name="search"
                           class="w-full pl-9 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all"
                           placeholder="Nom, prénom ou téléphone..."
                           value="{{ request('search') }}">
                </div>
            </div>

            <div class="min-w-[180px]">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Statut CNI</label>
                <select name="statut" class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all appearance-none cursor-pointer">
                    <option value="">Tous les statuts</option>
                    <option value="sans_cni"   {{ request('statut') === 'sans_cni'   ? 'selected' : '' }}>Sans CNI</option>
                    <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="valide"     {{ request('statut') === 'valide'     ? 'selected' : '' }}>Validée</option>
                    <option value="rejete"     {{ request('statut') === 'rejete'     ? 'selected' : '' }}>Rejetée</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm shadow-indigo-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    Filtrer
                </button>
                <a href="{{ route('admin.auto-ecole.cni.index') }}"
                   class="inline-flex items-center justify-center w-10 h-10 border border-slate-200 text-slate-400 hover:text-slate-600 hover:border-slate-300 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </div>

        </form>
    </div>

    {{-- Tableau --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/70">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider w-12">#</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Apprenant</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Téléphone</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Permis</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Statut CNI</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Soumis le</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Traité le</th>
                        <th class="text-center px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($utilisateurs as $user)
                    <tr class="table-row-hover hover:bg-slate-50/50 group">
                        <td class="px-6 py-4 text-slate-300 text-xs font-mono">{{ $user->id }}</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                    <span class="text-indigo-600 font-semibold text-xs">{{ strtoupper(substr($user->prenom, 0, 1)) }}{{ strtoupper(substr($user->nom, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-700">{{ $user->prenom }} {{ $user->nom }}</div>
                                    @if($user->quartier)
                                        <div class="text-xs text-slate-400">{{ $user->quartier }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-slate-500 font-medium text-sm">{{ $user->telephone }}</td>
                        <td class="px-4 py-4">
                            <span class="badge-chip inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 font-semibold uppercase">
                                {{ str_replace('permis_', '', $user->type_permis) }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            @if($user->cni)
                                @php $statut = $user->cni->statut; @endphp
                                @if($statut === 'en_attente')
                                    <span class="badge-chip inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-100 text-amber-700 font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                        En attente
                                    </span>
                                @elseif($statut === 'valide')
                                    <span class="badge-chip inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-700 font-semibold">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Validée
                                    </span>
                                @else
                                    <span class="badge-chip inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-red-100 text-red-600 font-semibold">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        Rejetée
                                    </span>
                                @endif
                            @else
                                <span class="badge-chip inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-400 font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                    Non soumise
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-slate-400 text-xs tabular-nums">
                            {{ $user->cni?->soumis_at?->format('d/m/Y') ?? '—' }}
                            @if($user->cni?->soumis_at)
                                <div class="text-slate-300">{{ $user->cni->soumis_at->format('H:i') }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-slate-400 text-xs tabular-nums">
                            {{ $user->cni?->traite_at?->format('d/m/Y') ?? '—' }}
                            @if($user->cni?->traite_at)
                                <div class="text-slate-300">{{ $user->cni->traite_at->format('H:i') }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->cni)
                                <a href="{{ route('admin.auto-ecole.cni.show', $user) }}"
                                   class="btn-action inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Voir CNI
                                </a>
                            @else
                                <span class="text-slate-300 text-xs">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-16 text-slate-300">
                            <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4m16 0l-2-4H6l-2 4"/>
                            </svg>
                            <p class="font-medium text-slate-400 text-sm">Aucun apprenant trouvé</p>
                            <p class="text-xs text-slate-300 mt-1">Essayez de modifier vos filtres</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($utilisateurs->hasPages())
        <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            <div class="text-xs text-slate-400">
                Affichage de
                <span class="font-semibold text-slate-600">{{ $utilisateurs->firstItem() }}</span>
                à
                <span class="font-semibold text-slate-600">{{ $utilisateurs->lastItem() }}</span>
                sur
                <span class="font-semibold text-slate-600">{{ $utilisateurs->total() }}</span>
                résultats
            </div>
            <div class="pagination-tailwind">
                {{ $utilisateurs->links() }}
            </div>
        </div>
        @endif
    </div>

</div>
@endsection