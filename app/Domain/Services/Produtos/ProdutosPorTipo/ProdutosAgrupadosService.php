<?php

namespace App\Domain\Services\Produtos\ProdutosPorTipo;

use App\Http\Resources\ProdutoAgrupadoResource;
use App\Models\Produto;

class ProdutosAgrupadosService extends ProdutosPorTipoAbstract
{
    public function exibir(Produto $produto)
    {
        $this->marcarProdutoVisualizado($produto);

        return new ProdutoAgrupadoResource($produto);
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
