<?php

namespace App\Domain\Services\Produtos\ProdutosPorTipo;

interface ProdutosPorTipoInterface
{
    public function exibir(array $request);
    public function editar(array $request);
    public function remover(array $request);
}
