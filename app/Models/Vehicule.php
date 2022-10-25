<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Personne;


class Vehicule extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'Immatriculation', 'NumeroSerie', 'MarqueVehicule', 'StatutVehicule'
    ];

    public function personnes()
    {
        return $this->hasMany(Personne::class);
    }

}
