<?php

namespace App\Rules;

use App\Models\ProfessionalConversationParticipant;
use App\Models\ProfessionalConverstionParticipant;
use Illuminate\Contracts\Validation\Rule;

class ProfessionalUniqueParticipant implements Rule
{
    public $professionalId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($professionalId)
    {
        $this->professionalId = $professionalId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !ProfessionalConverstionParticipant::where(['user_id'=>$value, 'professional_id'=>$this->professionalId])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Conversation Already Exists';
    }
}
