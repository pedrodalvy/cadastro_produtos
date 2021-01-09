<?php

use App\Models\Produto;
use App\Models\ProdutoConfiguracao;
use App\Models\ProdutoGrupo;
use App\Models\ProdutoLink;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        factory(Produto::class, 10)->states('produto_simples')->create();

        factory(Produto::class, 10)
            ->states('produto_digital')
            ->create()
            ->each(function ($produto) {
                $produto->link()->save(factory(ProdutoLink::class)->make());
            });

        factory(Produto::class, 10)
            ->states('produto_configuravel')
            ->create()
            ->each(function ($produto) {
                factory(ProdutoConfiguracao::class, random_int(2, 5))->create([
                    'produto_id' => $produto->id
                ]);
            });

        factory(Produto::class, 10)
            ->states('produto_agrupado')
            ->create()
            ->each(function ($grupo) {
                factory(Produto::class, random_int(2, 5))
                    ->states('produto_simples')
                    ->create()
                    ->each(function ($produto) use ($grupo) {
                        factory(ProdutoGrupo::class, 1)->create([
                            'produto_id' => $produto->id,
                            'grupo_id' => $grupo->id,
                        ]);
                    });
            });
    }
}
