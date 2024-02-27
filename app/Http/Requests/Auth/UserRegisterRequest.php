<?php

namespace App\Http\Requests\Auth;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
        return [
            'name' => ['required','string','max:255'],
            'username' => ['required','string','unique:admin_users,username'],
            'role_id' => ['required','string','exists:roles,id'],
            'phone' => ['required','string','unique:admin_users,phone'],
            'email' => ['required','string','unique:admin_users,email'],
            'address' => ['required','string','max:255'],
            'password' => ['required'],
            'gender' => ['required',Rule::in('male', 'female')],
            'is_active' => ['required','boolean'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'username' => Str::slug($this->name),
        ]);
    }
}
