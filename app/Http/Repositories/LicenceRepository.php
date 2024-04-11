<?php

namespace App\Http\Repositories;

use App\Models\Licence;

class LicenceRepository
{
    protected $licence;

    public function store($request)
    {
        $data = $request->all();
        $licence = new Licence;
        $licence->libelle = $data['libelle'];
        $licence->prix = $data['prix'];
        $licence->duree = $data['duree'];
        $licence->produit_id = $data['produit_id'];

        $licence->save();
    }
}
