<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidRequest extends FormRequest
{
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
     * @return array
     */
    public function rules()
    {
        return [
        'filename'=>'required|mimes:docx',
        'lesson'=>'required'
        ];
    }

    public function messages()
    {
return[
    'lesson.required'=>"كود الدورة والدرس غير صحيح",
        'filename.required'=>"الملــف مطـلوب ",
        'filename.mimes'=>"صيغة الملف غبر صحيحة",
        
        
];
    }
}
