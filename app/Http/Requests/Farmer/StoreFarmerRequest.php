<?php

namespace App\Http\Requests\Farmer;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFarmerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
   public function rules(): array {
    return [
        'identifier'   => 'required|string|unique:farmers,identifier',
        'firstname'    => 'required|string|max:100',
        'lastname'     => 'required|string|max:100',
        'phone'        => 'required|string|unique:farmers,phone',
        'credit_limit' => 'sometimes|numeric|min:0',
    ];
}
}
