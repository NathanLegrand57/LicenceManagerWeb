<?php

namespace App\Http\Repositories;

use App\Models\DemandeLicence;
use Carbon\Carbon;

class DemandeRenouvellementRepository
{
    protected $nouvelleDemande;

    public function store($request, $demandeRenouvellement)
    {

        // Créer un nouvel objet DemandeLicence
        $nouvelleDemande = new DemandeLicence();

        // Assigner les valeurs de la demande de renouvellement à l'objet DemandeLicence

        $nouvelleDemande->type_demande = $demandeRenouvellement->type_demande;

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
    }
}
