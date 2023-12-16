<?php

namespace App\Http\Repositories;

use App\Models\Categoria;
use Exception;
use Illuminate\Http\Request;

class CategoriaRepository
{
    protected $model;

    public function __construct(Categoria $categoria)
    {
        $this->model = $categoria;
    }

    public function getItens(Request $request)
    {
        try {
            $query = $this->model;
            if (isset($request->page) && !empty($request->page) && $request->page === 'true')
                return $query = $query->paginate(10);
            return $query->get();
        } catch (Exception $ex) {
            report($ex);
            return false;
        }
    }
}
