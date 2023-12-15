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
            $query = $this->model->with('categoria');
            if (isset($request->search) && !empty($request->search)) {
                $query = $query->where('nome', 'like', '%' . $request->search . '%')->orWhere('descricao', 'like', '%' . $request->search . '%');
            }
            return $query->paginate(10);
        } catch (Exception $ex) {
            report($ex);
            return false;
        }
    }

    public function save(ProdutoPostRequest $request, int $id = null)
    {
        try {
            DB::beginTransaction();
            if (!empty($id)) {
                $item = $this->model->find($id);
                $status = $item->update($request->toArray());
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
            $query = $this->model->with('categoria')->find($id);
            if (!$query)
                return false;

            return $query;
        } catch (Exception $ex) {
            report($ex);
            return false;
        }
    }

    public function delete(int $id)
    {
        try {
            DB::beginTransaction();
            $query = $this->model->find($id);
            if (!$query)
                return false;
            
            $result = $query->delete();
            DB::commit();
            return $result;
        } catch (Exception $ex) {
            report($ex);
            DB::rollBack();
            return false;
        }
    }
}
