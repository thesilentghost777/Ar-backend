@extends('layouts.admin')

@section('title', 'Nouvelle session')
@section('page-title', 'Créer une nouvelle session')

@section('admin-content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <a href="{{ route('admin.auto-ecole.sessions.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary-600">
        <i class="fas fa-arrow-left mr-2"></i> Retour aux sessions
    </a>

    <!-- Formulaire -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
            <h2 class="text-xl font-semibold text-white">
                <i class="fas fa-calendar-plus mr-2"></i> Nouvelle session d'examen
            </h2>
        </div>

        <form action="{{ route('admin.auto-ecole.sessions.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la session *</label>
                <input type="text" name="nom" value="{{ old('nom') }}" required
                    placeholder="Ex: Session Janvier 2025"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nom') border-red-500 @enderror">
                @error('nom')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-bullhorn text-primary-500 mr-1"></i> Communication enregistrement
                    </label>
                    <input type="date" name="date_communication_enregistrement" value="{{ old('date_communication_enregistrement') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-plus text-blue-500 mr-1"></i> Enregistrement vague 1
                    </label>
                    <input type="date" name="date_enregistrement_vague1" value="{{ old('date_enregistrement_vague1') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-plus text-blue-500 mr-1"></i> Enregistrement vague 2
                    </label>
                    <input type="date" name="date_enregistrement_vague2" value="{{ old('date_enregistrement_vague2') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-exchange-alt text-orange-500 mr-1"></i> Transfert/Reconduction
                    </label>
                    <input type="date" name="date_transfert_reconduction" value="{{ old('date_transfert_reconduction') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-building text-gray-500 mr-1"></i> Dépôt départemental
                    </label>
                    <input type="date" name="date_depot_departemental" value="{{ old('date_depot_departemental') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-landmark text-gray-500 mr-1"></i> Dépôt régional
                    </label>
                    <input type="date" name="date_depot_regional" value="{{ old('date_depot_regional') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>

            <div class="bg-primary-50 rounded-xl p-4 border border-primary-100">
                <h3 class="text-sm font-semibold text-primary-800 mb-4">
                    <i class="fas fa-graduation-cap mr-1"></i> Dates d'examens
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Examen théorique</label>
                        <input type="date" name="date_examen_theorique" value="{{ old('date_examen_theorique') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Examen pratique</label>
                        <input type="date" name="date_examen_pratique" value="{{ old('date_examen_pratique') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="active" id="active" value="1" {{ old('active', true) ? 'checked' : '' }}
                    class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                <label for="active" class="ml-3 text-sm font-medium text-gray-700">Session active</label>
            </div>

            <!-- Boutons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.auto-ecole.sessions.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    Annuler
                </a>
                <button type="submit" class="btn-primary text-white px-6 py-2.5 rounded-xl font-medium hover:shadow-lg transition-all">
                    <i class="fas fa-save mr-2"></i> Créer la session
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
