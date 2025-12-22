@extends('layouts.admin')

@section('title', $isFrench ?? true ? 'Gestion des Chapitres' : 'Chapter Management')
@section('page-title', $isFrench ?? true ? 'Gestion des Chapitres' : 'Chapter Management')

@section('admin-content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $isFrench ?? true ? 'Chapitres' : 'Chapters' }}</h2>
            <p class="text-gray-600">{{ $isFrench ?? true ? 'Gérez les chapitres de formation' : 'Manage training chapters' }}</p>
        </div>
        <a href="{{ route('admin.auto-ecole.chapitres.create', request()->only('module_id')) }}"
           class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
            <i class="fas fa-plus mr-2"></i>
            {{ $isFrench ?? true ? 'Nouveau Chapitre' : 'New Chapter' }}
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ $isFrench ?? true ? 'Filtrer par module' : 'Filter by module' }}</label>
                <select name="module_id" onchange="this.form.submit()"
                        class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">{{ $isFrench ?? true ? 'Tous les modules' : 'All modules' }}</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}" {{ request('module_id') == $module->id ? 'selected' : '' }}>
                            {{ $module->nom }} ({{ ucfirst($module->type) }})
                        </option>
                    @endforeach
                </select>
            </div>
            @if(request('module_id'))
                <div class="flex items-end">
                    <a href="{{ route('admin.auto-ecole.chapitres.index') }}"
                       class="px-4 py-2 text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-times mr-1"></i> {{ $isFrench ?? true ? 'Réinitialiser' : 'Reset' }}
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ $isFrench ?? true ? 'Ordre' : 'Order' }}</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ $isFrench ?? true ? 'Nom' : 'Name' }}</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Module</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ $isFrench ?? true ? 'Leçons' : 'Lessons' }}</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Quiz</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ $isFrench ?? true ? 'Statut' : 'Status' }}</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($chapitres as $chapitre)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 font-semibold text-sm">
                                    {{ $chapitre->ordre }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $chapitre->nom }}</div>
                                @if($chapitre->description)
                                    <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($chapitre->description, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $chapitre->module->type === 'theorique' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    <i class="fas {{ $chapitre->module->type === 'theorique' ? 'fa-book' : 'fa-car' }} mr-1"></i>
                                    {{ $chapitre->module->nom }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    <i class="fas fa-graduation-cap mr-1"></i> {{ $chapitre->lecons_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                    <i class="fas fa-question-circle mr-1"></i> {{ $chapitre->quiz_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($chapitre->active)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> {{ $isFrench ?? true ? 'Actif' : 'Active' }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-times-circle mr-1"></i> {{ $isFrench ?? true ? 'Inactif' : 'Inactive' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.auto-ecole.chapitres.show', $chapitre) }}"
                                       class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="{{ $isFrench ?? true ? 'Voir' : 'View' }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.auto-ecole.chapitres.edit', $chapitre) }}"
                                       class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition" title="{{ $isFrench ?? true ? 'Modifier' : 'Edit' }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form id="delete-form-{{ $chapitre->id }}"
                                          action="{{ route('admin.auto-ecole.chapitres.destroy', $chapitre) }}"
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                onclick="confirmDelete('delete-form-{{ $chapitre->id }}')"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                title="{{ $isFrench ?? true ? 'Supprimer' : 'Delete' }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-bookmark text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 font-medium">{{ $isFrench ?? true ? 'Aucun chapitre trouvé' : 'No chapters found' }}</p>
                                    <a href="{{ route('admin.auto-ecole.chapitres.create') }}"
                                       class="mt-4 text-primary-600 hover:text-primary-700 font-medium">
                                        <i class="fas fa-plus mr-1"></i> {{ $isFrench ?? true ? 'Créer le premier chapitre' : 'Create first chapter' }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($chapitres->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $chapitres->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
