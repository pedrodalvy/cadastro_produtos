<?php

namespace App\Http\Requests\Produtos;

use App\Domain\Enums\ProdutoEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CadastrarProdutoRequest extends FormRequest
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
        $rules = $this->getProdutoRules();

        switch ($this->get('tipo_id')) {
            case ProdutoEnum::PRODUTO_DIGITAL:
                return $this->getProdutoDigitalRules($rules);

            case ProdutoEnum::PRODUTO_CONFIGURAVEL:
                return $this->getProdutoConfiguravelRules($rules);

            case ProdutoEnum::PRODUTO_AGRUPADO:
                return $this->getProdutoAgrupadoRules($rules);

            default:
                return $rules;
        }
    }

    private function getProdutoRules(): array
    {
        return [
            'nome' => 'required|string|max:100|unique:App\Models\Produto,nome',
            'descricao' => 'required|string|max:2500',
            'tipo_id' => ['required', 'integer', Rule::in(ProdutoEnum::getValues())],
            'valor' => 'required|numeric|gt:0',
        ];
    }

    private function getProdutoDigitalRules($rules): array
    {
        $rules['link'] = 'required|url';
        return $rules;
    }

    private function getProdutoConfiguravelRules($rules): array
    {
        $rules['configuracao'] = 'required|array|min:2';
        $rules['configuracao.*'] = 'required|array';
        $rules['configuracao.*.nome'] = 'required|string|max:50';
        $rules['configuracao.*.valor'] = 'required|max:50';
        return $rules;
    }

    private function getProdutoAgrupadoRules($rules): array
    {
        $rules['produtos'] = 'required|array|min:2';
        $rules['produtos.*'] = 'required|array';
        $rules['produtos.*.produto_id'] = 'required|integer|unique:App\Models\ProdutoGrupo,produto_id';
        return $rules;
    }

    public function messages(): array
    {
        return [
            'produtos.*.produto_id.unique' => 'O :attribute :input já pertence à outro grupo.',
        ];
    }

    public function attributes(): array
    {
        return [
            'produtos.*.produto_id' => 'produto id'
        ];
    }
}
