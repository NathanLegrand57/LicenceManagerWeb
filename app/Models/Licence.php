<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Licence extends Model
{
    use HasFactory;

    public function produit() {
        return $this->belongsTo(Produit::class);
    }

    public function licences_choisies() {
        return $this->hasMany(LicenceChoisie::class);
    }
}