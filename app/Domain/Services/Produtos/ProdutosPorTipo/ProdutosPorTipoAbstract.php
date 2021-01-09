<?php

namespace App\Domain\Services\Produtos\ProdutosPorTipo;

use App\Domain\Repositories\ProdutoRepository;
use App\Models\Produto;

abstract class ProdutosPorTipoAbstract implements ProdutosPorTipoInterface
{
    /** @var ProdutoRepository */
    protected $produtoRepository;

    public function __construct()
    {
        $this->produtoRepository = app(ProdutoRepository::class);
    }

    protected function marcarProdutoVisualizado(Produto $produto): void
    {
        if (!$produto->visualizado) {
            $produto->update(['visualizado' => true]);
        }
    }
}
