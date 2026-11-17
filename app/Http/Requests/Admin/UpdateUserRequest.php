<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('user')?->id;

        return [
            'employee_id'    => ['required', 'string', 'max:10', Rule::unique('users', 'employee_id')->ignore($userId)],
            'first_name'     => ['required', 'string', 'max:100'],
            'middle_name'    => ['nullable', 'string', 'max:100'],
            'last_name'      => ['required', 'string', 'max:100'],
            'email'          => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'contact_number' => ['required', 'regex:/^9[0-9]{9}$/', 'unique:users,contact_number'],
            'street'         => ['nullable', 'string', 'max:255'],
            'barangay'       => ['nullable', 'string', 'max:100'],
            'city'           => ['nullable', 'string', 'max:100'],
            'province'       => ['nullable', 'string', 'max:100'],
            'zip'            => ['nullable', 'string', 'max:10'],
            'password'       => ['nullable', 'string', 'min:8'],
            'avatar'         => ['nullable']
        ];
    }
}
