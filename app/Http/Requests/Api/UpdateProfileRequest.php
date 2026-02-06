<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $userId = auth()->id();

        return [
            'username' => "required|string|max:30|alpha_dash|unique:users,username,{$userId}",
            'name' => 'required|string|min:2|max:50',
            'bio' => 'nullable|string|max:150',
            'website' => 'nullable|url|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_private' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Le nom d\'utilisateur est requis.',
            'username.unique' => 'Ce nom d\'utilisateur est déjà pris.',
            'username.alpha_dash' => 'Le nom d\'utilisateur ne peut contenir que des lettres, chiffres, tirets et underscores.',
            'username.max' => 'Le nom d\'utilisateur ne doit pas dépasser 30 caractères.',
            'name.required' => 'Le nom est requis.',
            'name.min' => 'Le nom doit contenir au moins 2 caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 50 caractères.',
            'bio.max' => 'La biographie ne doit pas dépasser 150 caractères.',
            'website.url' => 'L\'URL du site web n\'est pas valide.',
            'profile_picture.image' => 'Le fichier doit être une image.',
            'profile_picture.mimes' => 'L\'image doit être au format: jpeg, png, jpg, gif ou webp.',
            'profile_picture.max' => 'L\'image ne doit pas dépasser 2 Mo.',
        ];
    }
}
