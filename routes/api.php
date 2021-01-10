<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->middleware('api')->group( function () {
    Route::post('login', 'Auth\AuthController@login');
    Route::post('logout', 'Auth\AuthController@logout');
    Route::post('refresh-token', 'Auth\AuthController@refresh');
});

Route::prefix('v1')->middleware(['auth:api'])->group( function () {
    Route::prefix('produtos')->group(function () {
        Route::get('', 'Api\V1\ProdutosController@listarTodos');
        Route::get('/{produto}', 'Api\V1\ProdutosController@verProduto');
        Route::post('', 'Api\V1\ProdutosController@cadastrarProduto');
        Route::put('/{produto}', 'Api\V1\ProdutosController@editarProduto');
        Route::post('/{produto}/desconto', 'Api\V1\ProdutosController@criarDesconto');
    });
});
