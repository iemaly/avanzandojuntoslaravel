<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;

    // RELATION
    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id', 'id');
    }
}
