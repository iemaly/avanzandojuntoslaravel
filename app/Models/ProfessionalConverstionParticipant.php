<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalConverstionParticipant extends Model
{
    use HasFactory;

    protected $table = 'professional_converstion_participants';

    // RELATIONS

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id', 'id');
    }

    public function conversations()
    {
        return $this->hasMany(ProfessionalConversation::class, 'participant_id', 'id');
    }
}
