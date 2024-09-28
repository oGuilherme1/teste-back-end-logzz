<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'required|string|unique:categories,name',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'O nome da categoria é obrigatório',
            'name.string' => 'O nome da categoria deve ser uma string',
            'name.unique' => 'O nome da categoria deve ser unico',
        ];
    }

}
