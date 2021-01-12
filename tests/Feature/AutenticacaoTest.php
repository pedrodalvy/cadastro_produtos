<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\LoginTrait;

class AutenticacaoTest extends TestCase
{
    use RefreshDatabase, LoginTrait;

    public function testLoginComDadosCorretos(): void
    {
        $user = factory(User::class)->create();

        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => '123456'
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticated();
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }

    public function testLoginComDadosIncorretos(): void
    {
        $user = factory(User::class)->create();

        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => '1'
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'error' => 'Falha ao autenticar, tente novamente.'
        ]);
    }

    public function testLoginSemInformarDados(): void
    {
        $response = $this->post('/api/auth/login');

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Os dados fornecidos são inválidos.',
            'errors' => [
                'email' => ['O campo email é obrigatório.'],
                'password' => ['O campo senha é obrigatório.'],
            ]
        ]);
    }

    public function testRefreshToken(): void
    {
        $response = $this->post('/api/auth/refresh-token', [], [
            'Authorization' => $this->getBearerToken()
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }

    public function testRefreshTokenSemToken(): void
    {
        $response = $this->post('/api/auth/refresh-token');

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);
    }

    public function testRefreshTokenComTokenIncorreto(): void
    {
        $response = $this->post('/api/auth/refresh-token', [], [
            'Authorization' => 'Bearer '
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);
    }

    public function testLogout(): void
    {
        $response = $this->post('/api/auth/logout', [], [
            'Authorization' => $this->getBearerToken()
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Deslogado com sucesso'
        ]);
    }

    public function testLogoutSemToken(): void
    {
        $response = $this->post('/api/auth/logout');

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);
    }

    public function testLogoutComTokenIncorreto(): void
    {
        $response = $this->post('/api/auth/logout', [], [
            'Authorization' => 'Bearer '
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);
    }
}
