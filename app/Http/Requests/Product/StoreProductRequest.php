<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:products',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'category' => 'required|integer|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'O nome do produto é obrigatório',
            'name.string' => 'O nome do produto deve ser uma string',
            'name.unique' => 'Esse nome de produto ja existe',
            'name.regex' => 'O nome do produto deve conter apenas letras minúsculas',
            'price.required' => 'O preço do produto é obrigatório',
            'price.integer' => 'O preço do produto deve ser um inteiro',
            'description.required' => 'A descrição do produto é obrigatória',
            'description.string' => 'A descrição do produto deve ser uma string',
            'category.required' => 'A categoria do produto é obrigatória',
            'category.exists' => 'Essa categoria nao existe',
            'image.string' => 'A imagem do produto deve ser uma string',
            'image.image' => 'O campo imagem deve ser uma imagem',
            'image.mimes' => 'O campo imagem deve ser uma imagem do tipo jpeg, png, jpg ou gif',
            'image.max' => 'O campo imagem deve ter no maúximo 2MB',
        ];
    }

    protected function prepareForValidation()
    {
        $this->replace(array_merge($this->all(), ['price' => floatval(str_replace(',', '.', $this->price))]));
    }
}
