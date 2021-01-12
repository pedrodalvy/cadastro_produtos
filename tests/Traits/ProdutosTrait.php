<?php

namespace Tests\Traits;

use App\Models\Produto;
use App\Models\ProdutoConfiguracao;
use App\Models\ProdutoGrupo;
use App\Models\ProdutoLink;

trait ProdutosTrait
{
    protected function criarProdutoSimples()
    {
        return factory(Produto::class)->states('produto_simples')->create();
    }

    protected function criarProdutoDigital()
    {
        $produto = factory(Produto::class)->states('produto_digital')->create();
        $produto->each(function ($produto) {
            $produto->link()->save(factory(ProdutoLink::class)->make());
        });

        return $produto;
    }

    protected function criarProdutoConfiguravel()
    {
        $produto = factory(Produto::class)->states('produto_configuravel')->create();
        $produto->each(function ($produto) {
            factory(ProdutoConfiguracao::class, 2)->create([
                'produto_id' => $produto->id
            ]);
        });

        return $produto;
    }

    protected function criarProdutoAgrupado()
    {
        $produto = factory(Produto::class)->states('produto_agrupado')->create();
        $produto->each(function ($grupo) {
            factory(Produto::class, 2)
                ->states('produto_simples')
                ->create()
                ->each(function ($produto) use ($grupo) {
                    factory(ProdutoGrupo::class, 1)->create([
                        'produto_id' => $produto->id,
                        'grupo_id' => $grupo->id,
                    ]);
                });
        });

        return $produto;
    }
}
