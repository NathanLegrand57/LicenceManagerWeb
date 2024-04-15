<?php

namespace App\Http\Controllers;

use App\Http\Repositories\DemandeRenouvellementRepository;
use App\Http\Repositories\DemandeAjoutRepository;
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
    protected $demandeRenouvellementRepository, $demandeAjoutRepository;
    public function __construct(DemandeRenouvellementRepository $demandeRenouvellementRepository, DemandeAjoutRepository $demandeAjoutRepository)
    {
        $this->demandeRenouvellementRepository = $demandeRenouvellementRepository;
        $this->demandeAjoutRepository = $demandeAjoutRepository;
    }

    public function index()
    {
        $demandes_licences = DemandeLicence::all();

        if (Auth::user()->can('gerer-demandes')) {
            return view('demande-licence.index', compact('demandes_licences'));
        }

        abort(401);

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
        $demandeExistante = DemandeLicence::where('licencechoisie_id', $licenceChoisie->id)
            ->where('user_id', Auth::id())
            ->exists();

        // Si une demande de renouvellement existe déjà, retourner un message d'erreur
        if ($demandeExistante) {
            return redirect()->back()->with(session('DemandeEnCours'));
        } else {

            // Sinon créer une nouvelle demande de renouvellement
            $demandeRenouvellement = new DemandeLicence();

            $typeDemande = 0;
            $demandeRenouvellement->a_renouveler = $typeDemande;
            $demandeRenouvellement->duree = $licenceChoisie->licence->duree;

            $demandeRenouvellement->licencechoisie_id = $licenceChoisie->id;
            $demandeRenouvellement->licence_id = $licenceChoisie->licence_id;
            $demandeRenouvellement->user_id = Auth::id();

            $demandeRenouvellement->date_debut_licence = Carbon::parse($licenceChoisie->date_debut);

            $dateFin = Carbon::parse($licenceChoisie->date_fin);

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

        $typeDemande = 1;
        $demandeAjout->a_renouveler = $typeDemande;
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


        // Enregistrement d'une demande de renouvellement de licence

        if ($demandeRenouvellement) {
            $request->validate([
                'date_debut_licence' => 'required|date|after_or_equal:today|before_or_equal:+' . $demandeRenouvellement->licence->duree . ' days',
            ], [
                'date_debut_licence.after_or_equal' => 'La date de début doit être égale ou supérieure à la date actuelle.',
                'date_debut_licence.before_or_equal' => 'La date de début ne peut être supérieure à ' . $demandeRenouvellement->licence->duree . ' jours à partir de la date actuelle.',
            ]);

            $this->demandeRenouvellementRepository->store($request, $demandeRenouvellement);

            Session::flash('success');

            // Supprimer la demande de renouvellement de la session après l'enregistrement
            session()->forget('demandeRenouvellement');


            // Rediriger l'utilisateur vers la page du formulaire de renouvellement
            return redirect()->route('demande-licence.create');
        }

        // Enregistrement d'une demande d'ajout de licence

        $demandeAjout = session('demandeAjout');

        if ($demandeAjout) {
            $request->validate([
                'date_debut_licence' => 'required|date|after_or_equal:today|before_or_equal:+' . $demandeAjout->licence->duree . ' days',
            ], [
                'date_debut_licence.after_or_equal' => 'La date de début doit être égale ou supérieure à la date actuelle.',
                'date_debut_licence.before_or_equal' => 'La date de début ne peut être supérieure à ' . $demandeAjout->licence->duree . ' jours à partir de la date actuelle.',
            ]);

            $this->demandeAjoutRepository->store($request, $demandeAjout);

            Session::flash('success');

            // Supprimer la demande d'ajout de la session après l'enregistrement
            session()->forget('demandeAjout');

            // Rediriger l'utilisateur vers la page du formulaire de renouvellement
            return redirect()->route('demande-licence.create');
        }
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
