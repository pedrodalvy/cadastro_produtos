<?php

namespace App\Domain\Factories;

use App\Domain\Enums\ProdutoEnum;
use App\Domain\Services\Produtos\ProdutosPorTipo\ProdutosAgrupadosService;
use App\Domain\Services\Produtos\ProdutosPorTipo\ProdutosConfiguraveisService;
use App\Domain\Services\Produtos\ProdutosPorTipo\ProdutosDigitaisService;
use App\Domain\Services\Produtos\ProdutosPorTipo\ProdutosPorTipoAbstract;
use App\Domain\Services\Produtos\ProdutosPorTipo\ProdutosSimplesService;

class ProdutosPorTipoFactory
{
    public static function factory(int $tipoProduto): ProdutosPorTipoAbstract
    {
        switch ($tipoProduto) {
            case ProdutoEnum::PRODUTO_SIMPLES:
                return app(ProdutosSimplesService::class);
            case ProdutoEnum::PRODUTO_DIGITAL:
                return app(ProdutosDigitaisService::class);
            case ProdutoEnum::PRODUTO_CONFIGURAVEL:
                return app(ProdutosConfiguraveisService::class);
            case ProdutoEnum::PRODUTO_AGRUPADO:
                return app(ProdutosAgrupadosService::class);
        }
    }
}
