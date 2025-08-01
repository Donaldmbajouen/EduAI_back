<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|url|max:500',
            'order' => 'required|integer|min:1',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'objectives' => 'nullable|string|max:1000',
            'prerequisites' => 'nullable|string|max:1000',
            'status' => 'required|in:draft,review,published,archived',
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
            'course_id.required' => 'Le cours est obligatoire.',
            'course_id.exists' => 'Le cours sélectionné n\'existe pas.',

            'title.required' => 'Le titre de la leçon est obligatoire.',
            'title.string' => 'Le titre doit être une chaîne de caractères.',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères.',

            'content.required' => 'Le contenu de la leçon est obligatoire.',
            'content.string' => 'Le contenu doit être une chaîne de caractères.',

            'video_url.url' => 'L\'URL de la vidéo doit être valide.',
            'video_url.max' => 'L\'URL de la vidéo ne doit pas dépasser 500 caractères.',

            'order.required' => 'L\'ordre de la leçon est obligatoire.',
            'order.integer' => 'L\'ordre doit être un nombre entier.',
            'order.min' => 'L\'ordre doit être supérieur à 0.',

            'difficulty_level.required' => 'Le niveau de difficulté est obligatoire.',
            'difficulty_level.in' => 'Le niveau de difficulté doit être : easy, medium ou hard.',

            'objectives.string' => 'Les objectifs doivent être une chaîne de caractères.',
            'objectives.max' => 'Les objectifs ne doivent pas dépasser 1000 caractères.',

            'prerequisites.string' => 'Les prérequis doivent être une chaîne de caractères.',
            'prerequisites.max' => 'Les prérequis ne doivent pas dépasser 1000 caractères.',

            'status.required' => 'Le statut de la leçon est obligatoire.',
            'status.in' => 'Le statut doit être : draft, review, published ou archived.',
        ];
    }
}
