<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Licence;
use Illuminate\Http\Request;

class LicenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $licences = Licence::all();

        // Création d'un tableau pour stocker les informations de chaque licence
        $informationsLicences = [];

        foreach ($licences as $licence) {
            $informationsLicence = new Licence();
            $informationsLicence->id = $licence->id;
            $informationsLicence->libelle = $licence->libelle;
            $informationsLicence->duree = $licence->duree;
            $informationsLicence->produit_id = $licence->produit_id;
            $informationsLicence->libelleProduit = $licence->produit->libelle;

            // Ajout de l'objet contenant les informations de la licence au tableau
            $informationsLicences[] = $informationsLicence;
        }

        // On retourne les informations des licences en JSON
        return response()->json($informationsLicences);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
