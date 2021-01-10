<?php

namespace App\Domain\Repositories;

use App\Domain\Enums\ProdutoEnum;
use App\Models\Produto;

class ProdutoRepository extends RepositoryAbstract
{
    public function __construct(Produto $produto)
    {
        $this->model = $produto;
    }

    public function getProdutosNaoAgrupaveis($produtos)
    {
        return $this->model->whereIn('id', array_values($produtos))
            ->where('tipo_id', '!=', ProdutoEnum::PRODUTO_SIMPLES)->get();
    }
}
