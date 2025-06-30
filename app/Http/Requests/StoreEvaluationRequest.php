<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationRequest extends FormRequest
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
                'score' => 'required|numeric|min:0|max:10',
                'feedback' => 'nullable|string|max:1000',
                'enrollment_id' => 'required|exists:enrollments,id',
        ];
    }
    public function messages(): array
    {
        return [
            'score.required' => 'El puntaje es obligatorio',
            'score.numeric' => 'El puntaje debe ser un número',
            'score.min' => 'El puntaje no puede ser menor a 0',
            'score.max' => 'El puntaje no puede ser mayor a 10',
            'feedback.max' => 'El feedback no puede exceder los 1000 caracteres',
            'enrollment_id.required' => 'El ID de inscripción es obligatorio',
            'enrollment_id.exists' => 'La inscripción especificada no existe',
        ];
    }
}
