<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Elegant\Sanitizer\Laravel\SanitizesInput;

class UpdateProfessionalRequest extends FormRequest
{
    use SanitizesInput;
    
    // public function filters()
    // {
    //     return [
    //         'fname' => 'trim|strip_tags',
    //         'lname' => 'trim|strip_tags',
    //         'email' => 'trim|strip_tags',
    //         'password' => 'trim|strip_tags',
    //     ];
    // }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'carehome_id' => 'required|exists:professionals,id',
            'type' => 'in:RN,CNA,HHA,Amade Ilave,Nutricionista, Trabajadora Social',
            'fname' => 'required',
            'lname' => 'nullable',
            'email' => 'nullable|email|unique:professionals,email,'.$this->id,
            'password' => 'required',
            'image' => 'nullable',
        ];
    }
}
