<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'roole' => 'required',
        ];
    
        // إضافة التحقق من كلمة السر فقط إذا كان الطلب ليس من نوع PUT أو PATCH
        if ($this->method() !== 'PUT' && $this->method() !== 'PATCH') {
            $rules['password'] = 'required|min:8';
        }
    
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'حقل الأسم  مطلوب',
            'name.max' => 'لقد تجاوزت عدد الحروف المطلوبة في حقل الأسم',
            'email.required' => 'حقل البريد الإلكتروني  مطلوب',
            'email.email' => 'حقل البريد الإلكتروني  يجب ان يكون بريد صالح',
            'roole.required' => 'حقل الدور داخل النظام  مطلوب',
        ];
    }
}
