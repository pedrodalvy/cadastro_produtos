<?php

/** @var Factory $factory */

use App\Models\ProdutoConfiguracao;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ProdutoConfiguracao::class, function (Faker $faker) {
    return [
        'nome' => $faker->word,
        'valor' => random_int(0,1) ? $faker->randomNumber() : $faker->randomLetter
    ];
});
