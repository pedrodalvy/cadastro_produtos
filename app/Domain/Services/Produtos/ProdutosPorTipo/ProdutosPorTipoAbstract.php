<?php

namespace App\Domain\Services\Produtos\ProdutosPorTipo;

use App\Domain\Services\Produtos\ProdutosService;
use App\Models\LogProduto;
use App\Models\Produto;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

abstract class ProdutosPorTipoAbstract extends ProdutosService implements ProdutosPorTipoInterface
{
    protected function marcarProdutoVisualizado(Produto $produto): void
    {
        if (!$produto->visualizado) {
            $produto->update(['visualizado' => true]);
        }
    }

    protected function createLog(array $produto, array $request): void
    {
        $valoresNovos = array_diff_assoc($request, $produto);
        $atributosAlterados = array_keys($valoresNovos);
        $valoresAntigos = Arr::only($produto, $atributosAlterados);

        LogProduto::create([
            'valores_antigos' => json_encode($valoresAntigos),
            'valores_novos' => json_encode($valoresNovos),
            'produto_id' => $produto['id'],
            'usuario_id' => Auth::id(),
        ]);
    }
}
