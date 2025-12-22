@extends('layouts.admin')

@section('title', 'Leçons')
@section('page-title', 'Gestion des leçons')

@section('admin-content')
<div class="space-y-6">
    <!-- Header avec filtres -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.auto-ecole.lecons.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Module</label>
                <select name="module_id" id="moduleSelect" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500">
                    <option value="">Tous les modules</option>
                    @foreach($modules as $module)
                    <option value="{{ $module->id }}" {{ request('module_id') == $module->id ? 'selected' : '' }}>{{ $module->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Chapitre</label>
                <select name="chapitre_id" id="chapitreSelect" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500">
                    <option value="">Tous les chapitres</option>
                </select>
            </div>

            <button type="submit" class="btn-primary text-white px-6 py-2.5 rounded-xl font-medium">
                <i class="fas fa-filter mr-2"></i> Filtrer
            </button>

            <a href="{{ route('admin.auto-ecole.lecons.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2.5 rounded-xl font-medium transition-all">
                <i class="fas fa-plus mr-2"></i> Nouvelle leçon
            </a>
        </form>
    </div>

    <!-- Table des leçons -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Ordre</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Leçon</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Chapitre / Module</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Durée</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Contenu</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Statut</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($lecons as $lecon)
                    <tr class="hover:bg-primary-50/30 transition-colors">
                        <td class="px-6 py-4">
                            <span class="w-8 h-8 rounded-lg bg-primary-100 text-primary-600 inline-flex items-center justify-center font-bold text-sm">
                                {{ $lecon->ordre }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900">{{ $lecon->titre }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">{{ $lecon->chapitre->nom ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500">{{ $lecon->chapitre->module->nom ?? '' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-clock mr-1"></i> {{ $lecon->duree_minutes }} min
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                @if($lecon->contenu_texte)
                                <span class="w-6 h-6 rounded bg-gray-100 text-gray-600 flex items-center justify-center" title="Texte">
                                    <i class="fas fa-file-alt text-xs"></i>
                                </span>
                                @endif
                                @if($lecon->url_video)
                                <span class="w-6 h-6 rounded bg-red-100 text-red-600 flex items-center justify-center" title="Vidéo">
                                    <i class="fas fa-video text-xs"></i>
                                </span>
                                @endif
                                @if($lecon->url_web)
                                <span class="w-6 h-6 rounded bg-blue-100 text-blue-600 flex items-center justify-center" title="Lien web">
                                    <i class="fas fa-link text-xs"></i>
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $lecon->active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ $lecon->active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.auto-ecole.lecons.show', $lecon) }}" class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 flex items-center justify-center transition-colors">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('admin.auto-ecole.lecons.edit', $lecon) }}" class="w-8 h-8 rounded-lg bg-primary-100 text-primary-600 hover:bg-primary-200 flex items-center justify-center transition-colors">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <button onclick="deleteLecon({{ $lecon->id }})" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 flex items-center justify-center transition-colors">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                    <i class="fas fa-graduation-cap text-2xl text-gray-400"></i>
                                </div>
                                <p class="text-gray-500 font-medium">Aucune leçon trouvée</p>
                                <a href="{{ route('admin.auto-ecole.lecons.create') }}" class="btn-primary text-white px-4 py-2 rounded-xl text-sm font-medium mt-4">
                                    <i class="fas fa-plus mr-1"></i> Créer une leçon
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($lecons->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $lecons->links() }}
        </div>
        @endif
    </div>
</div>

<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
const modules = @json($modules);
const moduleSelect = document.getElementById('moduleSelect');
const chapitreSelect = document.getElementById('chapitreSelect');
const currentChapitre = '{{ request('chapitre_id') }}';

function updateChapitres() {
    const moduleId = moduleSelect.value;
    chapitreSelect.innerHTML = '<option value="">Tous les chapitres</option>';

    if (moduleId) {
        const module = modules.find(m => m.id == moduleId);
        if (module && module.chapitres) {
            module.chapitres.forEach(chapitre => {
                const option = document.createElement('option');
                option.value = chapitre.id;
                option.textContent = chapitre.nom;
                if (chapitre.id == currentChapitre) option.selected = true;
                chapitreSelect.appendChild(option);
            });
        }
    }
}

moduleSelect.addEventListener('change', updateChapitres);
updateChapitres();

function deleteLecon(id) {
    Swal.fire({
        title: 'Supprimer cette leçon ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/auto-ecole/lecons/${id}`;
            form.submit();
        }
    });
}
</script>
@endpush
