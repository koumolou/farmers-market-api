<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
   

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
   public function authorize(): bool { return true; }

public function rules(): array
{
    return [
        'name'        => 'sometimes|string|max:150',
        'description' => 'nullable|string',
        'price'       => 'sometimes|numeric|min:0',
        'category_id' => 'sometimes|exists:categories,id',
    ];
}
}
