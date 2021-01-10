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

    public function cadastrar(array $request): JsonResource
    {
        if (!$produto = $this->produtoRepository->create($request)) {
            throw new \RuntimeException('Não foi possível cadastrar o Produto.');
        }

        if (!$produto->link()->create($request)) {
            $produto->delete();
            throw new \RuntimeException('Houve um erro ao cadastrar o link do produto.');
        }

        return new ProdutoDigitalResource($produto);
    }
}
