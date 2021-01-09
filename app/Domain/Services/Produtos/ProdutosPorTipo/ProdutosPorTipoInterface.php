<?php

namespace App\Domain\Services\Produtos\ProdutosPorTipo;

use App\Models\Produto;

interface ProdutosPorTipoInterface
{
    public function exibir(Produto $produto);
    public function editar(Produto $produto, array $request);
    public function cadastrar(array $request);
}
