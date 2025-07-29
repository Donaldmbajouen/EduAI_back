<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = $this->route('user')?->id;

        return [
            'name' => 'required|string|max:199',
            'firstname' => 'required|string|max:199',
            'phone' => 'required|string|max:199',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'sometimes|boolean',
            'email' => 'required|email|max:199|unique:users,email' . ($userId ? ',' . $userId : ''),
            'password' => $this->isMethod('PUT') ? 'nullable|string|min:8' : 'required|string|min:8',
        ];
    }
public function messages(): array
{
    return [
        'name.required' => 'Le nom est obligatoire.',
        'name.string' => 'Le nom doit être une chaîne de caractères.',
        'name.max' => 'Le nom ne doit pas dépasser 199 caractères.',

        'firstname.required' => 'Le prénom est obligatoire.',
        'firstname.string' => 'Le prénom doit être une chaîne de caractères.',
        'firstname.max' => 'Le prénom ne doit pas dépasser 199 caractères.',

        'phone.required' => 'Le numéro de téléphone est obligatoire.',
        'phone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
        'phone.max' => 'Le numéro de téléphone ne doit pas dépasser 199 caractères.',

        'avatar.image' => "L'avatar doit être une image.",
        'avatar.mimes' => "L'avatar doit être un fichier de type : jpeg, png, jpg ou gif.",
        'avatar.max' => "La taille de l'avatar ne doit pas dépasser 2 Mo.",

        'active.boolean' => "Le champ actif doit être vrai ou faux.",

        'email.required' => "L'adresse e-mail est obligatoire.",
        'email.email' => "L'adresse e-mail doit être valide.",
        'email.max' => "L'adresse e-mail ne doit pas dépasser 199 caractères.",
        'email.unique' => "Cette adresse e-mail est déjà utilisée.",

        'password.required' => 'Le mot de passe est obligatoire.',
        'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
    ];
}
}
