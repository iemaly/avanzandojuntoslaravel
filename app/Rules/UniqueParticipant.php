<?php

namespace App\Rules;

use App\Models\ConversationParticipant;
use Illuminate\Contracts\Validation\Rule;

class UniqueParticipant implements Rule
{
    public $carehomeId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($carehomeId)
    {
        $this->carehomeId = $carehomeId;
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
        return !ConversationParticipant::where(['user_id'=>$value, 'carehome_id'=>$this->carehomeId])->exists();
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
