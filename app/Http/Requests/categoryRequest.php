<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class categoryRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json($validator->errors(), 422));
    }


    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'category' =>'required|string|max:20|min:4',
        ];
    }

    public function messages()
    {
        return [
            'required'=>' حقل الفئة مطلوب',
            'string'=>' يجب ان يكون من نوع نصي',
            'max'=>' يجب ان يكون اقب من 20 هرف',
            'min'=>' يجب ان يكون اكبر من 4 هرف',
        ];
    }
}
