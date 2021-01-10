<?php

namespace App\Http\Requests\Produtos;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoDescontoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'valor' => 'required|numeric|gt:0',
            'data_limite' => 'required|date|after:now'
        ];
    }

    public function messages()
    {
        return [
            'data_limite.after' => 'O campo :attribute deve ser posterior a data atual.'
        ];
    }
}
