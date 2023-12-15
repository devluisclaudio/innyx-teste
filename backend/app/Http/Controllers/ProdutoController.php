<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ProdutoRepository;
use App\Http\Requests\ProdutoPostRequest;
use Exception;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

class ProdutoController extends Controller
{
    protected $repository;

    public function __construct(ProdutoRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(Request $request)
    {
        try {
            $produtos = $this->repository->getItens($request);
            if ($produtos)
                return response()->json($produtos);

            return response()->json([]);
        } catch (Exception $ex) {
            report($ex);
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function store(ProdutoPostRequest $request)
    {
        try {
            $result = $this->repository->save($request);
            if ($result)
                return response()->json(['message' => 'Produto cadatrado!'], 201);

            return response()->json(['message' => 'Produto não cadastrado!'], 400);
        } catch (Exception $ex) {
            report($ex);
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $result = $this->repository->getItem($id);
            if ($result)
                return response()->json($result, 200);

            return response()->json(['message' => 'Nenhum item encontrado!'], 400);
        } catch (Exception $ex) {
            report($ex);
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }
}
