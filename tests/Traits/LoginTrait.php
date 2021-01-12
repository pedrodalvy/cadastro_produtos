<?php

namespace Tests\Traits;

use App\Models\User;

trait LoginTrait
{
    protected function getBearerToken(): string
    {
        $user = factory(User::class)->create();

        $login = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => '123456'
        ]);

        $loginContent = json_decode($login->getContent(), true);
        $token = $loginContent['access_token'];

        return "Bearer $token";
    }
}
