@extends('layouts.admin')

@section('title', $isFrench ?? true ? 'Générer des Codes' : 'Generate Codes')
@section('page-title', $isFrench ?? true ? 'Générer des Codes Caisse' : 'Generate Cash Codes')

@section('admin-content')
<div class="max-w-3xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li>
                <a href="{{ route('admin.auto-ecole.codes-caisse.index') }}" class="text-gray-500 hover:text-primary-600">
                    <i class="fas fa-ticket-alt mr-1"></i> {{ $isFrench ?? true ? 'Codes Caisse' : 'Cash Codes' }}
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                    <span class="text-gray-700 font-medium">{{ $isFrench ?? true ? 'Générer' : 'Generate' }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-orange-500 to-orange-600">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-plus-circle mr-2"></i>
                {{ $isFrench ?? true ? 'Générer des codes caisse' : 'Generate cash codes' }}
            </h3>
        </div>

        <form action="{{ route('admin.auto-ecole.codes-caisse.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="montant" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $isFrench ?? true ? 'Montant (FCFA)' : 'Amount (FCFA)' }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" name="montant" id="montant" value="{{ old('montant', 10000) }}"
                               min="10000" step="1000" required
                               class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 pr-16 @error('montant') border-red-500 @enderror">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 font-medium">FCFA</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">{{ $isFrench ?? true ? 'Minimum: 10 000 FCFA' : 'Minimum: 10,000 FCFA' }}</p>
                    @error('montant')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="quantite" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $isFrench ?? true ? 'Quantité' : 'Quantity' }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="quantite" id="quantite" value="{{ old('quantite', 1) }}"
                           min="1" max="50" required
                           class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 @error('quantite') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">{{ $isFrench ?? true ? 'Maximum: 50 codes' : 'Maximum: 50 codes' }}</p>
                    @error('quantite')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ $isFrench ?? true ? 'Attribuer à un utilisateur (optionnel)' : 'Assign to user (optional)' }}
                </label>
                <select name="user_id" id="user_id"
                        class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">{{ $isFrench ?? true ? 'Aucun - Code libre' : 'None - Free code' }}</option>
                    @foreach($utilisateurs as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->prenom }} {{ $user->nom }} ({{ $user->telephone }})
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-sm text-gray-500">{{ $isFrench ?? true ? 'Si sélectionné, seul cet utilisateur pourra utiliser le code' : 'If selected, only this user can use the code' }}</p>
            </div>

            <div>
                <label for="expire_at" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ $isFrench ?? true ? 'Date d\'expiration (optionnel)' : 'Expiration date (optional)' }}
                </label>
                <input type="date" name="expire_at" id="expire_at" value="{{ old('expire_at') }}"
                       min="{{ now()->addDay()->format('Y-m-d') }}"
                       class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 @error('expire_at') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">{{ $isFrench ?? true ? 'Laisser vide pour un code sans expiration' : 'Leave empty for a non-expiring code' }}</p>
                @error('expire_at')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Summary -->
            <div class="p-4 bg-orange-50 border border-orange-200 rounded-lg" x-data="{ montant: {{ old('montant', 10000) }}, quantite: {{ old('quantite', 1) }} }">
                <h4 class="font-medium text-orange-800 mb-2">{{ $isFrench ?? true ? 'Résumé' : 'Summary' }}</h4>
                <div class="flex items-center justify-between text-orange-700">
                    <span x-text="quantite + ' code(s) x ' + new Intl.NumberFormat().format(montant) + ' FCFA'"></span>
                    <span class="font-bold text-lg" x-text="'= ' + new Intl.NumberFormat().format(montant * quantite) + ' FCFA'"></span>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.auto-ecole.codes-caisse.index') }}"
                   class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    {{ $isFrench ?? true ? 'Annuler' : 'Cancel' }}
                </a>
                <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                    <i class="fas fa-magic mr-2"></i>
                    {{ $isFrench ?? true ? 'Générer les codes' : 'Generate codes' }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Update summary in real-time
    document.getElementById('montant').addEventListener('input', updateSummary);
    document.getElementById('quantite').addEventListener('input', updateSummary);

    function updateSummary() {
        const montant = parseInt(document.getElementById('montant').value) || 0;
        const quantite = parseInt(document.getElementById('quantite').value) || 0;

        // Alpine.js will handle the display
    }
</script>
@endpush
@endsection
