<?php

namespace App\Domain\Services\Produtos;

use App\Domain\Repositories\ProdutoDescontoRepository;
use App\Domain\Repositories\ProdutoRepository;
use App\Http\Resources\ProdutoCollection;
use App\Models\Produto;

class ProdutosService
{
    /** @var ProdutoRepository */
    protected $produtoRepository;

    /** @var ProdutoDescontoRepository */
    protected $produtoDesconto;

    public function __construct()
    {
        $this->produtoRepository = app(ProdutoRepository::class);
        $this->produtoDesconto = app(ProdutoDescontoRepository::class);
    }

    public function criarDesconto(Produto $produto, array $request): array
    {
        if (!$this->produtoDesconto->criarDesconto($produto->id, $request)) {
            throw new \RuntimeException('Não foi possível cadastrar o desconto.');
        }

        return ['message' => 'Desconto cadastrado com sucesso.'];
    }

    public function listarTodos(array $filters): ProdutoCollection
    {
        $produtos = $this->produtoRepository->all($filters)->paginate();
        return new ProdutoCollection($produtos);
    }
}
