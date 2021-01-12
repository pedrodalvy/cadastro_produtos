<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\LoginTrait;
use Tests\Traits\ProdutosTrait;

class RemoverProdutosTest extends TestCase
{
    use RefreshDatabase, LoginTrait, ProdutosTrait;

    public function testRemoverProdutoSimples(): void
    {
        $produto = $this->criarProdutoSimples();

        $response = $this->delete("/api/v1/produtos/{$produto->id}", [
            'Authorization' => $this->getBearerToken()
        ]);

        $response->assertNoContent();
   }

    public function testRemoverProdutoDigital(): void
    {
        $produto = $this->criarProdutoDigital();

        $response = $this->delete("/api/v1/produtos/{$produto->id}", [
            'Authorization' => $this->getBearerToken()
        ]);

        $response->assertNoContent();
    }

    public function testRemoverProdutoConfiguravel(): void
    {
        $produto = $this->criarProdutoConfiguravel();

        $response = $this->delete("/api/v1/produtos/{$produto->id}", [
            'Authorization' => $this->getBearerToken()
        ]);

        $response->assertNoContent();
    }

    public function testRemoverProdutoAgrupado(): void
    {
        $produto = $this->criarProdutoAgrupado();

        $response = $this->delete("/api/v1/produtos/{$produto->id}", [
            'Authorization' => $this->getBearerToken()
        ]);

        $response->assertNoContent();
    }
}
