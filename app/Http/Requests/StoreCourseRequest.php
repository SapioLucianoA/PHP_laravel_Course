<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category_id' => 'required|exists:categories,id',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Debe proporcionar un título para el curso',
            'title.max' => 'El título no puede exceder los 255 caracteres',
            'description.max' => 'La descripción no puede exceder los 1000 caracteres',
            'description.required' => 'La descripción es obligatoria',
            'category_id.exists' => 'La categoría seleccionada no está disponible o no existe',
        ];
    }
}
