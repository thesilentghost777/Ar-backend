<?php

namespace App\Http\Controllers\Admin\AutoEcole;

use App\Http\Controllers\Controller;
use App\Models\Lecon;
use App\Models\Chapitre;
use App\Models\Module;
use Illuminate\Http\Request;

class LeconController extends Controller
{
    public function index(Request $request)
    {
        $query = Lecon::with('chapitre.module');

        if ($request->filled('chapitre_id')) {
            $query->where('chapitre_id', $request->chapitre_id);
        }

        if ($request->filled('module_id')) {
            $query->whereHas('chapitre', function ($q) use ($request) {
                $q->where('module_id', $request->module_id);
            });
        }

        $lecons = $query->orderBy('chapitre_id')->orderBy('ordre')->paginate(20);
        $modules = Module::where('active', true)->with('chapitres')->get();

        return view('admin.auto-ecole.lecons.index', compact('lecons', 'modules'));
    }

    public function create(Request $request)
    {
        $chapitres = Chapitre::with('module')
            ->where('active', true)
            ->orderBy('module_id')
            ->orderBy('nom')
            ->get();

        $chapitreSelectionne = $request->chapitre_id;

        return view('admin.auto-ecole.lecons.create', compact('chapitres', 'chapitreSelectionne'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'chapitre_id' => 'required|exists:chapitres,id',
            'titre' => 'required|string|max:255',
            'contenu_texte' => 'nullable|string',
            'url_web' => 'nullable|url',
            'url_video' => 'nullable|url',
            'ordre' => 'required|integer|min:0',
            'duree_minutes' => 'required|integer|min:1',
            'active' => 'boolean'
        ]);

        $validated['active'] = $request->has('active');

        Lecon::create($validated);

        return redirect()->route('admin.auto-ecole.lecons.index', ['chapitre_id' => $validated['chapitre_id']])
            ->with('success', 'Leçon créée avec succès');
    }

    public function show(Lecon $lecon)
    {
        $lecon->load('chapitre.module');
        return view('admin.auto-ecole.lecons.show', compact('lecon'));
    }

    public function edit(Lecon $lecon)
    {
        $chapitres = Chapitre::with('module')
            ->where('active', true)
            ->orderBy('module_id')
            ->orderBy('nom')
            ->get();

        return view('admin.auto-ecole.lecons.edit', compact('lecon', 'chapitres'));
    }

    public function update(Request $request, Lecon $lecon)
    {
        $validated = $request->validate([
            'chapitre_id' => 'required|exists:chapitres,id',
            'titre' => 'required|string|max:255',
            'contenu_texte' => 'nullable|string',
            'url_web' => 'nullable|url',
            'url_video' => 'nullable|url',
            'ordre' => 'required|integer|min:0',
            'duree_minutes' => 'required|integer|min:1',
            'active' => 'boolean'
        ]);

        $validated['active'] = $request->has('active');

        $lecon->update($validated);

        return redirect()->route('admin.auto-ecole.lecons.index', ['chapitre_id' => $lecon->chapitre_id])
            ->with('success', 'Leçon mise à jour');
    }

    public function destroy(Lecon $lecon)
    {
        $chapitreId = $lecon->chapitre_id;
        $lecon->delete();

        return redirect()->route('admin.auto-ecole.lecons.index', ['chapitre_id' => $chapitreId])
            ->with('success', 'Leçon supprimée');
    }
}
