<?php

namespace App\Domain\Services\Produtos\ProdutosPorTipo;

use App\Domain\Repositories\ProdutoRepository;

abstract class ProdutosPorTipoAbstract implements ProdutosPorTipoInterface
{
    /** @var ProdutoRepository */
    protected $produtoRepository;

    public function __construct()
    {
        $this->produtoRepository = app(ProdutoRepository::class);
    }
}
