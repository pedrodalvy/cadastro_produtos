<?php

namespace App\Domain\Services\Produtos\ProdutosPorTipo;

use App\Http\Resources\ProdutoDigitalResource;
use App\Models\Produto;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdutosDigitaisService extends ProdutosPorTipoAbstract
{
    public function exibir(Produto $produto): JsonResource
    {
        $this->marcarProdutoVisualizado($produto);

        return new ProdutoDigitalResource($produto);
    }

    public function editar(Produto $produto, array $request)
    {
        // TODO: Implement editar() method.
    }

    public function cadastrar(array $request)
    {
        // TODO: Implement cadastrar() method.
    }
}
