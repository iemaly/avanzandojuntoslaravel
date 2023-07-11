<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    // RELATIONS
    
    public function floors()
    {
        return $this->hasMany(Floor::class, 'building_id', 'id');
    }
}
