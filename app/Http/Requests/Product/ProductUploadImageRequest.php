<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductUploadImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Autorização para todas as requisições
    }

    public function rules(): array
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'O campo imagem é obrigatório',
            'image.image' => 'O campo imagem deve ser uma imagem',
            'image.mimes' => 'O campo imagem deve ser uma imagem do tipo jpeg, png, jpg ou gif',
            'image.max' => 'O campo imagem deve ter no maúximo 2MB',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
