<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationParticipant extends Model
{
    use HasFactory;

    // RELATIONS

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function carehome()
    {
        return $this->belongsTo(CareHome::class, 'carehome_id', 'id');
    }
}
