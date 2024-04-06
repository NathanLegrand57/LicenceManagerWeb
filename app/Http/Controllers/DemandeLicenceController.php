<?php

namespace App\Http\Controllers;

use App\Models\DemandeLicence;
use App\Models\Licence;
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
        $demandes_licences = DemandeLicence::all();
        return view('demande-licence.index', compact('demandes_licences'));
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
            $demandeRenouvellement->duree = $licenceChoisie->licence->duree;

            $demandeRenouvellement->licencechoisie_id = $licenceChoisie->id;
            $demandeRenouvellement->licence_id = $licenceChoisie->licence_id;
            $demandeRenouvellement->user_id = Auth::id();

            $demandeRenouvellement->date_debut_licence = Carbon::parse($licenceChoisie->date_debut);

            $dateFin = Carbon::parse($licenceChoisie->date_fin);

            // // Vérifier si la date de fin est passée (la licence est expirée)
            // if ($dateFin->isPast()) {
            //     // Si la licence est expirée, il faut calculer la nouvelle date de fin à partir de la date actuelle
            //     $nouvelleDateFin = Carbon::now()->addDays($licenceChoisie->licence->duree);
            // } else {
            //     // Si la licence n'est pas expirée, il faut calculer la nouvelle date de fin à partir de l'ancienne date de fin
            //     $nouvelleDateFin = $dateFin->addDays($licenceChoisie->licence->duree);
            // }

            // Assigner la nouvelle date de fin à la demande de renouvellement
            // $demandeRenouvellement->date_fin_licence = $nouvelleDateFin;

            // Vérifier si une demande d'ajout est en cours et la supprimer si c'est le cas
            if (session()->has('demandeRenouvellement')) {
                session()->forget('demandeRenouvellement');
            }

            if (session()->has('demandeAjout')) {
                session()->forget('demandeAjout');
            }

            // Stocker la demande de renouvellement en session
            session()->put('demandeRenouvellement', $demandeRenouvellement);

            // Rediriger l'utilisateur vers la page de création de demande de licence
            return redirect()->route('demande-licence.create');
        }
    }

    public function ajouter(Licence $licence, Request $request)
    {

        $demandeAjout = new DemandeLicence();

        $typeDemande = "Ajout de licence";
        $demandeAjout->type_demande = $typeDemande;
        $demandeAjout->libelle = $licence->libelle;
        $demandeAjout->duree = $licence->duree;
        $demandeAjout->prix = $licence->prix;
        $demandeAjout->produit = $licence->produit->libelle;

        $demandeAjout->licence_id = $licence->id;
        $demandeAjout->user_id = Auth::id();

        if (session()->has('demandeRenouvellement')) {
            session()->forget('demandeRenouvellement');
        }

        if (session()->has('demandeAjout')) {
            session()->forget('demandeAjout');
        }

        session()->put('demandeAjout', $demandeAjout);

        return redirect()->route('demande-licence.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $demandeRenouvellement = session('demandeRenouvellement');

        $request->validate([
            'date_debut_licence' => 'required|date|after_or_equal:today|before_or_equal:+' . $demandeRenouvellement->licence->duree . ' days',
        ], [
            'date_debut_licence.after_or_equal' => 'La date de début doit être égale ou supérieure à la date actuelle.',
            'date_debut_licence.before_or_equal' => 'La date de début ne peut être supérieure à ' . $demandeRenouvellement->licence->duree . ' jours à partir de la date actuelle.',
        ]);

        // Enregistrement d'une demande de renouvellement de licence

        if ($demandeRenouvellement) {

            // Créer un nouvel objet DemandeLicence
            $nouvelleDemande = new DemandeLicence();

            // Assigner les valeurs de la demande de renouvellement à l'objet DemandeLicence

            $nouvelleDemande->type_demande = $demandeRenouvellement->type_demande;
            // $nouvelleDemande->date_debut_licence = Carbon::parse($demandeRenouvellement->date_debut_licence);
            // $nouvelleDemande->date_fin_licence = Carbon::parse($demandeRenouvellement->date_fin_licence);

            $nouvelleDemande->date_debut_licence = Carbon::parse($request->input('date_debut_licence'));
            $dateDebutLicence = $nouvelleDemande->date_debut_licence;

            // Calculer la date de fin en ajoutant la durée de la licence à la date de début
            $dateFinLicence = $dateDebutLicence->copy()->addDays($demandeRenouvellement->licence->duree);

            $nouvelleDemande->date_fin_licence = $dateFinLicence;

            $nouvelleDemande->licencechoisie_id = $demandeRenouvellement->licencechoisie_id;
            $nouvelleDemande->licence_id = $demandeRenouvellement->licence_id;
            $nouvelleDemande->user_id = $demandeRenouvellement->user_id;

            // Enregistrer la nouvelle demande dans la base de données
            $nouvelleDemande->save();

            Session::flash('success');

            // Supprimer la demande de renouvellement de la session après l'enregistrement
            session()->forget('demandeRenouvellement');

            // Rediriger l'utilisateur vers la page du formulaire de renouvellement
            return redirect()->route('demande-licence.create');
        }

        // Enregistrement d'une demande d'ajout de licence

        $demandeAjout = session('demandeAjout');

        $request->validate([
            'date_debut_licence' => 'required|date|after_or_equal:today|before_or_equal:+' . $demandeAjout->licence->duree . ' days',
        ], [
            'date_debut_licence.after_or_equal' => 'La date de début doit être égale ou supérieure à la date actuelle.',
            'date_debut_licence.before_or_equal' => 'La date de début ne peut être supérieure à ' . $demandeAjout->licence->duree . ' jours à partir de la date actuelle.',
        ]);

        if ($demandeAjout) {

            // Créer un nouvel objet DemandeLicence
            $nouvelleDemande = new DemandeLicence();

            // Assigner les valeurs de la demande d'ajout à l'objet DemandeLicence
            $nouvelleDemande->type_demande = $demandeAjout->type_demande;

            $nouvelleDemande->date_debut_licence = Carbon::parse($request->input('date_debut_licence'));
            $dateDebutLicence = $nouvelleDemande->date_debut_licence;

            // Calculer la date de fin en ajoutant la durée de la licence à la date de début
            $dateFinLicence = $dateDebutLicence->copy()->addDays($demandeAjout->licence->duree);

            $nouvelleDemande->date_fin_licence = $dateFinLicence;


            $nouvelleDemande->licence_id = $demandeAjout->licence_id;
            $nouvelleDemande->user_id = $demandeAjout->user_id;

            // Enregistrer la nouvelle demande dans la base de données
            $nouvelleDemande->save();

            Session::flash('success');

            // Supprimer la demande d'ajout de la session après l'enregistrement
            session()->forget('demandeAjout');

            // Rediriger l'utilisateur vers la page du formulaire de renouvellement
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
        $demandeLicence->delete();
        return redirect()->route("demande-licence.index");
    }
}
