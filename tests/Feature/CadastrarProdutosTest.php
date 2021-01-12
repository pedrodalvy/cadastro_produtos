<?php

namespace Tests\Feature;

use App\Domain\Enums\ProdutoEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\LoginTrait;
use Tests\Traits\ProdutosTrait;

class CadastrarProdutosTest extends TestCase
{
    use RefreshDatabase, WithFaker, LoginTrait, ProdutosTrait;

    public function testCadastrarProdutoSimples(): void
    {
        $produto = [
            'nome' => $this->faker->name,
            'descricao' => $this->faker->sentence,
            'valor' => 100.99,
            'tipo_id' => ProdutoEnum::PRODUTO_SIMPLES
        ];

        $response = $this->post('/api/v1/produtos', $produto, [
            'Authorization' => $this->getBearerToken()
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => 1,
            'nome' => $produto['nome'],
            'descricao' => $produto['descricao'],
            'tipo_id' => $produto['tipo_id'],
            'tipo' => ProdutoEnum::getDescription($produto['tipo_id']),
            'valor' => (float)$produto['valor'],
        ]);
    }

    public function testCadastrarProdutoDigital(): void
    {
        $produto = [
            'nome' => $this->faker->name,
            'descricao' => $this->faker->sentence,
            'valor' => 100.99,
            'tipo_id' => ProdutoEnum::PRODUTO_DIGITAL,
            'link' => $this->faker->url
        ];

        $response = $this->post('/api/v1/produtos', $produto, [
            'Authorization' => $this->getBearerToken()
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => 1,
            'nome' => $produto['nome'],
            'descricao' => $produto['descricao'],
            'tipo_id' => $produto['tipo_id'],
            'tipo' => ProdutoEnum::getDescription($produto['tipo_id']),
            'valor' => (float)$produto['valor'],
            'link' => $produto['link']
        ]);
    }

    public function testCadastrarProdutoConfiguravel(): void
    {
        $produto = [
            'nome' => $this->faker->name,
            'descricao' => $this->faker->sentence,
            'valor' => 100.99,
            'tipo_id' => ProdutoEnum::PRODUTO_CONFIGURAVEL,
            'configuracao' => [
                ['nome' => $this->faker->name, 'valor' => $this->faker->randomNumber(1)],
                ['nome' => $this->faker->name, 'valor' => $this->faker->randomLetter]
        ]
        ];
        $configuracoes = $produto['configuracao'];
        ksort($configuracoes);

        $response = $this->post('/api/v1/produtos', $produto, [
            'Authorization' => $this->getBearerToken()
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => 1,
            'nome' => $produto['nome'],
            'descricao' => $produto['descricao'],
            'tipo_id' => $produto['tipo_id'],
            'tipo' => ProdutoEnum::getDescription($produto['tipo_id']),
            'valor' => (float)$produto['valor'],
            'caracteristicas' => [
                [
                    'atributo' => $produto['configuracao'][0]['nome'],
                    'valor' => (string)$produto['configuracao'][0]['valor']
                ],
                [
                    'atributo' => $produto['configuracao'][1]['nome'],
                    'valor' => (string)$produto['configuracao'][1]['valor']
                ]
            ]
        ]);
    }

    public function testCadastrarProdutoAgrupado(): void
    {
        $produtoSimplesA = $this->criarProdutoSimples();
        $produtoSimplesB = $this->criarProdutoSimples();

        $grupo = [
            'nome' => $this->faker->name,
            'descricao' => $this->faker->sentence,
            'valor' => 100.99,
            'tipo_id' => ProdutoEnum::PRODUTO_AGRUPADO,
            'produtos' => [
                ['produto_id' => $produtoSimplesA->id],
                ['produto_id' => $produtoSimplesB->id]
            ]
        ];

        $response = $this->post('/api/v1/produtos', $grupo, [
            'Authorization' => $this->getBearerToken()
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => 3,
            'nome' => $grupo['nome'],
            'descricao' => $grupo['descricao'],
            'tipo_id' => $grupo['tipo_id'],
            'tipo' => ProdutoEnum::getDescription($grupo['tipo_id']),
            'valor' => (float)$grupo['valor'],
            'produtos_agrupados' => [
                [
                    'id' => $produtoSimplesA->id,
                    'nome' => $produtoSimplesA->nome,
                    'descricao' => $produtoSimplesA->descricao,
                    'tipo_id' => $produtoSimplesA->tipo_id,
                    'tipo' => ProdutoEnum::getDescription($produtoSimplesA->tipo_id),
                    'valor' => (float)$produtoSimplesA->valor_atual,
                    'criado_em' => $produtoSimplesA->created_at->format('Y-m-d H:i:s'),
                    'atualizado_em' => $produtoSimplesA->created_at->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => $produtoSimplesB->id,
                    'nome' => $produtoSimplesB->nome,
                    'descricao' => $produtoSimplesB->descricao,
                    'tipo_id' => $produtoSimplesB->tipo_id,
                    'tipo' => ProdutoEnum::getDescription($produtoSimplesB->tipo_id),
                    'valor' => (float)$produtoSimplesB->valor_atual,
                    'criado_em' => $produtoSimplesB->created_at->format('Y-m-d H:i:s'),
                    'atualizado_em' => $produtoSimplesB->created_at->format('Y-m-d H:i:s')
                ],
            ]
        ]);
    }
}
