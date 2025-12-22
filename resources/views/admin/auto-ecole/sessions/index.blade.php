@extends('layouts.admin')

@section('title', 'Sessions')
@section('page-title', 'Gestion des sessions')

@section('admin-content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-end">
        <a href="{{ route('admin.auto-ecole.sessions.create') }}" class="btn-primary text-white px-6 py-2.5 rounded-xl font-medium hover:shadow-lg transition-all">
            <i class="fas fa-plus mr-2"></i> Nouvelle session
        </a>
    </div>

    <!-- Sessions Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Session</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Inscrits</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date d'examen</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($sessions as $session)
                    <tr class="table-row hover:bg-primary-50/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $session->nom }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $session->users_count }} inscrits
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                @if($session->date_examen_theorique)
                                    <div class="flex items-center">
                                        <i class="fas fa-book-open text-primary-500 mr-2 text-xs"></i>
                                        <span>{{ $session->date_examen_theorique->format('d/m/Y') }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">Non défini</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <button onclick="toggleActive({{ $session->id }})" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium cursor-pointer {{ $session->active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition-colors">
                                <span class="w-2 h-2 rounded-full {{ $session->active ? 'bg-green-500' : 'bg-gray-400' }} mr-2"></span>
                                {{ $session->active ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.auto-ecole.sessions.edit', $session) }}" class="w-8 h-8 rounded-lg bg-primary-100 text-primary-600 hover:bg-primary-200 flex items-center justify-center transition-colors">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <button onclick="deleteSession({{ $session->id }}, {{ $session->users_count }})" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 flex items-center justify-center transition-colors">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                    <i class="fas fa-calendar-alt text-2xl text-gray-400"></i>
                                </div>
                                <p class="text-gray-500 font-medium">Aucune session</p>
                                <a href="{{ route('admin.auto-ecole.sessions.create') }}" class="btn-primary text-white px-4 py-2 rounded-xl text-sm font-medium mt-4">
                                    <i class="fas fa-plus mr-1"></i> Créer une session
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sessions->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $sessions->links() }}
        </div>
        @endif
    </div>
</div>

<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<form id="toggleForm" method="POST" class="hidden">
    @csrf
</form>
@endsection

@push('scripts')
<script>
function toggleActive(id) {
    const form = document.getElementById('toggleForm');
    form.action = `/admin/auto-ecole/sessions/${id}/toggle`;
    form.submit();
}

function deleteSession(id, usersCount) {
    if (usersCount > 0) {
        Swal.fire({
            title: 'Suppression impossible',
            text: 'Cette session contient des utilisateurs inscrits.',
            icon: 'error',
            confirmButtonColor: '#f59e0b'
        });
        return;
    }

    Swal.fire({
        title: 'Supprimer cette session ?',
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
            form.action = `/admin/auto-ecole/sessions/${id}`;
            form.submit();
        }
    });
}
</script>
@endpush
