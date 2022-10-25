<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Site;
use App\Models\Vehicule;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'itinerary', 'nature', 'value', 'vehicule_id'
    ];

    public function vehicules()
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_id');
    }

    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}
