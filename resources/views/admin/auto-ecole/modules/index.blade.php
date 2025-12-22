@extends('layouts.admin')

@section('title', 'Modules')
@section('page-title', 'Gestion des modules de cours')

@section('admin-content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center space-x-4">
            <form action="{{ route('admin.auto-ecole.modules.index') }}" method="GET" class="flex items-center space-x-2">
                <select name="type" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Tous les types</option>
                    <option value="theorique" {{ request('type') === 'theorique' ? 'selected' : '' }}>Théorique</option>
                    <option value="pratique" {{ request('type') === 'pratique' ? 'selected' : '' }}>Pratique</option>
                </select>
            </form>
        </div>
        <a href="{{ route('admin.auto-ecole.modules.create') }}" class="btn-primary text-white px-6 py-2.5 rounded-xl font-medium hover:shadow-lg transition-all">
            <i class="fas fa-plus mr-2"></i> Nouveau module
        </a>
    </div>

    <!-- Modules Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($modules as $module)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all group">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-xl {{ $module->type === 'theorique' ? 'bg-blue-100' : 'bg-green-100' }} flex items-center justify-center">
                            <i class="fas {{ $module->type === 'theorique' ? 'fa-book text-blue-600' : 'fa-car text-green-600' }} text-xl"></i>
                        </div>
                        <div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $module->type === 'theorique' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                {{ ucfirst($module->type) }}
                            </span>
                            <p class="text-xs text-gray-500 mt-0.5">Ordre: {{ $module->ordre }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $module->active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ $module->active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>

                <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">{{ $module->nom }}</h3>
                <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $module->description ?? 'Aucune description' }}</p>

                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                    <span><i class="fas fa-layer-group mr-1"></i> {{ $module->chapitres_count }} chapitres</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-700">
                        {{ strtoupper(str_replace('_', ' ', $module->type_permis ?? 'tous')) }}
                    </span>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.auto-ecole.modules.show', $module) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        <i class="fas fa-eye mr-1"></i> Voir
                    </a>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.auto-ecole.modules.edit', $module) }}" class="w-8 h-8 rounded-lg bg-primary-100 text-primary-600 hover:bg-primary-200 flex items-center justify-center transition-colors">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                        <button onclick="deleteModule({{ $module->id }})" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 flex items-center justify-center transition-colors">
                            <i class="fas fa-trash text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-book text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Aucun module</h3>
                <p class="text-gray-500 mb-6">Commencez par créer votre premier module de cours</p>
                <a href="{{ route('admin.auto-ecole.modules.create') }}" class="btn-primary text-white px-6 py-2.5 rounded-xl font-medium inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i> Créer un module
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($modules->hasPages())
    <div class="flex justify-center">
        {{ $modules->links() }}
    </div>
    @endif
</div>

<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function deleteModule(id) {
    Swal.fire({
        title: 'Supprimer ce module ?',
        text: "Tous les chapitres et leçons associés seront également supprimés !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/auto-ecole/modules/${id}`;
            form.submit();
        }
    });
}
</script>
@endpush
