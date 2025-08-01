<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExerciseRequest extends FormRequest
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
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'type' => 'required|in:quiz_single,quiz_multiple',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'points' => 'sometimes|integer|min:0',
            'time_limit' => 'nullable|integer|min:1',
            'is_active' => 'sometimes|boolean',
            'order' => 'sometimes|integer|min:0',
            'passing_score' => 'sometimes|integer|min:0|max:100',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string|max:1000',
            'questions.*.question_type' => 'required|in:text,image',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.order' => 'required|integer|min:0',
            'questions.*.answers' => 'required|array|min:2',
            'questions.*.answers.*.answer_text' => 'required|string|max:500',
            'questions.*.answers.*.is_correct' => 'required|boolean',
            'questions.*.answers.*.explanation' => 'nullable|string|max:1000',
            'questions.*.answers.*.order' => 'required|integer|min:0',
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
            'lesson_id.required' => 'La leçon est obligatoire.',
            'lesson_id.exists' => 'La leçon sélectionnée n\'existe pas.',

            'title.required' => 'Le titre de l\'exercice est obligatoire.',
            'title.string' => 'Le titre doit être une chaîne de caractères.',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères.',

            'description.required' => 'La description de l\'exercice est obligatoire.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne doit pas dépasser 1000 caractères.',

            'type.required' => 'Le type d\'exercice est obligatoire.',
            'type.in' => 'Le type doit être : quiz_single ou quiz_multiple.',

            'difficulty_level.required' => 'Le niveau de difficulté est obligatoire.',
            'difficulty_level.in' => 'Le niveau de difficulté doit être : easy, medium ou hard.',

            'points.integer' => 'Les points doivent être un nombre entier.',
            'points.min' => 'Les points ne peuvent pas être négatifs.',

            'time_limit.integer' => 'La limite de temps doit être un nombre entier.',
            'time_limit.min' => 'La limite de temps doit être d\'au moins 1 minute.',

            'passing_score.integer' => 'Le score de passage doit être un nombre entier.',
            'passing_score.min' => 'Le score de passage ne peut pas être négatif.',
            'passing_score.max' => 'Le score de passage ne peut pas dépasser 100%.',

            'questions.required' => 'Au moins une question est requise.',
            'questions.array' => 'Les questions doivent être un tableau.',
            'questions.min' => 'Au moins une question est requise.',

            'questions.*.question_text.required' => 'Le texte de la question est obligatoire.',
            'questions.*.question_text.max' => 'Le texte de la question ne doit pas dépasser 1000 caractères.',

            'questions.*.question_type.required' => 'Le type de question est obligatoire.',
            'questions.*.question_type.in' => 'Le type de question doit être : text ou image.',

            'questions.*.points.required' => 'Les points de la question sont obligatoires.',
            'questions.*.points.integer' => 'Les points doivent être un nombre entier.',
            'questions.*.points.min' => 'Les points doivent être d\'au moins 1.',

            'questions.*.answers.required' => 'Au moins deux réponses sont requises.',
            'questions.*.answers.min' => 'Au moins deux réponses sont requises.',

            'questions.*.answers.*.answer_text.required' => 'Le texte de la réponse est obligatoire.',
            'questions.*.answers.*.answer_text.max' => 'Le texte de la réponse ne doit pas dépasser 500 caractères.',

            'questions.*.answers.*.is_correct.required' => 'Il faut indiquer si la réponse est correcte.',
            'questions.*.answers.*.is_correct.boolean' => 'La valeur doit être true ou false.',
        ];
    }
}
