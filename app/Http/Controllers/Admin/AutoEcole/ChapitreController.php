<?php

namespace App\Http\Controllers\Admin\AutoEcole;

use App\Http\Controllers\Controller;
use App\Models\Chapitre;
use App\Models\Module;
use Illuminate\Http\Request;

class ChapitreController extends Controller
{
    public function index(Request $request)
    {
        $query = Chapitre::with('module')->withCount(['lecons', 'quiz']);

        if ($request->filled('module_id')) {
            $query->where('module_id', $request->module_id);
        }

        $chapitres = $query->orderBy('module_id')->orderBy('ordre')->paginate(20);
        $modules = Module::where('active', true)->orderBy('nom')->get();

        return view('admin.auto-ecole.chapitres.index', compact('chapitres', 'modules'));
    }

    public function create(Request $request)
    {
        $modules = Module::where('active', true)->orderBy('type')->orderBy('nom')->get();
        $moduleSelectionne = $request->module_id;

        return view('admin.auto-ecole.chapitres.create', compact('modules', 'moduleSelectionne'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ordre' => 'required|integer|min:0',
            'active' => 'boolean'
        ]);

        $validated['active'] = $request->has('active');

        Chapitre::create($validated);

        return redirect()->route('admin.auto-ecole.chapitres.index', ['module_id' => $validated['module_id']])
            ->with('success', 'Chapitre créé avec succès');
    }

    public function show(Chapitre $chapitre)
    {
        $chapitre->load(['module', 'lecons', 'quiz.questions']);
        return view('admin.auto-ecole.chapitres.show', compact('chapitre'));
    }

    public function edit(Chapitre $chapitre)
    {
        $modules = Module::where('active', true)->orderBy('type')->orderBy('nom')->get();
        return view('admin.auto-ecole.chapitres.edit', compact('chapitre', 'modules'));
    }

    public function update(Request $request, Chapitre $chapitre)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ordre' => 'required|integer|min:0',
            'active' => 'boolean'
        ]);

        $validated['active'] = $request->has('active');

        $chapitre->update($validated);

        return redirect()->route('admin.auto-ecole.chapitres.index', ['module_id' => $chapitre->module_id])
            ->with('success', 'Chapitre mis à jour');
    }

    public function destroy(Chapitre $chapitre)
    {
        $moduleId = $chapitre->module_id;
        $chapitre->delete();

        return redirect()->route('admin.auto-ecole.chapitres.index', ['module_id' => $moduleId])
            ->with('success', 'Chapitre supprimé');
    }
}
