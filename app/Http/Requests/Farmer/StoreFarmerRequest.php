<?php

namespace App\Http\Requests\Farmer;

use Illuminate\Foundation\Http\FormRequest;

class StoreFarmerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isOperator();
    }

    public function rules(): array
    {
        return [
            'identifier'   => 'required|string|unique:farmers,identifier',
            'firstname'    => 'required|string|max:100',
            'lastname'     => 'required|string|max:100',
            'phone'        => 'required|string|unique:farmers,phone',
            'credit_limit' => 'sometimes|numeric|min:0',
        ];
    }

    public function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException(
            'Only operators can create farmer profiles.'
        );
    }
}