<?php

namespace App\Http\Controllers\Admin\AutoEcole;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $query = Module::withCount('chapitres');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $modules = $query->orderBy('type')->orderBy('ordre')->paginate(20);
        return view('admin.auto-ecole.modules.index', compact('modules'));
    }

    public function create()
    {
        return view('admin.auto-ecole.modules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:theorique,pratique',
            'type_permis' => 'required|in:permis_a,permis_b,tous',
            'ordre' => 'required|integer|min:0',
            'active' => 'boolean'
        ]);

        $validated['active'] = $request->has('active');

        Module::create($validated);

        return redirect()->route('admin.auto-ecole.modules.index')
            ->with('success', 'Module créé avec succès');
    }

    public function show(Module $module)
    {
        $module->load(['chapitres.lecons', 'chapitres.quiz']);
        return view('admin.auto-ecole.modules.show', compact('module'));
    }

    public function edit(Module $module)
    {
        return view('admin.auto-ecole.modules.edit', compact('module'));
    }

    public function update(Request $request, Module $module)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:theorique,pratique',
            'type_permis' => 'required|in:permis_a,permis_b,tous',
            'ordre' => 'required|integer|min:0',
            'active' => 'boolean'
        ]);

        $validated['active'] = $request->has('active');

        $module->update($validated);

        return redirect()->route('admin.auto-ecole.modules.index')
            ->with('success', 'Module mis à jour');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('admin.auto-ecole.modules.index')
            ->with('success', 'Module supprimé');
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'modules' => 'required|array',
            'modules.*.id' => 'required|exists:modules,id',
            'modules.*.ordre' => 'required|integer'
        ]);

        foreach ($validated['modules'] as $item) {
            Module::where('id', $item['id'])->update(['ordre' => $item['ordre']]);
        }

        return response()->json(['success' => true]);
    }
}
