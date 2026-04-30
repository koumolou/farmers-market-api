<?php

namespace App\Http\Requests\Repayment;

use Illuminate\Foundation\Http\FormRequest;

class StoreRepaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isOperator();
    }

    public function rules(): array
    {
        return [
            'farmer_id'   => 'required|exists:farmers,id',
            'kg_received' => 'required|numeric|min:0.001',
        ];
    }

    public function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException(
            'Only operators can record repayments.'
        );
    }
}