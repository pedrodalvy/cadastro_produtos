<?php

namespace Tests\Feature;

use App\Domain\Enums\ProdutoEnum;
use App\Models\Produto;
use App\Models\ProdutoConfiguracao;
use App\Models\ProdutoGrupo;
use App\Models\ProdutoLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\LoginTrait;

class VisualizarProdutosTest extends TestCase
{
    use RefreshDatabase, LoginTrait;

    public function testListarProdutos(): void
    {
        factory(Produto::class)->create();

        $response = $this->get('/api/v1/produtos');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [['id', 'nome', 'descricao', 'valor', 'tipo', 'visualizado']],
            'links' => ['total', 'count', 'per_page', 'current_page', 'total_pages']
        ]);
    }

    public function testListarProdutosSemDados(): void
    {
        $response = $this->get('/api/v1/produtos');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [],
            'links' => ['total', 'count', 'per_page', 'current_page', 'total_pages']
        ]);
    }

    public function testListarProdutosPorTipo(): void
    {
        factory(Produto::class, 1)
            ->states('produto_configuravel')
            ->create()
            ->each(function ($produto) {
                factory(ProdutoConfiguracao::class, 3)->create(['produto_id' => $produto->id]);
            });

        $response = $this->get('/api/v1/produtos', [
            'tipo_id' => [ProdutoEnum::PRODUTO_CONFIGURAVEL]
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [['id', 'nome', 'descricao', 'valor', 'tipo', 'visualizado']],
            'links' => ['total', 'count', 'per_page', 'current_page', 'total_pages']
        ]);
    }

    public function testVisualizarProdutoSimples(): void
    {
        $produto = factory(Produto::class)->states('produto_simples')->create();

        $response = $this->get("/api/v1/produtos/{$produto->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $produto->id,
            'nome' => $produto->nome,
            'descricao' => $produto->descricao,
            'tipo_id' => $produto->tipo_id,
            'tipo' => ProdutoEnum::getDescription($produto->tipo_id),
            'valor' => $produto->valor_atual,
            'criado_em' => $produto->created_at->format('Y-m-d H:i:s'),
            'atualizado_em' => $produto->updated_at->format('Y-m-d H:i:s')
        ]);
    }

    public function testVisualizarProdutoDigital(): void
    {
        $produto = factory(Produto::class)->states('produto_digital')->create();
        $produto->each(function ($produto) {
            $produto->link()->save(factory(ProdutoLink::class)->make());
        });

        $response = $this->get("/api/v1/produtos/{$produto->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $produto->id,
            'nome' => $produto->nome,
            'descricao' => $produto->descricao,
            'tipo_id' => $produto->tipo_id,
            'tipo' => ProdutoEnum::getDescription($produto->tipo_id),
            'valor' => $produto->valor_atual,
            'link' => $produto->link->link,
            'criado_em' => $produto->created_at->format('Y-m-d H:i:s'),
            'atualizado_em' => $produto->updated_at->format('Y-m-d H:i:s')
        ]);
    }

    public function testVisualizarProdutoConfiguravel(): void
    {
        $produto = factory(Produto::class)->states('produto_configuravel')->create();
        $produto->each(function ($produto) {
            factory(ProdutoConfiguracao::class, 2)->create([
                'produto_id' => $produto->id
            ]);
        });

        $response = $this->get("/api/v1/produtos/{$produto->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $produto->id,
            'nome' => $produto->nome,
            'descricao' => $produto->descricao,
            'tipo_id' => $produto->tipo_id,
            'tipo' => ProdutoEnum::getDescription($produto->tipo_id),
            'valor' => $produto->valor_atual,
            'criado_em' => $produto->created_at->format('Y-m-d H:i:s'),
            'atualizado_em' => $produto->updated_at->format('Y-m-d H:i:s'),
            'caracteristicas' => [
                ['atributo' => $produto->configuracoes[0]->nome, 'valor' => $produto->configuracoes[0]->valor],
                ['atributo' => $produto->configuracoes[1]->nome, 'valor' => $produto->configuracoes[1]->valor]
            ]
        ]);
    }

    public function testVisualizarProdutoAgrupavel(): void
    {
        $grupo = factory(Produto::class)->states('produto_agrupado')->create();
        $grupo->each(function ($grupo) {
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
        $produtos = $grupo->produtosAgrupados;

        $response = $this->get("/api/v1/produtos/{$grupo->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $grupo->id,
            'nome' => $grupo->nome,
            'descricao' => $grupo->descricao,
            'tipo_id' => $grupo->tipo_id,
            'tipo' => ProdutoEnum::getDescription($grupo->tipo_id),
            'valor' => $grupo->valor_atual,
            'criado_em' => $grupo->created_at->format('Y-m-d H:i:s'),
            'atualizado_em' => $grupo->updated_at->format('Y-m-d H:i:s'),
            'produtos_agrupados' => [
                [
                    'id' => $produtos[0]->id,
                    'nome' => $produtos[0]->nome,
                    'descricao' => $produtos[0]->descricao,
                    'tipo_id' => $produtos[0]->tipo_id,
                    'tipo' => ProdutoEnum::getDescription($produtos[0]->tipo_id),
                    'valor' => $produtos[0]->valor_atual,
                    'criado_em' => $produtos[0]->created_at->format('Y-m-d H:i:s'),
                    'atualizado_em' => $produtos[0]->updated_at->format('Y-m-d H:i:s')
                ],
                [
                    'id' => $produtos[1]->id,
                    'nome' => $produtos[1]->nome,
                    'descricao' => $produtos[1]->descricao,
                    'tipo_id' => $produtos[1]->tipo_id,
                    'tipo' => ProdutoEnum::getDescription($produtos[1]->tipo_id),
                    'valor' => $produtos[1]->valor_atual,
                    'criado_em' => $produtos[1]->created_at->format('Y-m-d H:i:s'),
                    'atualizado_em' => $produtos[1]->updated_at->format('Y-m-d H:i:s')
                ]
            ]
        ]);
    }
}
