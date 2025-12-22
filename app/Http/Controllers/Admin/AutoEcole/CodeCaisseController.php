<?php

namespace App\Http\Controllers\Admin\AutoEcole;

use App\Models\CodeCaisse;
use App\Models\AutoEcoleUser;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CodeCaisseController extends Controller
{
    public function index(Request $request)
    {
        $query = CodeCaisse::with(['user', 'createur']);

        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            if ($request->status === 'utilise') {
                $query->where('utilise', true);
            } elseif ($request->status === 'disponible') {
                $query->where('utilise', false)
                      ->where(function($q) {
                          $q->whereNull('expire_at')
                            ->orWhere('expire_at', '>', now());
                      });
            }
        }

        $codes = $query->orderBy('created_at', 'desc')->paginate(30);

        $stats = [
            'total_generes' => CodeCaisse::count(),
            'utilises' => CodeCaisse::where('utilise', true)->count(),
            'disponibles' => CodeCaisse::where('utilise', false)
                ->where(function($q) {
                    $q->whereNull('expire_at')
                      ->orWhere('expire_at', '>', now());
                })->count(),
            'montant_total' => CodeCaisse::sum('montant'),
            'montant_utilise' => CodeCaisse::where('utilise', true)->sum('montant'),
        ];

        return view('admin.auto-ecole.codes-caisse.index', [
            'codes' => $codes,
            'stats' => $stats,
            'search' => $request->search ?? '',
            'status' => $request->status ?? '',
        ]);
    }

    public function create()
    {
        $utilisateurs = AutoEcoleUser::orderBy('nom')->get();
        return view('admin.auto-ecole.codes-caisse.create', compact('utilisateurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'montant' => 'required|numeric|min:10000',
            'quantite' => 'required|integer|min:1|max:50',
            'user_id' => 'nullable|exists:auto_ecole_users,id',
            'expire_at' => 'nullable|date|after:today',
        ]);

        for ($i = 0; $i < $validated['quantite']; $i++) {
            CodeCaisse::create([
                'code' => CodeCaisse::genererCode(),
                'montant' => $validated['montant'],
                'user_id' => $validated['user_id'] ?? null,
                'cree_par' => auth()->id(),
                'expire_at' => $validated['expire_at'] ?? null,
                'utilise' => false,
            ]);
        }

        return redirect()->route('admin.auto-ecole.codes-caisse.index')
            ->with('success', "{$validated['quantite']} code(s) générés avec succès!");
    }

    public function show(CodeCaisse $codes_caisse)
    {
        $codes_caisse->load(['user', 'createur']);
        return view('admin.auto-ecole.codes-caisse.show', ['codeCaisse' => $codes_caisse]);
    }

    public function edit(CodeCaisse $codes_caisse)
    {
        return view('admin.auto-ecole.codes-caisse.edit', ['code' => $codes_caisse]);
    }

    public function update(Request $request, CodeCaisse $codes_caisse)
    {
        $validated = $request->validate([
            'expire_at' => 'nullable|date|after:today',
        ]);

        $codes_caisse->update([
            'expire_at' => $validated['expire_at']
        ]);

        return redirect()->route('admin.auto-ecole.codes-caisse.index')
            ->with('success', 'Code caisse mis à jour!');
    }

    public function destroy(CodeCaisse $codes_caisse)
    {
        if ($codes_caisse->utilise) {
            return redirect()->route('admin.auto-ecole.codes-caisse.index')
                ->with('error', 'Impossible de supprimer un code déjà utilisé!');
        }

        $codes_caisse->delete();

        return redirect()->route('admin.auto-ecole.codes-caisse.index')
            ->with('success', 'Code caisse supprimé avec succès!');
    }

    public function export()
    {
        $codes = CodeCaisse::with(['user', 'createur'])->get();

        $filename = 'codes_caisse_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($codes) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Code', 'Montant', 'Statut', 'Utilisateur', 'Créé par', 'Date création', 'Date utilisation', 'Date expiration']);

            foreach ($codes as $code) {
                fputcsv($file, [
                    $code->code,
                    $code->montant,
                    $code->utilise ? 'Utilisé' : 'Disponible',
                    $code->user ? $code->user->prenom . ' ' . $code->user->nom : '-',
                    $code->createur ? $code->createur->name : 'Système',
                    $code->created_at->format('d/m/Y H:i'),
                    $code->utilise_at ? $code->utilise_at->format('d/m/Y H:i') : '-',
                    $code->expire_at ? $code->expire_at->format('d/m/Y') : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
