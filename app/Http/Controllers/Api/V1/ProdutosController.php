<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Factories\ProdutosPorTipoFactory;
use App\Domain\Services\Produtos\ProdutosService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Produtos\CadastrarProdutoRequest;
use App\Http\Requests\Produtos\EditarProdutoRequest;
use App\Http\Requests\Produtos\ListarProdutosRequest;
use App\Http\Requests\Produtos\ProdutoDescontoRequest;
use App\Models\Produto;
use DomainException;
use Exception;
use Illuminate\Http\JsonResponse;

class ProdutosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => ['listarTodos', 'verProduto']
        ]);
    }

    public function listarTodos(ListarProdutosRequest $request): JsonResponse
    {
        try {
            $service = new ProdutosService();
            $response = $service->listarTodos($request->validated());

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
            $response = $service->cadastrar($request->validated());

        } catch (DomainException $e) {
            $message = $e->getMessage();
            return response()->json(['message' => $message], 400);

        } catch (Exception $exception) {
            $message = 'Ocorreu um erro interno';
            return response()->json(['message' => $message], 500);
        }

        return response()->json($response);
    }

    public function editarProduto(Produto $produto, EditarProdutoRequest $request): JsonResponse
    {
        try {
            $service = ProdutosPorTipoFactory::factory($request->tipo_id);
            $response = $service->editar($produto, $request->validated());

        } catch (DomainException $e) {
            $message = $e->getMessage();
            return response()->json(['message' => $message], 400);

        } catch (Exception $exception) {
            $message = 'Ocorreu um erro interno';
            return response()->json(['message' => $message], 500);
        }

        return response()->json($response);
    }

    public function criarDesconto(Produto $produto, ProdutoDescontoRequest $request): JsonResponse
    {
        try {
            $service = new ProdutosService();
            $response = $service->criarDesconto($produto, $request->validated());

        } catch (DomainException $e) {
            $message = $e->getMessage();
            return response()->json(['message' => $message], 400);

        } catch (Exception $exception) {
            $message = 'Ocorreu um erro interno';
            return response()->json(['message' => $message], 500);
        }

        return response()->json($response);
    }

    public function removerProduto(Produto $produto)
    {
        try {
            $produto->delete();

        } catch (DomainException $e) {
            $message = $e->getMessage();
            return response()->json(['message' => $message], 400);

        } catch (Exception $exception) {
            $message = 'Ocorreu um erro interno';
            return response()->json(['message' => $message], 500);
        }

        return response()->noContent();
    }
}
