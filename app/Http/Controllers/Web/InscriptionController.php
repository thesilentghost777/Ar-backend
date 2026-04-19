<?php

namespace App\Http\Controllers\Web;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
class InscriptionController extends Controller
{
    /**
     * Affiche le formulaire d'inscription web.
     * L'URL peut transporter ?ref=CODE_PARRAINAGE pour préremplir le champ.
     *
     * Route GET : /inscription  (ou /register si vous préférez)
     */
    public function index(Request $request)
    {
        // On récupère le code de parrainage éventuel dans l'URL (?ref=XXX)
        // Il est passé à la vue et injecté dans la valeur initiale du champ.
        $refCode = strtoupper($request->query('ref', ''));
 
        return view('web.inscription', compact('refCode'));
    }
}
 
