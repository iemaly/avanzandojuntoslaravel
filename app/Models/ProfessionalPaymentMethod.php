<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalPaymentMethod extends Model
{
    use HasFactory;

    // RELATIONS

    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id', 'id');
    }
}
