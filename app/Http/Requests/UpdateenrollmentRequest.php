<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateenrollmentRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ];
    }
    public function messages(): array
    {
        return [
            'user_id.required' => 'El ID del usuario es obligatorio',
            'user_id.exists' => 'El usuario no existe',
            'course_id.required' => 'El ID del curso es obligatorio',
            'course_id.exists' => 'El curso no existe',
        ];
    }
}
