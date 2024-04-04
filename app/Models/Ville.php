<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ville extends Model
{
    use HasFactory, SoftDeletes;
    public function adresses() {
        return $this->hasMany(Adresse::class);
    }
}
