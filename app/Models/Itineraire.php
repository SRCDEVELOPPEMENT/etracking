<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Courrier;

class Itineraire extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'lieux_depart',
        'lieux_arrivee',
        'duree'
    ];

    public function courriers()
    {
        return $this->hasMany(Courrier::class);
    }

}