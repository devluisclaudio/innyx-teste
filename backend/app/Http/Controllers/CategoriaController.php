<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CategoriaRepository;
use Exception;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    protected $repository;

    public function __construct(CategoriaRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(Request $request)
    {
        try {
            $categorias = $this->repository->getItens($request);
            if ($categorias)
                return response()->json($categorias);

            return response()->json([]);
        } catch (Exception $ex) {
            report($ex);
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }
}
