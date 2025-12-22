<?php

namespace App\Http\Controllers\Admin\AutoEcole;

use App\Http\Controllers\Controller;
use App\Models\ConfigPaiement;
use App\Models\CentreExamen;
use App\Models\LieuPratique;
use App\Models\JourPratique;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        $config = ConfigPaiement::getConfig();
        $centresExamen = CentreExamen::orderBy('nom')->get();
        $lieuxPratique = LieuPratique::with('joursPratique')->orderBy('nom')->get();

        return view('admin.auto-ecole.config.index', compact('config', 'centresExamen', 'lieuxPratique'));
    }

    public function updateFrais(Request $request)
    {
        $validated = $request->validate([
            'frais_formation' => 'required|numeric|min:0',
            'frais_inscription' => 'required|numeric|min:0',
            'frais_examen_blanc' => 'required|numeric|min:0',
            'frais_examen' => 'required|numeric|min:0',
            'depot_minimum' => 'required|numeric|min:1000'
        ]);

        $config = ConfigPaiement::getConfig();
        $config->update($validated);

        return redirect()->back()->with('success', 'Frais mis à jour avec succès');
    }

    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'code_parrainage_defaut' => 'nullable|string',
            'whatsapp_support' => 'nullable|string',
            'lien_telechargement_app' => 'nullable|url'
        ]);

        $config = ConfigPaiement::getConfig();
        $config->update($validated);

        return redirect()->back()->with('success', 'Configuration mise à jour avec succès');
    }

    // Centres d'examen
    public function storeCentreExamen(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string',
            'ville' => 'nullable|string',
            'active' => 'boolean'
        ]);

        $validated['active'] = $request->has('active');

        CentreExamen::create($validated);

        return redirect()->back()->with('success', 'Centre d\'examen ajouté avec succès');
    }

    public function updateCentreExamen(Request $request, CentreExamen $centreExamen)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string',
            'ville' => 'nullable|string',
            'active' => 'boolean'
        ]);

        $validated['active'] = $request->has('active');

        $centreExamen->update($validated);

        return redirect()->back()->with('success', 'Centre d\'examen mis à jour avec succès');
    }

    public function destroyCentreExamen(CentreExamen $centreExamen)
    {
        try {
            $centreExamen->delete();
            return redirect()->back()->with('success', 'Centre d\'examen supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    // Lieux de pratique
    public function storeLieuPratique(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string',
            'ville' => 'nullable|string',
            'active' => 'boolean'
        ]);

        $validated['active'] = $request->has('active');

        LieuPratique::create($validated);

        return redirect()->back()->with('success', 'Lieu de pratique ajouté avec succès');
    }

    public function updateLieuPratique(Request $request, LieuPratique $lieuPratique)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string',
            'ville' => 'nullable|string',
            'active' => 'boolean'
        ]);

        $validated['active'] = $request->has('active');

        $lieuPratique->update($validated);

        return redirect()->back()->with('success', 'Lieu de pratique mis à jour avec succès');
    }

    public function destroyLieuPratique(LieuPratique $lieuPratique)
    {
        try {
            $lieuPratique->delete();
            return redirect()->back()->with('success', 'Lieu de pratique supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    // Jours de pratique
    public function storeJourPratique(Request $request)
    {
        $validated = $request->validate([
            'lieu_pratique_id' => 'required|exists:lieux_pratique,id',
            'jour' => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'active' => 'boolean'
        ]);

        $validated['active'] = $request->has('active') ? true : false;

        JourPratique::create($validated);

        return redirect()->back()->with('success', 'Jour de pratique ajouté avec succès');
    }

    public function updateJourPratique(Request $request, JourPratique $jourPratique)
    {
        $validated = $request->validate([
            'jour' => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'active' => 'boolean'
        ]);

        $validated['active'] = $request->has('active');

        $jourPratique->update($validated);

        return redirect()->back()->with('success', 'Jour de pratique mis à jour avec succès');
    }

    public function destroyJourPratique(JourPratique $jourPratique)
    {
        try {
            $jourPratique->delete();
            return redirect()->back()->with('success', 'Jour de pratique supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
}
