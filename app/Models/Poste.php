<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Personne;

class Poste extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'intitulePoste','descriptionPoste'
    ];

    public function personnes()
    {
        return $this->hasMany(Personne::class);
    }

}
