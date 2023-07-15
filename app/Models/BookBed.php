<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookBed extends Model
{
    use HasFactory;

    // RELATION

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bed()
    {
        return $this->belongsTo(Bed::class, 'bed_id', 'id');
    }
}
