<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BorrowRecordFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json($validator->errors(), 422));
    }

    public function authorize(): bool
    {
        return auth()->check();
    }

    //**________________________________________________________________________________________________

    protected function prepareForValidation()
    {
        // for borrow a book
        if ($this->isMethod('post')) {
            // Correct the date format and calculate returned date
            $this->merge([
                'borrowed_at' => date('Y-m-d', strtotime($this->input('borrowed_at'))),

            ]);
        }
        // for return book
        elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $this->merge([
                'due_date' => date('Y-m-d', strtotime($this->input('due_date'))),
            ]);
        }
    }

    //**________________________________________________________________________________________________
    public function rules(): array
    {
        $rules = [];

        if ($this->isMethod('get')) {
            $rules['borrowed_at'] = 'nullable|date';
        } elseif ($this->isMethod('post')) {
            // Rules for creating a borrowed book record
            $rules['book_id'] = 'required|exists:books,id';
            $rules['borrowed_at'] = 'required|date|before:tomorrow';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            // Rules for updating a borrowed book record
            $rules['due_date'] = 'required|date';
        } elseif ($this->isMethod('delet')) {
            // Rules for creating a borrowed book record
            $rules['update_at'] = 'required|exists:books,id';
        }

        return $rules;
    }

    //**________________________________________________________________________________________________

    public function attributes(): array
    {
        return [
            'book_id' => 'رقم الكتاب',
            'due_date' => 'تاريخ الإعادة',
            'borrowed_at' => 'تاريخ الاستعارة'
        ];
    }
    //**________________________________________________________________________________________________
    public function messages(): array
    {
        return [
            'required' => 'حقل :attribute مطلوب',
            'string' => 'يجب أن يكون حقل :attribute من نوع نصي',
            'date' => 'يجب أن يكون حقل :attribute تاريخ صالح',
            'exists' => 'يجب أن يكون حقل :attribute موجود ضمن جدول الكتب',
            'before' => 'يجب أن يكون :attribute قبل الغد',
            'after' => 'يجب أن يكون :attribute بعد تاريخ الاستعارة',
        ];
    }
}
