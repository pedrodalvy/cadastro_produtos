<?php

namespace App\Domain\Repositories;

use App\Models\ProdutoDesconto;

class ProdutoDescontoRepository extends RepositoryAbstract
{
    public function __construct(ProdutoDesconto $produto)
    {
        $this->model = $produto;
    }

    public function criarDesconto(int $produtoId, array $request): bool
    {
        $desconto = $this->findOrCreateOneBy('produto_id', $produtoId);
        $desconto->produto_id = $produtoId;
        $desconto->valor = $request['valor'];
        $desconto->data_limite = $request['data_limite'];

        return $desconto->save();
    }
}
