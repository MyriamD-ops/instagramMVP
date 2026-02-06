<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = auth()->id();
        
        return [
            'username' => "required|string|max:255|unique:users,username,{$userId}",
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:150',
            'website' => 'nullable|url|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_private' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Le nom d\'utilisateur est obligatoire.',
            'username.unique' => 'Ce nom d\'utilisateur est déjà utilisé.',
            'name.required' => 'Le nom est obligatoire.',
            'bio.max' => 'La bio ne doit pas dépasser 150 caractères.',
            'website.url' => 'Le site web doit être une URL valide.',
            'profile_picture.image' => 'Le fichier doit être une image.',
            'profile_picture.max' => 'La photo de profil ne doit pas dépasser 2 Mo.',
        ];
    }
}
