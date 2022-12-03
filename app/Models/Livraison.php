<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicule;
use App\Models\User;
use App\Models\Recipe;

class Livraison extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'order_number',
        'state',
        'delivery_date',
        'really_delivery_state',
        'tonnage',
        'delivery_amount',
        'amount_paye',
        'distance',
        'vehicule_id',
        'recipe_id',
        'user_id',
        'nom_client',
        'phone_client',
        'itinerary',
        'observation',
        'type_livraison',
        'etat_livraison',
        'destination',
    ];

    public function vehicules()
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_id');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class, 'recipe_id');
    }
}
