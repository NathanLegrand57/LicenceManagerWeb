<?php

namespace App\Http\Controllers;

use App\Models\DemandeLicence;
use App\Models\LicenceChoisie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeLicenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $demandes_licences = DemandeLicence::all();
        return view('demande-licence.create', compact('demandes_licences'));
    }

    public function renouveler(LicenceChoisie $licenceChoisie)
    {
        // Créer une nouvelle demande de renouvellement
        $demandeRenouvellement = new DemandeLicence();
        $demandeRenouvellement->licence_id = $licenceChoisie->licence_id;
        // Autres attributs de la demande de renouvellement
        $demandeRenouvellement->debut_licence = $licenceChoisie->date_debut;
        $demandeRenouvellement->user_id = Auth::id();

        // Stocker la demande de renouvellement en session
        session()->put('demandeRenouvellement', $demandeRenouvellement);

        // Rediriger l'utilisateur vers la page de création de demande de licence
        return redirect()->route('demande-licence.create');
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $demande = new DemandeLicence();

        $demande->libelle = $data['libelle'];
        $demande->quantite = $data['quantite'];

        $demande->save();

        return redirect()->route('mes-licences.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(DemandeLicence $demandeLicence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DemandeLicence $demandeLicence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DemandeLicence $demandeLicence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DemandeLicence $demandeLicence)
    {
        //
    }
}
