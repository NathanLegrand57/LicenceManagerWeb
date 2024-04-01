<?php

namespace App\Http\Controllers;

use App\Models\DemandeLicence;
use App\Models\LicenceChoisie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        $demandeExistante = DemandeLicence::where('licence_id', $licenceChoisie->licence_id)
            ->where('user_id', Auth::id())
            ->exists();

        // Si une demande de renouvellement existe déjà, retourner un message d'erreur
        if ($demandeExistante) {
            return redirect()->back()->with('error', 'Vous avez déjà une demande de renouvellement en cours pour cette licence.');
        } else {

            // Sinon créer une nouvelle demande de renouvellement
            $demandeRenouvellement = new DemandeLicence();

            $typeDemande = "Renouvellement de licence";
            $demandeRenouvellement->type_demande = $typeDemande;

            $demandeRenouvellement->licencechoisie_id = $licenceChoisie->id;
            $demandeRenouvellement->licence_id = $licenceChoisie->licence_id;
            $demandeRenouvellement->user_id = Auth::id();

            $demandeRenouvellement->date_debut_licence = Carbon::parse($licenceChoisie->date_debut);

            $dateFin = Carbon::parse($licenceChoisie->date_fin);

            // Vérifier si la date de fin est passée (la licence est expirée)
            if ($dateFin->isPast()) {
                // Si la licence est expirée, il faut calculer la nouvelle date de fin à partir de la date actuelle
                $nouvelleDateFin = Carbon::now()->addDays($licenceChoisie->licence->duree);
            } else {
                // Si la licence n'est pas expirée, il faut calculer la nouvelle date de fin à partir de l'ancienne date de fin
                $nouvelleDateFin = $dateFin->addDays($licenceChoisie->licence->duree);
            }

            // Assigner la nouvelle date de fin à la demande de renouvellement
            $demandeRenouvellement->date_fin_licence = $nouvelleDateFin;

            // Stocker la demande de renouvellement en session
            session()->put('demandeRenouvellement', $demandeRenouvellement);

            // Rediriger l'utilisateur vers la page de création de demande de licence
            return redirect()->route('demande-licence.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $demandeRenouvellement = session('demandeRenouvellement');

        // Vérifier si la demande de renouvellement existe
        if ($demandeRenouvellement) {
            // Créer un nouvel objet DemandeLicence
            $nouvelleDemande = new DemandeLicence();

            // Assigner les valeurs de la demande de renouvellement à l'objet DemandeLicence

            $nouvelleDemande->type_demande = $demandeRenouvellement->type_demande;
            $nouvelleDemande->date_debut_licence = Carbon::parse($demandeRenouvellement->date_debut_licence);
            $nouvelleDemande->date_fin_licence = Carbon::parse($demandeRenouvellement->date_fin_licence);
            $nouvelleDemande->licencechoisie_id = $demandeRenouvellement->licencechoisie_id;
            $nouvelleDemande->licence_id = $demandeRenouvellement->licence_id;
            $nouvelleDemande->user_id = $demandeRenouvellement->user_id;

            // Enregistrer la nouvelle demande dans la base de données
            $nouvelleDemande->save();

            Session::flash('success');

            // Supprimer la demande de renouvellement de la session après l'enregistrement
            // session()->forget('demandeRenouvellement');

            // Rediriger l'utilisateur vers une page de confirmation ou une autre page appropriée
            return redirect()->route('demande-licence.create');
        }
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
