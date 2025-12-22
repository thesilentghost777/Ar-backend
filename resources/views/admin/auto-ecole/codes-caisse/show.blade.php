@extends('layouts.admin')

@section('title', 'Code: ' . $codeCaisse->code)

@section('page-title', $isFrench ?? true ? 'Détails du Code Caisse' : 'Cash Code Details')

@section('admin-content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2">
            <li>
                <a href="{{ route('admin.auto-ecole.codes-caisse.index') }}" class="flex items-center text-gray-500 hover:text-orange-600 transition-colors font-medium">
                    <i class="fas fa-ticket-alt mr-2"></i>
                    {{ $isFrench ?? true ? 'Codes Caisse' : 'Cash Codes' }}
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                    <span class="text-gray-700 font-semibold">{{ $codeCaisse->code }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Code Card -->
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-200">
        <div class="px-6 py-12 text-center bg-gradient-to-br {{ $codeCaisse->utilise ? 'from-green-500 via-green-600 to-green-700' : 'from-orange-500 via-orange-600 to-orange-700' }} relative overflow-hidden">
            <!-- Decorative elements -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
            </div>
            <div class="relative z-10">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/30 backdrop-blur-sm rounded-2xl mb-6 shadow-lg">
                    <i class="fas {{ $codeCaisse->utilise ? 'fa-check-circle' : 'fa-ticket-alt' }} text-4xl text-white"></i>
                </div>
                <div class="text-white">
                    <p class="text-sm opacity-90 mb-2 font-semibold uppercase tracking-wider">Code Caisse</p>
                    <p class="text-5xl font-mono font-black tracking-widest mb-4">{{ $codeCaisse->code }}</p>
                    <button onclick="copyToClipboard('{{ $codeCaisse->code }}')"
                            class="inline-flex items-center px-6 py-2.5 bg-white/20 backdrop-blur-sm text-white rounded-xl hover:bg-white/30 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-copy mr-2"></i> {{ $isFrench ?? true ? 'Copier le code' : 'Copy code' }}
                    </button>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-2 gap-6">
                <div class="text-center p-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border-2 border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                    <p class="text-sm text-gray-600 mb-2 font-semibold uppercase tracking-wide">{{ $isFrench ?? true ? 'Montant' : 'Amount' }}</p>
                    <p class="text-4xl font-black text-gray-900">{{ number_format($codeCaisse->montant) }} <span class="text-2xl text-gray-500">F</span></p>
                </div>
                <div class="text-center p-6 {{ $codeCaisse->utilise ? 'bg-gradient-to-br from-green-50 to-green-100 border-green-200' : 'bg-gradient-to-br from-amber-50 to-amber-100 border-amber-200' }} rounded-2xl border-2 shadow-sm hover:shadow-md transition-shadow">
                    <p class="text-sm {{ $codeCaisse->utilise ? 'text-green-700' : 'text-amber-700' }} mb-2 font-semibold uppercase tracking-wide">{{ $isFrench ?? true ? 'Statut' : 'Status' }}</p>
                    <p class="text-3xl font-black {{ $codeCaisse->utilise ? 'text-green-800' : 'text-amber-800' }}">
                        {{ $codeCaisse->utilise ? ($isFrench ?? true ? 'Utilisé' : 'Used') : ($isFrench ?? true ? 'Disponible' : 'Available') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Details -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
        <div class="px-8 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-info-circle mr-3 text-orange-600"></i>
                {{ $isFrench ?? true ? 'Informations détaillées' : 'Detailed information' }}
            </h3>
        </div>
        <div class="divide-y divide-gray-200">
            <div class="px-8 py-5 flex items-center justify-between hover:bg-gray-50 transition-colors">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-plus text-blue-600"></i>
                    </div>
                    <span class="text-gray-600 font-medium">{{ $isFrench ?? true ? 'Créé le' : 'Created on' }}</span>
                </div>
                <span class="font-bold text-gray-900 text-lg">
                    {{ $codeCaisse->created_at ? $codeCaisse->created_at->format('d/m/Y à H:i') : '-' }}
                </span>
            </div>

            @if($codeCaisse->createur)
                <div class="px-8 py-5 flex items-center justify-between hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-user-shield text-purple-600"></i>
                        </div>
                        <span class="text-gray-600 font-medium">{{ $isFrench ?? true ? 'Créé par' : 'Created by' }}</span>
                    </div>
                    <span class="font-bold text-gray-900 text-lg">{{ $codeCaisse->createur->name }}</span>
                </div>
            @endif

            @if($codeCaisse->expire_at)
                <div class="px-8 py-5 flex items-center justify-between hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <div class="w-10 h-10 {{ $codeCaisse->expire_at < now() ? 'bg-red-100' : 'bg-amber-100' }} rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-hourglass-end {{ $codeCaisse->expire_at < now() ? 'text-red-600' : 'text-amber-600' }}"></i>
                        </div>
                        <span class="text-gray-600 font-medium">{{ $isFrench ?? true ? 'Expire le' : 'Expires on' }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-bold text-lg {{ $codeCaisse->expire_at < now() ? 'text-red-600' : 'text-gray-900' }}">
                            {{ $codeCaisse->expire_at->format('d/m/Y') }}
                        </span>
                        @if($codeCaisse->expire_at < now())
                            <span class="ml-3 px-3 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full border border-red-200">
                                {{ $isFrench ?? true ? 'Expiré' : 'Expired' }}
                            </span>
                        @endif
                    </div>
                </div>
            @endif

            @if($codeCaisse->utilise && $codeCaisse->utilise_at)
                <div class="px-8 py-5 flex items-center justify-between hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <span class="text-gray-600 font-medium">{{ $isFrench ?? true ? 'Utilisé le' : 'Used on' }}</span>
                    </div>
                    <span class="font-bold text-green-600 text-lg">
                        {{ $codeCaisse->utilise_at->format('d/m/Y à H:i') }}
                    </span>
                </div>
            @endif

            @if($codeCaisse->user)
                <div class="px-8 py-5 flex items-center justify-between hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-user text-indigo-600"></i>
                        </div>
                        <span class="text-gray-600 font-medium">{{ $isFrench ?? true ? 'Utilisateur' : 'User' }}</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-lg mr-3 shadow-md">
                            {{ substr($codeCaisse->user->prenom, 0, 1) }}{{ substr($codeCaisse->user->nom, 0, 1) }}
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-gray-900 text-lg block">{{ $codeCaisse->user->prenom }} {{ $codeCaisse->user->nom }}</span>
                            <span class="text-gray-500 text-sm">{{ $codeCaisse->user->telephone }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-between pt-4">
        <a href="{{ route('admin.auto-ecole.codes-caisse.index') }}"
           class="inline-flex items-center px-6 py-3 text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-semibold shadow-sm hover:shadow-md">
            <i class="fas fa-arrow-left mr-2"></i>
            {{ $isFrench ?? true ? 'Retour à la liste' : 'Back to list' }}
        </a>

        @if(!$codeCaisse->utilise)
            <button type="button" onclick="confirmDelete()"
                    class="inline-flex items-center px-6 py-3 text-red-600 border-2 border-red-300 rounded-xl hover:bg-red-50 hover:border-red-400 transition-all duration-200 font-semibold shadow-sm hover:shadow-md">
                <i class="fas fa-trash mr-2"></i>
                {{ $isFrench ?? true ? 'Supprimer le code' : 'Delete code' }}
            </button>

            <form id="delete-form"
                  action="{{ route('admin.auto-ecole.codes-caisse.destroy', ['codes_caisse' => $codeCaisse->id]) }}"
                  method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </div>
</div>

@push('scripts')
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

    function confirmDelete() {
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
                document.getElementById('delete-form').submit();
            }
        });
    }
</script>
@endpush
@endsection
