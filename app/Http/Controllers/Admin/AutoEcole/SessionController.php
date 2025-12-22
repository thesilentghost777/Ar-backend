<?php

namespace App\Http\Controllers\Admin\AutoEcole;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::withCount('users')->orderBy('date_examen_theorique', 'desc')->paginate(20);
        return view('admin.auto-ecole.sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('admin.auto-ecole.sessions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'date_communication_enregistrement' => 'nullable|date',
            'date_enregistrement_vague1' => 'nullable|date',
            'date_enregistrement_vague2' => 'nullable|date',
            'date_transfert_reconduction' => 'nullable|date',
            'date_depot_departemental' => 'nullable|date',
            'date_depot_regional' => 'nullable|date',
            'date_examen_theorique' => 'nullable|date',
            'date_examen_pratique' => 'nullable|date',
            'active' => 'boolean'
        ]);

        $validated['active'] = $request->has('active');

        Session::create($validated);

        return redirect()->route('admin.auto-ecole.sessions.index')
            ->with('success', 'Session créée avec succès');
    }

    public function edit(Session $session)
    {
        return view('admin.auto-ecole.sessions.edit', compact('session'));
    }

    public function update(Request $request, Session $session)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'date_communication_enregistrement' => 'nullable|date',
            'date_enregistrement_vague1' => 'nullable|date',
            'date_enregistrement_vague2' => 'nullable|date',
            'date_transfert_reconduction' => 'nullable|date',
            'date_depot_departemental' => 'nullable|date',
            'date_depot_regional' => 'nullable|date',
            'date_examen_theorique' => 'nullable|date',
            'date_examen_pratique' => 'nullable|date',
            'active' => 'boolean'
        ]);

        $validated['active'] = $request->has('active');

        $session->update($validated);

        return redirect()->route('admin.auto-ecole.sessions.index')
            ->with('success', 'Session mise à jour');
    }

    public function destroy(Session $session)
    {
        if ($session->users()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer: des utilisateurs sont inscrits à cette session');
        }

        $session->delete();
        return redirect()->route('admin.auto-ecole.sessions.index')
            ->with('success', 'Session supprimée');
    }

    public function toggleActive(Session $session)
    {
        $session->active = !$session->active;
        $session->save();

        return redirect()->back()->with('success', 'Status de la session modifié');
    }
}
