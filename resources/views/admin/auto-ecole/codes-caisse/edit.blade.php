@extends('layouts.admin')

@section('title', 'Modifier code caisse')
@section('page-title', 'Modifier le code caisse')

@section('admin-content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-soft overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-900">Modifier le code</h2>
            <p class="text-sm text-gray-600 mt-1">{{ $code->code }}</p>
        </div>

        <form action="{{ route('admin.auto-ecole.codes-caisse.update', $code->id) }}" method="POST" class="p-6 space-y-6">
            @csrf @method('PUT')

            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase">Code</p>
                    <p class="text-lg font-mono font-bold text-gray-900 mt-1">{{ $code->code }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase">Montant</p>
                    <p class="text-lg font-bold text-gray-900 mt-1">{{ number_format($code->montant, 2, ',', ' ') }} €</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase">Statut</p>
                    <p class="text-lg font-bold mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $code->utilise ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $code->utilise ? 'Utilisé' : 'En attente' }}
                        </span>
                    </p>
                </div>
            </div>

            <div>
                <label for="date_expiration" class="block text-sm font-semibold text-gray-900 mb-2">Date d'expiration</label>
                <input
                    type="date"
                    id="date_expiration"
                    name="date_expiration"
                    value="{{ $code->date_expiration?->format('Y-m-d') }}"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
                @error('date_expiration')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 pt-4">
                <button
                    type="submit"
                    class="flex-1 btn-primary text-white py-3 rounded-lg font-medium"
                >
                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                </button>
                <a
                    href="{{ route('admin.auto-ecole.codes-caisse.index') }}"
                    class="flex-1 px-4 py-3 bg-gray-100 text-gray-900 rounded-lg font-medium hover:bg-gray-200 transition-colors text-center"
                >
                    <i class="fas fa-times mr-2"></i>Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
