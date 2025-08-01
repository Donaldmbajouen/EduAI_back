<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'level' => 'required|in:beginner,intermediate,advanced',
            'is_published' => 'sometimes|boolean',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'sometimes|numeric|min:0|max:5',
            'views_count' => 'sometimes|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'resources' => 'nullable|array',
            'resources.*.name' => 'required|string|max:255',
            'resources.*.type' => 'required|string|max:100',
            'resources.*.url' => 'nullable|url|max:500',
            'resources.*.file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar,jpg,jpeg,png,gif,mp4,avi,mov|max:10240',
            'resources.*.description' => 'nullable|string|max:1000',
            'resources.*.order' => 'nullable|integer|min:0',
            'resources.*.is_free' => 'nullable|boolean',
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
            'title.required' => 'Le titre du cours est obligatoire.',
            'title.string' => 'Le titre doit être une chaîne de caractères.',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères.',

            'description.required' => 'La description du cours est obligatoire.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne doit pas dépasser 1000 caractères.',

            'level.required' => 'Le niveau du cours est obligatoire.',
            'level.in' => 'Le niveau doit être : beginner, intermediate ou advanced.',

            'is_published.boolean' => 'Le statut de publication doit être vrai ou faux.',

            'thumbnail.image' => 'Le thumbnail doit être une image.',
            'thumbnail.mimes' => 'Le thumbnail doit être un fichier de type : jpeg, png, jpg ou gif.',
            'thumbnail.max' => 'La taille du thumbnail ne doit pas dépasser 2 Mo.',

            'rating.numeric' => 'La note doit être un nombre.',
            'rating.min' => 'La note ne peut pas être inférieure à 0.',
            'rating.max' => 'La note ne peut pas dépasser 5.',

            'views_count.integer' => 'Le nombre de vues doit être un entier.',
            'views_count.min' => 'Le nombre de vues ne peut pas être négatif.',

            'category_id.required' => 'La catégorie est obligatoire.',
            'category_id.exists' => 'La catégorie sélectionnée n\'existe pas.',

            'user_id.required' => 'L\'utilisateur est obligatoire.',
            'user_id.exists' => 'L\'utilisateur sélectionné n\'existe pas.',

            'resources.array' => 'Les ressources doivent être un tableau.',
            'resources.*.name.required' => 'Le nom de la ressource est obligatoire.',
            'resources.*.type.required' => 'Le type de ressource est obligatoire.',
            'resources.*.url.url' => 'L\'URL de la ressource doit être valide.',
            'resources.*.file.file' => 'Le fichier de la ressource doit être valide.',
            'resources.*.file.mimes' => 'Le fichier doit être de type supporté.',
            'resources.*.file.max' => 'Le fichier ne doit pas dépasser 10 Mo.',
        ];
    }
}
