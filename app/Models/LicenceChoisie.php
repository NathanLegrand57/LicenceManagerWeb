<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LicenceChoisie extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'licences_choisies';

    public function licence()
    {
        return $this->belongsTo(Licence::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function demandes_licences()
    {
        return $this->hasMany(DemandeLicence::class);
    }
}
