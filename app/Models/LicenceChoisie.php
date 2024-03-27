<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenceChoisie extends Model
{
    use HasFactory;

    public function licence() {
        return $this->belongsTo(Licence::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
