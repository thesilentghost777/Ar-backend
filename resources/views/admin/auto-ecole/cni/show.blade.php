{{-- resources/views/admin/cni/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'CNI de ' . $user->prenom . ' ' . $user->nom)

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap');
    body { font-family: 'DM Sans', sans-serif; }
    .font-display { font-family: 'Syne', sans-serif; }

    .img-zoom {
        transition: transform 0.3s ease;
        cursor: zoom-in;
    }
    .img-zoom:hover { transform: scale(1.02); }

    .action-btn { transition: all 0.15s ease; }
    .action-btn:hover { transform: translateY(-1px); }

    /* Lightbox overlay */
    #lightbox-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.92);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 16px;
        padding: 24px;
    }
    #lightbox-overlay.active { display: flex; }
</style>
@endpush

@section('admin-content')
<div class="min-h-screen bg-slate-50 px-6 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6">
        <a href="{{ route('admin.auto-ecole.cni.index') }}"
           class="hover:text-indigo-600 transition-colors font-medium flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
            </svg>
            Gestion CNI
        </a>
        <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-slate-600 font-semibold">{{ $user->prenom }} {{ $user->nom }}</span>
    </nav>

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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Colonne gauche ── --}}
        <div class="space-y-5">

            {{-- Carte apprenant --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

                {{-- Header avec avatar --}}
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 px-5 pt-6 pb-10 relative">
                    <p class="text-indigo-200 text-xs font-semibold uppercase tracking-wider mb-4">Apprenant</p>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center flex-shrink-0 shadow-lg">
                            <span class="font-display text-white font-bold text-xl">
                                {{ strtoupper(substr($user->prenom,0,1)) }}{{ strtoupper(substr($user->nom,0,1)) }}
                            </span>
                        </div>
                        <div>
                            <h2 class="font-display text-white font-bold text-lg leading-tight">
                                {{ $user->prenom }} {{ $user->nom }}
                            </h2>
                            <p class="text-indigo-200 text-sm">{{ $user->telephone }}</p>
                        </div>
                    </div>
                </div>

                {{-- Permis badge flottant --}}
                <div class="px-5 -mt-4 mb-1">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white rounded-xl shadow-md border border-slate-100 text-xs font-bold text-slate-700 uppercase tracking-wide">
                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                        </svg>
                        Permis {{ strtoupper(str_replace('permis_', '', $user->type_permis)) }}
                    </span>
                </div>

                {{-- Infos --}}
                <div class="px-5 py-4 space-y-3">
                    @php
                        $infos = [
                            ['label' => 'Date de naissance', 'value' => $user->date_naissance?->format('d/m/Y') ?? '—'],
                            ['label' => 'Quartier',          'value' => $user->quartier ?? '—'],
                            ['label' => 'Type de cours',     'value' => ucfirst(str_replace('_', ' ', $user->type_cours))],
                            ['label' => 'Inscrit le',        'value' => $user->created_at->format('d/m/Y')],
                        ];
                    @endphp
                    @foreach($infos as $info)
                    <div class="flex items-center justify-between py-2 border-b border-slate-50 last:border-0">
                        <span class="text-xs text-slate-400 font-medium">{{ $info['label'] }}</span>
                        <span class="text-xs font-semibold text-slate-700">{{ $info['value'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Carte statut & actions --}}
            @if($cni)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span class="font-display font-semibold text-sm text-slate-700">Statut de la CNI</span>
                </div>

                <div class="px-5 py-4">
                    {{-- Badge statut --}}
                    <div class="flex justify-center mb-4">
                        @if($cni->statut === 'en_attente')
                            <div class="flex flex-col items-center gap-2 px-6 py-4 rounded-2xl bg-amber-50 border border-amber-100 w-full">
                                <span class="w-3 h-3 rounded-full bg-amber-400 animate-pulse"></span>
                                <span class="font-display font-bold text-amber-600 text-sm">En attente de traitement</span>
                            </div>
                        @elseif($cni->statut === 'valide')
                            <div class="flex flex-col items-center gap-2 px-6 py-4 rounded-2xl bg-emerald-50 border border-emerald-100 w-full">
                                <svg class="w-6 h-6 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-display font-bold text-emerald-600 text-sm">CNI Validée</span>
                            </div>
                        @else
                            <div class="flex flex-col items-center gap-2 px-6 py-4 rounded-2xl bg-red-50 border border-red-100 w-full">
                                <svg class="w-6 h-6 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-display font-bold text-red-500 text-sm">CNI Rejetée</span>
                            </div>
                        @endif
                    </div>

                    {{-- Motif rejet --}}
                    @if($cni->motif_rejet)
                    <div class="bg-red-50 border border-red-100 rounded-xl px-4 py-3 mb-4 text-xs text-red-600">
                        <p class="font-semibold mb-1">Motif du rejet</p>
                        <p class="leading-relaxed">{{ $cni->motif_rejet }}</p>
                    </div>
                    @endif

                    {{-- Dates --}}
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-400">Soumis le</span>
                            <span class="text-xs font-semibold text-slate-600 tabular-nums">
                                {{ $cni->soumis_at?->format('d/m/Y H:i') ?? '—' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-400">Traité le</span>
                            <span class="text-xs font-semibold text-slate-600 tabular-nums">
                                {{ $cni->traite_at?->format('d/m/Y H:i') ?? '—' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="px-5 pb-5 space-y-2.5">
                    @if($cni->statut !== 'valide')
                        <form action="{{ route('admin.auto-ecole.cni.valider', $user) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    onclick="return confirm('Valider la CNI de {{ $user->prenom }} {{ $user->nom }} ?')"
                                    class="action-btn w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-emerald-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Valider la CNI
                            </button>
                        </form>
                    @endif

                    @if($cni->statut !== 'rejete')
                        <button type="button" onclick="document.getElementById('modalRejet').classList.add('active')"
                                class="action-btn w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-xl shadow-sm shadow-red-200 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Rejeter la CNI
                        </button>
                    @endif

                    @if($cni->statut !== 'en_attente')
                        <form action="{{ route('admin.auto-ecole.cni.en-attente', $user) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="action-btn w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 border border-amber-300 text-amber-600 hover:bg-amber-50 bg-white text-sm font-semibold rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Remettre en attente
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            @else
            <div class="flex items-center gap-3 bg-blue-50 border border-blue-100 text-blue-600 rounded-2xl px-5 py-4 text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Cet apprenant n'a pas encore soumis de CNI.
            </div>
            @endif

        </div>

        {{-- ── Colonne droite : images CNI ── --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden h-full">

                <div class="flex items-center gap-2 px-6 py-4 border-b border-slate-100">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="font-display font-semibold text-sm text-slate-700">Images de la CNI</span>
                </div>

                <div class="p-6">
                    @if($cni && ($cni->cni_recto_path || $cni->cni_verso_path))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Recto --}}
                            <div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="w-6 h-6 rounded-lg bg-indigo-100 flex items-center justify-center">
                                        <span class="text-indigo-600 font-bold text-xs">R</span>
                                    </span>
                                    <span class="font-semibold text-sm text-slate-700">Recto</span>
                                </div>
                                @if($cni->cni_recto_path)
                                    <div class="rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 shadow-sm"
                                         onclick="ouvrirLightbox('{{ asset('storage/' . $cni->cni_recto_path) }}', 'CNI — Recto')">
                                        <img src="{{ asset('storage/' . $cni->cni_recto_path) }}"
                                             alt="CNI Recto"
                                             class="img-zoom w-full object-cover"
                                             style="height: 240px;">
                                    </div>
                                    <div class="flex gap-2 mt-3">
                                        <button onclick="ouvrirLightbox('{{ asset('storage/' . $cni->cni_recto_path) }}', 'CNI — Recto')"
                                                class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold text-slate-600 border border-slate-200 hover:border-slate-300 hover:bg-slate-50 rounded-xl transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                            </svg>
                                            Agrandir
                                        </button>
                                        <a href="{{ asset('storage/' . $cni->cni_recto_path) }}" download
                                           class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            Télécharger
                                        </a>
                                    </div>
                                @else
                                    <div class="rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 flex flex-col items-center justify-center gap-2 text-slate-300" style="height: 240px;">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-xs font-medium">Image non soumise</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Verso --}}
                            <div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center">
                                        <span class="text-slate-500 font-bold text-xs">V</span>
                                    </span>
                                    <span class="font-semibold text-sm text-slate-700">Verso</span>
                                </div>
                                @if($cni->cni_verso_path)
                                    <div class="rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 shadow-sm"
                                         onclick="ouvrirLightbox('{{ asset('storage/' . $cni->cni_verso_path) }}', 'CNI — Verso')">
                                        <img src="{{ asset('storage/' . $cni->cni_verso_path) }}"
                                             alt="CNI Verso"
                                             class="img-zoom w-full object-cover"
                                             style="height: 240px;">
                                    </div>
                                    <div class="flex gap-2 mt-3">
                                        <button onclick="ouvrirLightbox('{{ asset('storage/' . $cni->cni_verso_path) }}', 'CNI — Verso')"
                                                class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold text-slate-600 border border-slate-200 hover:border-slate-300 hover:bg-slate-50 rounded-xl transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                            </svg>
                                            Agrandir
                                        </button>
                                        <a href="{{ asset('storage/' . $cni->cni_verso_path) }}" download
                                           class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            Télécharger
                                        </a>
                                    </div>
                                @else
                                    <div class="rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 flex flex-col items-center justify-center gap-2 text-slate-300" style="height: 240px;">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-xs font-medium">Image non soumise</p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center text-slate-300 py-20 gap-3">
                            <svg class="w-16 h-16 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="font-display font-bold text-slate-400 text-base">Aucune image disponible</p>
                            <p class="text-xs text-slate-300">L'apprenant n'a pas encore soumis ses documents.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ── Modal Rejet (custom, no Bootstrap) ── --}}
@if($cni)
<div id="modalRejet" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
     onclick="if(event.target===this) fermerModal()">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
        <form action="{{ route('admin.auto-ecole.cni.rejeter', $user) }}" method="POST">
            @csrf

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-red-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <span class="font-display font-bold text-slate-700">Rejeter la CNI</span>
                </div>
                <button type="button" onclick="fermerModal()"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-slate-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="px-6 py-5">
                <p class="text-sm text-slate-500 mb-5 leading-relaxed">
                    Vous êtes sur le point de rejeter la CNI de
                    <strong class="text-slate-700">{{ $user->prenom }} {{ $user->nom }}</strong>.
                    Veuillez indiquer le motif pour informer l'apprenant.
                </p>

                <div>
                    <label for="motif_rejet" class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-2">
                        Motif du rejet <span class="text-red-500">*</span>
                    </label>
                    <textarea name="motif_rejet" id="motif_rejet" rows="4"
                              class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all resize-none @error('motif_rejet') border-red-400 @enderror"
                              placeholder="Ex : Image floue, document expiré, photo illisible..."
                              maxlength="500" required>{{ old('motif_rejet') }}</textarea>
                    @error('motif_rejet')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <div class="flex justify-end mt-1">
                        <span class="text-xs text-slate-300"><span id="compteur">0</span>/500</span>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex gap-3 px-6 pb-6">
                <button type="button" onclick="fermerModal()"
                        class="flex-1 px-4 py-2.5 text-sm font-semibold text-slate-600 border border-slate-200 hover:bg-slate-50 rounded-xl transition-colors">
                    Annuler
                </button>
                <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-xl shadow-sm shadow-red-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Confirmer le rejet
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Lightbox --}}
<div id="lightbox-overlay" onclick="fermerLightbox()">
    <div class="flex items-center justify-between w-full max-w-4xl px-2 mb-2" onclick="event.stopPropagation()">
        <span id="lightboxTitre" class="text-white font-semibold text-sm font-display"></span>
        <button onclick="fermerLightbox()"
                class="w-8 h-8 rounded-lg flex items-center justify-center text-white/60 hover:text-white hover:bg-white/10 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <img id="lightboxImg" src="" alt="" class="rounded-2xl shadow-2xl max-h-[80vh] max-w-full object-contain"
         onclick="event.stopPropagation()">
</div>
@endif

@push('scripts')
<script>
    // Modal Rejet
    function fermerModal() {
        document.getElementById('modalRejet').classList.add('hidden');
        document.getElementById('modalRejet').classList.remove('flex');
    }
    function ouvrirModal() {
        document.getElementById('modalRejet').classList.remove('hidden');
        document.getElementById('modalRejet').classList.add('flex');
    }

    // Compteur textarea
    const textarea = document.getElementById('motif_rejet');
    const compteur = document.getElementById('compteur');
    if (textarea && compteur) {
        textarea.addEventListener('input', () => {
            compteur.textContent = textarea.value.length;
        });
    }

    // Lightbox
    function ouvrirLightbox(src, titre) {
        document.getElementById('lightboxImg').src = src;
        document.getElementById('lightboxTitre').textContent = titre;
        document.getElementById('lightbox-overlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function fermerLightbox() {
        document.getElementById('lightbox-overlay').classList.remove('active');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') { fermerLightbox(); fermerModal(); }
    });

    // Ouvrir modal rejet si erreur de validation
    @if($errors->has('motif_rejet'))
        document.addEventListener('DOMContentLoaded', () => ouvrirModal());
    @endif
</script>
@endpush

@endsection