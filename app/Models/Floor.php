<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;

    public function beds()
    {
        return $this->hasMany(Bed::class, 'floor_id', 'id');
    }
}
