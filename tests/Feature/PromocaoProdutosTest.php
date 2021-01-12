<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\LoginTrait;
use Tests\Traits\ProdutosTrait;

class PromocaoProdutosTest extends TestCase
{
    use RefreshDatabase, WithFaker, LoginTrait, ProdutosTrait;

    public function testCriarDesconto(): void
    {
        $produto = $this->criarProdutoSimples();
        $dataLimite = $this->faker->dateTimeBetween('now', 'tomorrow');

        $desconto = [
            'valor' => $this->faker->randomNumber(2),
            'data_limite' => $dataLimite->format('Y-m-d H:i:s')
        ];

        $response = $this->post("/api/v1/produtos/{$produto->id}/desconto", $desconto, [
            'Authorization' => $this->getBearerToken()
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Desconto cadastrado com sucesso.'
        ]);
    }

    public function testFalhaCriarDescontoDataLimiteMenorQueAtual(): void
    {
        $produto = $this->criarProdutoSimples();
        $dataLimite = $this->faker->dateTimeBetween('-2 day', 'yesterday');

        $desconto = [
            'valor' => $this->faker->randomNumber(2),
            'data_limite' => $dataLimite->format('Y-m-d H:i:s')
        ];

        $response = $this->post("/api/v1/produtos/{$produto->id}/desconto", $desconto, [
            'Authorization' => $this->getBearerToken()
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Os dados fornecidos são inválidos.',
            'errors' => [
                'data_limite' => ['O campo data limite deve ser posterior a data atual.'],
            ]
        ]);
    }
}
