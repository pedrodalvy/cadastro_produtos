<?php

namespace Tests\Feature;

use App\Domain\Enums\ProdutoEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\LoginTrait;
use Tests\Traits\ProdutosTrait;

class EditarProdutosTest extends TestCase
{
    use RefreshDatabase, WithFaker, LoginTrait, ProdutosTrait;

    public function testEditarProdutoSimples(): void
    {
        $produto = $this->criarProdutoSimples();

        $produtoAtualizado = [
            'nome' => $this->faker->name,
            'descricao' => $this->faker->sentence,
            'valor' => $this->faker->randomNumber(2),
            'tipo_id' => ProdutoEnum::PRODUTO_SIMPLES
        ];

        $response = $this->put("/api/v1/produtos/{$produto->id}", $produtoAtualizado, [
            'Authorization' => $this->getBearerToken()
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $produto->id,
            'nome' => $produtoAtualizado['nome'],
            'tipo_id' => $produto->tipo_id,
            'tipo' => ProdutoEnum::getDescription($produto->tipo_id),
            'descricao' => $produtoAtualizado['descricao'],
            'valor' => $produtoAtualizado['valor'],
        ]);
    }

    public function testEditarProdutoDigital(): void
    {
        $produto = $this->criarProdutoDigital();

        $produtoAtualizado = [
            'nome' => $this->faker->name,
            'descricao' => $this->faker->sentence,
            'valor' => $this->faker->randomNumber(2),
            'tipo_id' => ProdutoEnum::PRODUTO_DIGITAL,
            'link' => $this->faker->url
        ];

        $response = $this->put("/api/v1/produtos/{$produto->id}", $produtoAtualizado, [
            'Authorization' => $this->getBearerToken()
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $produto->id,
            'nome' => $produtoAtualizado['nome'],
            'descricao' => $produtoAtualizado['descricao'],
            'tipo_id' => $produto->tipo_id,
            'tipo' => ProdutoEnum::getDescription($produto->tipo_id),
            'valor' => $produtoAtualizado['valor'],
            'link' => $produtoAtualizado['link']
        ]);
    }

    public function testEditarProdutoConfiguravel(): void
    {
        $produto = $this->criarProdutoConfiguravel();

        $produtoAtualizado = [
            'nome' => $this->faker->name,
            'descricao' => $this->faker->sentence,
            'valor' => $this->faker->randomNumber(2),
            'tipo_id' => ProdutoEnum::PRODUTO_CONFIGURAVEL,
            'configuracao' => [
                ['nome' => $this->faker->name, 'valor' => $this->faker->randomNumber(1)],
                ['nome' => $this->faker->name, 'valor' => $this->faker->randomLetter]
            ]
        ];
        $configuracoes = $produtoAtualizado['configuracao'];
        ksort($configuracoes);

        $response = $this->put("/api/v1/produtos/{$produto->id}", $produtoAtualizado, [
            'Authorization' => $this->getBearerToken()
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $produto->id,
            'nome' => $produtoAtualizado['nome'],
            'descricao' => $produtoAtualizado['descricao'],
            'tipo_id' => (string)$produto->tipo_id,
            'tipo' => ProdutoEnum::getDescription($produto->tipo_id),
            'valor' => $produtoAtualizado['valor'],
            'caracteristicas' => [
                [
                    'atributo' => $produtoAtualizado['configuracao'][0]['nome'],
                    'valor' => (string)$produtoAtualizado['configuracao'][0]['valor']
                ],
                [
                    'atributo' => $produtoAtualizado['configuracao'][1]['nome'],
                    'valor' => (string)$produtoAtualizado['configuracao'][1]['valor']
                ]
            ]
        ]);
    }

    public function testEditarProdutoAgrupado(): void
    {
        $produto = $this->criarProdutoAgrupado();

        $produtoSimplesA = $this->criarProdutoSimples();
        $produtoSimplesB = $this->criarProdutoSimples();

        $produtoAtualizado = [
            'nome' => $this->faker->name,
            'descricao' => $this->faker->sentence,
            'valor' => $this->faker->randomNumber(2),
            'tipo_id' => ProdutoEnum::PRODUTO_AGRUPADO,
            'produtos' => [
                ['produto_id' => $produtoSimplesA->id],
                ['produto_id' => $produtoSimplesB->id]
            ]
        ];

        $response = $this->put("/api/v1/produtos/{$produto->id}", $produtoAtualizado, [
            'Authorization' => $this->getBearerToken()
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $produto->id,
            'nome' => $produtoAtualizado['nome'],
            'descricao' => $produtoAtualizado['descricao'],
            'tipo_id' => (string)$produto->tipo_id,
            'tipo' => ProdutoEnum::getDescription($produto->tipo_id),
            'valor' => $produtoAtualizado['valor'],
            'produtos_agrupados' => [
                [
                    'id' => $produtoSimplesA->id,
                    'nome' => $produtoSimplesA->nome,
                    'descricao' => $produtoSimplesA->descricao,
                    'tipo_id' => (string)$produtoSimplesA->tipo_id,
                    'tipo' => ProdutoEnum::getDescription($produtoSimplesA->tipo_id),
                    'valor' => (float)$produtoSimplesA->valor_atual,
                    'criado_em' => $produtoSimplesA->created_at->format('Y-m-d H:i:s'),
                    'atualizado_em' => $produtoSimplesA->created_at->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => $produtoSimplesB->id,
                    'nome' => $produtoSimplesB->nome,
                    'descricao' => $produtoSimplesB->descricao,
                    'tipo_id' => (string)$produtoSimplesB->tipo_id,
                    'tipo' => ProdutoEnum::getDescription($produtoSimplesB->tipo_id),
                    'valor' => (float)$produtoSimplesB->valor_atual,
                    'criado_em' => $produtoSimplesB->created_at->format('Y-m-d H:i:s'),
                    'atualizado_em' => $produtoSimplesB->created_at->format('Y-m-d H:i:s')
                ],
            ]
        ]);
    }
}
