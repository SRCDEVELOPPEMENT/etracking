<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Site;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'region_name'
    ];

    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}
