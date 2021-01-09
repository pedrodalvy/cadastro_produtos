<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Repositories\ProdutoRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\ListarProdutosRequest;
use App\Http\Resources\ProdutoCollection;
use Exception;
use Illuminate\Http\JsonResponse;

class ProdutosController extends Controller
{
    public function listarTodos(ListarProdutosRequest $request, ProdutoRepository $produtoRepository): JsonResponse
    {
        try {
            $filters = $request->validated();
            $produtos = $produtoRepository->all($filters)->paginate();
            $response = response()->json(new ProdutoCollection($produtos));

        } catch (Exception $exception) {
            $response = response()->json([
                'message' => 'Ocorreu um erro interno'
            ], 500);
        }

        return $response;
    }
}
