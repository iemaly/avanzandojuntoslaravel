<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Elegant\Sanitizer\Laravel\SanitizesInput;

class UpdatePlanRequest extends FormRequest
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
            'professional_type' => 'nullable|in:RN,CNA,HHA,Amade Ilave,Nutricionista, Trabajadora Social',
            'type' => 'in:Professional,Business,User',
            'professional_type' => 'nullable',
            'title' => 'nullable',
            'description' => 'nullable',
            'coupon_discount' => 'nullable',
            'coupon' => 'nullable',
            'duration_type' => 'in:day,week,month',
            'duration' => 'nullable',
            'price' => 'nullable',
        ];
    }
}
