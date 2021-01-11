<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->middleware('api')->group( function () {
    Route::post('login', 'Auth\AuthController@login');
    Route::post('logout', 'Auth\AuthController@logout');
    Route::post('refresh-token', 'Auth\AuthController@refresh');
});

Route::prefix('v1')->namespace('Api\V1')->group( function () {
    Route::prefix('produtos')->group(function () {
        Route::get('', 'ProdutosController@listarTodos');
        Route::post('', 'ProdutosController@cadastrarProduto');
        Route::get('/{produto}', 'ProdutosController@verProduto');
        Route::put('/{produto}', 'ProdutosController@editarProduto');
        Route::post('/{produto}/desconto', 'ProdutosController@criarDesconto');
        Route::delete('/{produto}', 'ProdutosController@removerProduto');
    });
});
