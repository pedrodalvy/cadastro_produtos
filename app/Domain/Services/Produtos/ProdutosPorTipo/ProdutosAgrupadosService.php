<?php

namespace App\Domain\Services\Produtos\ProdutosPorTipo;

use App\Http\Resources\ProdutoAgrupadoResource;
use App\Models\Produto;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdutosAgrupadosService extends ProdutosPorTipoAbstract
{
    public function exibir(Produto $produto): JsonResource
    {
        $this->marcarProdutoVisualizado($produto);

        return new ProdutoAgrupadoResource($produto);
    }

    public function editar(Produto $produto, array $request)
    {
        // TODO: Implement editar() method.
    }

    public function cadastrar(array $request): JsonResource
    {
        $this->validaTipoProdutosSimples($request['produtos']);

        if (!$produto = $this->produtoRepository->create($request)) {
            throw new \RuntimeException('Não foi possível cadastrar o Produto.');
        }

        if (!$produto->agrupar()->createMany($request['produtos'])) {
            $produto->delete();
            throw new \RuntimeException('Houve um erro ao cadastrar as configurações do produto.');
        }

        return new ProdutoAgrupadoResource($produto);
    }

    private function validaTipoProdutosSimples($produtos): void
    {
        $data = $this->produtoRepository->getProdutosNaoAgrupaveis($produtos)
            ->pluck(['id'])
            ->toArray();

        if(count($data)) {
            $message = 'O(s) produto(s) ' . implode(',', $data) . ' não é(são) to tipo simples.';
            throw new \DomainException($message);
        }
    }
}
