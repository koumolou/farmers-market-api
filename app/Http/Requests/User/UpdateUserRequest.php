<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
   

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
 public function authorize(): bool { return true; }

public function rules(): array
{
    $userId = $this->route('user'); // matches route parameter name

    return [
        'name'     => 'sometimes|string|max:100',
        'email'    => 'sometimes|email|unique:users,email,' . $userId,
        'password' => 'sometimes|string|min:8|confirmed',
    ];
}
}
