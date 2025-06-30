<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la categoría es obligatorio',
            'name.max' => 'El nombre no puede exceder los 255 caracteres',
            'description.required' => 'La descripción es obligatoria',
            'description.max' => 'La descripción no puede exceder los 500 caracteres',
        ];
    }
}
