<?php

/** @var Factory $factory */

use App\Domain\Enuns\ProdutoEnum;
use App\Models\Produto;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Produto::class, function (Faker $faker) {
    return [
        'nome' => $faker->words(3, true),
        'descricao' => $faker->sentence,
        'tipo_id' => ProdutoEnum::getRandomValue(),
        'valor' => $faker->randomFloat(2, 1, 9999),
        'visualizado' => $faker->boolean,
    ];
});

$factory->state(Produto::class, 'produto_simples', function (Faker $faker) {
    return [
        'tipo_id' => ProdutoEnum::PRODUTO_SIMPLES,
    ];
});

$factory->state(Produto::class, 'produto_digital', function (Faker $faker) {
    return [
        'tipo_id' => ProdutoEnum::PRODUTO_DIGITAL,
    ];
});

$factory->state(Produto::class, 'produto_configuravel', function (Faker $faker) {
    return [
        'tipo_id' => ProdutoEnum::PRODUTO_CONFIGURAVEL,
    ];
});

$factory->state(Produto::class, 'produto_agrupado', function (Faker $faker) {
    return [
        'tipo_id' => ProdutoEnum::PRODUTO_AGRUPADO,
    ];
});
