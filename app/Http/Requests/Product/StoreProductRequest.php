<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        'name'        => 'required|string|max:150',
        'description' => 'nullable|string',
        'price'       => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
    ];
}
}
