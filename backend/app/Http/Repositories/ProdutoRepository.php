<?php

namespace App\Http\Repositories;

use App\Http\Requests\ProdutoPostRequest;
use App\Models\Produto;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Integer;

class ProdutoRepository
{
    protected $model;

    public function __construct(Produto $produto)
    {
        $this->model = $produto;
    }

    public function getItens(Request $request)
    {
        try {
            $query = $this->model;
            if (isset($request->search) && !empty($request->search)) {
                $query = $query->where('nome', 'like', '%' . $request->search . '%')->orWhere('descricao', 'like', '%' . $request->search . '%');
            }
            return $query->paginate(10);
        } catch (Exception $ex) {
            report($ex);
            return false;
        }
    }

    public function save(ProdutoPostRequest $request)
    {
        try {
            DB::beginTransaction();
            if (isset($request->id) && !empty($request->id)) {
                $item = $this->model->find($request->id);
                $status = $item->merge($request)->save();
            } else {
                Log::info(json_encode($request->toArray()));
                $status = $this->model->fill($request->toArray())->save();
            }

            DB::commit();
            return $status;
        } catch (Exception $ex) {
            report($ex);
            DB::rollBack();
            return false;
        }
    }

    public function getItem(int $id)
    {
        try {
            $query = $this->model->find($id);
            if (!$query)
                return false;

            return $query;
        } catch (Exception $ex) {
            report($ex);
            return false;
        }
    }
}
