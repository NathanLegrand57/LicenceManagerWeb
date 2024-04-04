<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Licence extends Model
{
    use HasFactory, SoftDeletes;

    public function produit() {
        return $this->belongsTo(Produit::class);
    }

    public function licences_choisies() {
        return $this->hasMany(LicenceChoisie::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
