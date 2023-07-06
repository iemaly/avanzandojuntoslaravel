<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Elegant\Sanitizer\Laravel\SanitizesInput;

class StoreProfessionalDocumentRequest extends FormRequest
{
    use SanitizesInput;
    
    // public function filters()
    // {
    //     return [
    //         'cat_id' => 'trim|strip_tags|digit',
    //         'title' => 'trim|strip_tags',
    //         'description' => 'trim|strip_tags',
    //         'quantity' => 'trim|strip_tags|digit',
    //         'price' => 'trim|strip_tags|digit',
    //         'discounted_price' => 'trim|strip_tags|digit',
    //         // 'image' => 'trim|strip_tags',
    //         // 'video' => 'trim|strip_tags',
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
            'media' => 'required|array',
            'media.*.type' => 'in:driver_license,ley_300,ley_300,covid_19_vaccine,buena_conduct_certificate,rn_license_certificate',
            'media.*.document' => 'mimetypes:application/pdf,image/jpeg,image/png,image/jpg,image/gif,video/mp4,video/mpeg,video/quicktime|max:500000',
        ];
    }
}
