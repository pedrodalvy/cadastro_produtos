<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        factory(\App\Models\User::class)->create([
            'email' => 'user@example.com',
        ]);
    }
}
