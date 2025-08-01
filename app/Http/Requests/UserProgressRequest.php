<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProgressRequest extends FormRequest
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
            'lesson_id' => 'nullable|exists:lessons,id',
            'status' => 'sometimes|in:not_started,in_progress,completed,paused',
            'progress_percentage' => 'sometimes|integer|min:0|max:100',
            'time_spent' => 'sometimes|integer|min:0',
            'notes' => 'nullable|string|max:1000',
            'is_favorite' => 'sometimes|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'L\'utilisateur est obligatoire.',
            'user_id.exists' => 'L\'utilisateur sélectionné n\'existe pas.',

            'course_id.required' => 'Le cours est obligatoire.',
            'course_id.exists' => 'Le cours sélectionné n\'existe pas.',

            'lesson_id.exists' => 'La leçon sélectionnée n\'existe pas.',

            'status.in' => 'Le statut doit être : not_started, in_progress, completed ou paused.',

            'progress_percentage.integer' => 'Le pourcentage de progression doit être un entier.',
            'progress_percentage.min' => 'Le pourcentage de progression ne peut pas être négatif.',
            'progress_percentage.max' => 'Le pourcentage de progression ne peut pas dépasser 100.',

            'time_spent.integer' => 'Le temps passé doit être un entier.',
            'time_spent.min' => 'Le temps passé ne peut pas être négatif.',

            'notes.string' => 'Les notes doivent être une chaîne de caractères.',
            'notes.max' => 'Les notes ne doivent pas dépasser 1000 caractères.',

            'is_favorite.boolean' => 'Le statut favori doit être vrai ou faux.',
        ];
    }
}
