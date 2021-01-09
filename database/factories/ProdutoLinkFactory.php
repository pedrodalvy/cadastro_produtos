<?php

/** @var Factory $factory */

use App\Models\ProdutoLink;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ProdutoLink::class, function (Faker $faker) {
    return [
        'link' => $faker->url,
    ];
});
