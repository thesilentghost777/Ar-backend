@extends('layouts.admin')

@section('title', 'Détails paiement')
@section('page-title', 'Détails du paiement')

@section('admin-content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <a href="{{ route('admin.auto-ecole.paiements.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary-600">
        <i class="fas fa-arrow-left mr-2"></i> Retour aux paiements
    </a>

    <!-- Paiement Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @php
            $statusColors = [
                'valide' => 'from-green-500 to-green-600',
                'en_attente' => 'from-yellow-500 to-yellow-600',
                'echoue' => 'from-red-500 to-red-600',
            ];
            $bgColor = $statusColors[$paiement->status] ?? 'from-gray-500 to-gray-600';
        @endphp
        <div class="bg-gradient-to-r {{ $bgColor }} px-6 py-8">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <div class="w-20 h-20 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="fas fa-receipt text-white text-3xl"></i>
                </div>
                <div class="text-center sm:text-left text-white flex-1">
                    <p class="text-white/80 text-sm">Référence</p>
                    <h2 class="text-2xl font-bold">{{ $paiement->reference }}</h2>
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-white/20">
                            {{ ucfirst(str_replace('_', ' ', $paiement->type)) }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-white/20">
                            {{ ucfirst(str_replace('_', ' ', $paiement->status)) }}
                        </span>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-white/60 text-sm">Montant</p>
                    <p class="text-4xl font-bold text-white">{{ number_format($paiement->montant) }}</p>
                    <p class="text-white/80">FCFA</p>
                </div>
            </div>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Utilisateur -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-100 pb-2">
                    <i class="fas fa-user text-primary-500 mr-2"></i> Utilisateur
                </h3>
                <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                    <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold">
                        {{ strtoupper(substr($paiement->user->prenom ?? 'U', 0, 1)) }}
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900">{{ $paiement->user->prenom ?? '' }} {{ $paiement->user->nom ?? '' }}</p>
                        <p class="text-sm text-gray-500">{{ $paiement->user->telephone ?? '' }}</p>
                    </div>
                    <a href="{{ route('admin.auto-ecole.users.show', $paiement->user) }}" class="ml-auto text-primary-600 hover:text-primary-700">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>

                @if($paiement->destinataire)
                <h4 class="text-sm font-medium text-gray-600 mt-4">Destinataire</h4>
                <div class="flex items-center p-4 bg-blue-50 rounded-xl">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                        {{ strtoupper(substr($paiement->destinataire->prenom ?? 'D', 0, 1)) }}
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900">{{ $paiement->destinataire->prenom ?? '' }} {{ $paiement->destinataire->nom ?? '' }}</p>
                        <p class="text-sm text-gray-500">{{ $paiement->destinataire->telephone ?? '' }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Détails -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-100 pb-2">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i> Détails
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-500">Méthode</span>
                        <span class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $paiement->methode ?? 'N/A')) }}</span>
                    </div>
                    <div class="flex justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-500">Solde avant</span>
                        <span class="font-medium text-gray-900">{{ number_format($paiement->solde_avant ?? 0) }} FCFA</span>
                    </div>
                    <div class="flex justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-500">Solde après</span>
                        <span class="font-medium text-gray-900">{{ number_format($paiement->solde_apres ?? 0) }} FCFA</span>
                    </div>
                    <div class="flex justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-500">Date</span>
                        <span class="font-medium text-gray-900">{{ $paiement->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($paiement->description)
        <div class="px-6 pb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                <i class="fas fa-comment text-gray-500 mr-2"></i> Description
            </h3>
            <p class="text-gray-600 p-4 bg-gray-50 rounded-xl">{{ $paiement->description }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
