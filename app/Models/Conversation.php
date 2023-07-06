<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    // RELATION

    public function participant()
    {
        return $this->belongsTo(ConversationParticipant::class, 'participant_id', 'id');
    }
}
