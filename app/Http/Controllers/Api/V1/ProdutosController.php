<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Factories\ProdutosPorTipoFactory;
use App\Domain\Repositories\ProdutoRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Produtos\CadastrarProdutoRequest;
use App\Http\Requests\Produtos\ListarProdutosRequest;
use App\Http\Resources\ProdutoCollection;
use App\Models\Produto;
use DomainException;
use Exception;
use Illuminate\Http\JsonResponse;

class ProdutosController extends Controller
{
    public function listarTodos(ListarProdutosRequest $request, ProdutoRepository $produtoRepository): JsonResponse
    {
        try {
            $filters = $request->validated();
            $produtos = $produtoRepository->all($filters)->paginate();
            $response = new ProdutoCollection($produtos);

        } catch (DomainException $e) {
            $message = $e->getMessage();
            return response()->json(['message' => $message], 400);

        } catch (Exception $exception) {
            $message = 'Ocorreu um erro interno';
            return response()->json(['message' => $message], 500);
        }

        return response()->json($response);
    }

    public function verProduto(Produto $produto): JsonResponse
    {
        try {
            $service = ProdutosPorTipoFactory::factory($produto->tipo_id);
            $response = $service->exibir($produto);

        } catch (DomainException $e) {
            $message = $e->getMessage();
            return response()->json(['message' => $message], 400);

        } catch (Exception $exception) {
            $message = 'Ocorreu um erro interno';
            return response()->json(['message' => $message], 500);
        }

        return response()->json($response);
    }

    public function cadastrarProduto(CadastrarProdutoRequest $request): JsonResponse
    {
        try {
            $service = ProdutosPorTipoFactory::factory($request->tipo_id);
            $response = $service->cadastrar($request->all());

        } catch (DomainException $e) {
            $message = $e->getMessage();
            return response()->json(['message' => $message], 400);

        } catch (Exception $exception) {
            $message = 'Ocorreu um erro interno';
            return response()->json(['message' => $message], 500);
        }

        return response()->json($response);
    }
}
