<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DemandeLicence extends Model
{
    use HasFactory, SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function licence()
    {
        return $this->belongsTo(Licence::class);
    }

    public function licencechoisie()
    {
        return $this->belongsTo(LicenceChoisie::class);
    }
}
