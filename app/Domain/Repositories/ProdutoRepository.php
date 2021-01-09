<?php

namespace App\Domain\Repositories;

use App\Models\Produto;

class ProdutoRepository extends RepositoryAbstract
{
    public function __construct(Produto $produto)
    {
        $this->model = $produto;
    }
}
