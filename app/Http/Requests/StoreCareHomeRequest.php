<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Elegant\Sanitizer\Laravel\SanitizesInput;

class StoreCareHomeRequest extends FormRequest
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
            'director' => 'nullable',
            'address' => 'nullable',
            'town' => 'nullable',
            'telephone' => 'nullable',
            'email' => 'nullable|email|unique:care_homes,email',
            'license' => 'nullable',
            'license_status' => 'nullable',
            'ability' => 'nullable',
            'image' => 'nullable',
            'password' => 'nullable',
            'pricing' => 'nullable',
        ];
    }
}
