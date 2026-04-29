<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        'name'      => 'sometimes|string|max:100',
        'parent_id' => 'nullable|exists:categories,id',
    ];
}
}
