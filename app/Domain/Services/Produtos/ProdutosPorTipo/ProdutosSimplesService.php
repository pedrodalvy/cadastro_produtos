<?php

namespace App\Domain\Services\Produtos\ProdutosPorTipo;

use App\Http\Resources\ProdutoSimplesResource;
use App\Models\Produto;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdutosSimplesService extends ProdutosPorTipoAbstract
{
    public function exibir(Produto $produto): JsonResource
    {
        $this->marcarProdutoVisualizado($produto);

        return new ProdutoSimplesResource($produto);
    }

    public function editar(Produto $produto, array $request): JsonResource
    {
        if (!$produto->update($request)) {
            throw new \RuntimeException('Não foi possível editar o Produto');
        }

        return new ProdutoSimplesResource($produto);
    }

    public function cadastrar(array $request): JsonResource
    {
        if (!$produto = $this->produtoRepository->create($request)) {
            throw new \RuntimeException('Não foi possível cadastrar o Produto');
        }

        return new ProdutoSimplesResource($produto);
    }
}
