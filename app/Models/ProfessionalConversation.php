<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalConversation extends Model
{
    use HasFactory;

    protected $table = 'professional_conversations';

    // RELATION

    public function participant()
    {
        return $this->belongsTo(ProfessionalConverstionParticipant::class, 'participant_id', 'id');
    }
}
