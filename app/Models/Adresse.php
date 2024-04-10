<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adresse extends Model
{
    use HasFactory, SoftDeletes;

    public function ville() {
        return $this->belongsTo(Ville::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }

    protected $fillable = [
        'rue',
    ];
}
