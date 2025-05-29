<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'phone' => 'required|numeric|digits:12',
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
            'phone.required' => 'حقل رقم الهاتفي  مطلوب',
            'phone.numeric' => 'حقل رقم الهاتف  يجب ان يكون ارقام فقط',
            'phone.digits' => 'حقل رقم الهاتف  يجب ان يتكون من 12 رقم',
        ];
    }
}
