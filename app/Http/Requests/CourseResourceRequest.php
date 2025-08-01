<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseResourceRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'url' => 'nullable|url|max:500',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar,jpg,jpeg,png,gif,mp4,avi,mov|max:10240',
            'description' => 'nullable|string|max:1000',
            'order' => 'sometimes|integer|min:0',
            'is_free' => 'sometimes|boolean',
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

            'name.required' => 'Le nom de la ressource est obligatoire.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',

            'type.required' => 'Le type de ressource est obligatoire.',
            'type.string' => 'Le type doit être une chaîne de caractères.',
            'type.max' => 'Le type ne doit pas dépasser 100 caractères.',

            'url.url' => 'L\'URL doit être valide.',
            'url.max' => 'L\'URL ne doit pas dépasser 500 caractères.',

            'file.file' => 'Le fichier doit être valide.',
            'file.mimes' => 'Le fichier doit être de type : pdf, doc, docx, ppt, pptx, xls, xlsx, txt, zip, rar, jpg, jpeg, png, gif, mp4, avi, mov.',
            'file.max' => 'Le fichier ne doit pas dépasser 10 Mo.',

            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne doit pas dépasser 1000 caractères.',

            'order.integer' => 'L\'ordre doit être un nombre entier.',
            'order.min' => 'L\'ordre ne peut pas être négatif.',

            'is_free.boolean' => 'Le statut gratuit doit être vrai ou faux.',
        ];
    }
}
