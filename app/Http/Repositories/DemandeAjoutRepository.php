<?php

namespace App\Http\Repositories;

use App\Models\DemandeLicence;
use Carbon\Carbon;

class DemandeAjoutRepository
{
    protected $nouvelleDemande;

    public function store($request, $demandeAjout)
    {

        // Créer un nouvel objet DemandeLicence
        $nouvelleDemande = new DemandeLicence();

        // Assigner les valeurs de la demande d'ajout à l'objet DemandeLicence
        $nouvelleDemande->a_renouveler = $demandeAjout->a_renouveler;

        $nouvelleDemande->date_debut_licence = Carbon::parse($request->input('date_debut_licence'));
        $dateDebutLicence = $nouvelleDemande->date_debut_licence;

        // Calculer la date de fin en ajoutant la durée de la licence à la date de début
        $dateFinLicence = $dateDebutLicence->copy()->addDays($demandeAjout->licence->duree);

        $nouvelleDemande->date_fin_licence = $dateFinLicence;

        $nouvelleDemande->licence_id = $demandeAjout->licence_id;
        $nouvelleDemande->user_id = $demandeAjout->user_id;

        // Enregistrer la nouvelle demande dans la base de données
        $nouvelleDemande->save();
    }
}
