<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RatingFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, response()->json($validator->errors(), 422));
    }

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules()
    {
        if ($this->isMethod('post')) {
            $rules['book_id'] = 'required|exists:books,id';
            $rules['rating'] = 'required|integer|between:1,5';
            $rules['review'] = 'required|string';
        }
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['book_id'] = 'nullable|exists:books,id';
            $rules['rating'] = 'nullable|integer|between:1,5';
            $rules['review'] = 'nullable|string';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'book_id' => 'رقم الكتاب',
            'rating' => 'التقييم',
            'review' => 'التعليق',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'حقل :attribute مطلوب',
            'string' => 'يجب أن يكون حقل :attribute من نوع نصي',
            'integer' => 'يجب أن يكون حقل :attribute من نوع عدد صحيح',
            'between' => 'يجب أن يكون حقل :attribute بين 1 و 5',
            'exists' => 'يجب أن يكون حقل :attribute موجود ضمن جدول الكتب',
        ];
    }
}
