<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;

    // RELATIONS
    public function beds()
    {
        return $this->hasMany(Bed::class, 'floor_id', 'id');
    }

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id', 'id');
    }

    public function blueprint()
    {
        return $this->belongsTo(CareHomeMedia::class, 'blueprint_id', 'id');
    }
}
