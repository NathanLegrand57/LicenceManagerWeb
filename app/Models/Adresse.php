<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adresse extends Model
{
    use HasFactory;

    public function ville() {
        return $this->belongsTo(Ville::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }
}
