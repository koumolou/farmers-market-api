<?php

namespace App\Http\Requests\Farmer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFarmerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isOperator();
    }

    public function rules(): array
    {
        $farmerId = $this->route('farmer');

        return [
            'firstname'    => 'sometimes|string|max:100',
            'lastname'     => 'sometimes|string|max:100',
            'phone'        => 'sometimes|string|unique:farmers,phone,' . $farmerId,
            'identifier'   => 'sometimes|string|unique:farmers,identifier,' . $farmerId,
            'credit_limit' => 'sometimes|numeric|min:0',
        ];
    }

    public function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException(
            'Only operators can update farmer profiles.'
        );
    }
}