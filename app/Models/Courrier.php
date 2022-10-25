<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Personne;
use App\Models\User;
use App\Models\Site;
use App\Models\Itineraire;

class Courrier extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'TypeCourrier', 
        'TypeEnvoie', 
        'objet',
        'destinateur_id',
        'coursier_id', 
        'emetteur_id', 
        'recepteur_id',
        'recepteur_effectif_id',
        'site_exp_id',
        'site_recept_id', 
        'user_create_id',
        'user_recept_id',
        'DateRetraitCourrier',
        'DateReceptCourrier',
        'status',
        'Transitoire',
        'chauffeur_id',
        'itineraire',
    ];

    public function chauffeurs()
    {
        return $this->belongsTo(Personne::class, 'chauffeur_id');
    }


    public function destinateurs()
    {
        return $this->belongsTo(Personne::class, 'destinateur_id');
    }


    public function emetteurs()
    {
        return $this->belongsTo(Personne::class, 'emetteur_id');
    }


    public function recepteurs()
    {
        return $this->belongsTo(Personne::class, 'recepteur_id');
    }

    public function recepteur_effectifs()
    {
        return $this->belongsTo(Personne::class, 'recepteur_effectif_id');
    }



    public function coursiers()
    {
        return $this->belongsTo(Personne::class, 'coursier_id');
    }


    public function users()
    {
        return $this->belongsTo(User::class, 'user_create_id');
    }

    
    public function users_recept()
    {
        return $this->belongsTo(User::class, 'user_recept_id');
    }


    public function site_recepts()
    {
        return $this->belongsTo(Site::class, 'site_recept_id');
    }

    public function site_exps()
    {
        return $this->belongsTo(Site::class, 'site_exp_id');
    }

    public function itineraires()
    {
        return $this->belongsTo(Itineraire::class, 'itineraire');
    }
}