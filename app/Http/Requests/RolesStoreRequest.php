<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolesStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if($this->user()->can('إضافة الأدوار والصلاحيات')) {
            return true;
        }else{
            return false;
        }
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'permission' => 'required|array|min:1',
            'permission.*' => 'exists:permissions,name',
            'role' => 'required|unique:roles,name|max:60',
        ];
    }

    public function messages(): array
    {
        return [
            'permission.required' => ' الصلاحيات مطلوبة.',
            'permission.*.exists' => 'إحدى الصلاحيات المحددة غير موجودة في النظام.',
            'role.required' => 'حقل الدور مطلوب.',
            'role.unique' => 'هذا الدور مسجل مسبقاً.',
            'role.max' => 'يجب ألا يتجاوز اسم الدور 60 حرفاً.',
        ];
    }
}