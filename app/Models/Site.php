<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Region;
use App\Models\User;
use App\Models\Courrier;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'site_name', 'site_type', 'region_id', 'ville'
    ];

    public function regions()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function courriers()
    {
        return $this->hasMany(Courrier::class);
    }


}
