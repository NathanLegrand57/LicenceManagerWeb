<?php

namespace App\Http\Controllers;

use App\Models\DemandeLicence;
use App\Models\LicenceChoisie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LicenceChoisieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $licences_choisies = $user->licences_choisies;

        $licences_choisies->each(function ($licence) {
            $dateFin = Carbon::parse($licence->date_fin);
            $aujourdhui = Carbon::now();

            if ($dateFin->isPast()) {
                $licence->jours_restants = 0;
            } else {
                $licence->jours_restants = $aujourdhui->diffInDays($dateFin);
            }
        });

        return view('licence-choisie.index', compact('licences_choisies'));
    }

    public function ajouterLicenceClient(Request $request)
    {

        $demandeLicenceId = $request->input('demandeLicenceId');

        // Récupérer la demande de licence associée à cet ID
        $demandeLicence = DemandeLicence::findOrFail($demandeLicenceId);

        $licenceChoisie = new LicenceChoisie();

        // Remplir les données de la licence choisie avec les données de la demande de licence
        $licenceChoisie->licence_id = $demandeLicence->licence_id;
        $licenceChoisie->user_id = $demandeLicence->user_id;
        $licenceChoisie->date_debut = $demandeLicence->date_debut_licence;
        $licenceChoisie->date_fin = $demandeLicence->date_fin_licence;

        $licenceChoisie->save();

        $demandeLicence->delete();

        return redirect()->route('demande-licence.index');
    }

    public function renouvelerLicenceClient(Request $request)
    {
        $demandeLicenceId = $request->input('demandeLicenceId');

        // Récupérer la demande de licence associée à cet ID
        $demandeLicence = DemandeLicence::findOrFail($demandeLicenceId);

        // Trouver la licence choisie existante liée à cette demande de renouvellement
        $licenceChoisie = LicenceChoisie::where('licence_id', $demandeLicence->licence_id)
            ->where('user_id', $demandeLicence->user_id)
            ->first();

        $licenceChoisie->date_debut = $demandeLicence->date_debut_licence;
        $licenceChoisie->date_fin = $demandeLicence->date_fin_licence;

        $licenceChoisie->save();

        $demandeLicence->delete();

        return redirect()->route('demande-licence.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(LicenceChoisie $licenceChoisie)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(LicenceChoisie $licenceChoisie)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, LicenceChoisie $licenceChoisie)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(LicenceChoisie $licenceChoisie)
    // {
    //     //
    // }
}
