<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Le commentaire ne peut pas être vide.',
            'content.max' => 'Le commentaire ne doit pas dépasser 500 caractères.',
        ];
    }
}
