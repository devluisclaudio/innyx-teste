<?php

namespace App\Http\Repositories;

use App\Http\Requests\ProdutoPostRequest;
use App\Models\Produto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
            if (isset($request->page) && !empty($request->page) && $request->page === 'true')
                return $query = $query->paginate(10);
            return ["data" => $query->get()];
        } catch (Exception $ex) {
            report($ex);
            return false;
        }
    }

    public function save(ProdutoPostRequest $request, int $id = null)
    {
        try {
            DB::beginTransaction();
            $data = $request->toArray();
            if (!empty($id)) {
                $item = $this->model->find($id);
                $data['imagem'] = $this->salvarDoc($data['imagem']);
                $status = $item->update($data);
            } else {
                $data['imagem'] = $this->salvarDoc($data['imagem']);
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

            return ["data" => $query];
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

    public function salvarDoc($arquivo)
    {
        try {

            if (isset($arquivo)) {

                $diretorioPai = 'produtos';

                if (strpos($arquivo, 'application')) {
                    $ext = substr($arquivo, 17, strpos($arquivo, ';') - 17);
                } else {
                    $ext = substr($arquivo, 11, strpos($arquivo, ';') - 11);
                }

                $urlFile = $diretorioPai . DIRECTORY_SEPARATOR . time() . rand(0, 10) . '.' . $ext;

                $file = str_replace(['data:image/' . $ext . ';base64,', 'data:application/' . $ext . ';base64,'], '', $arquivo);
                $file = base64_decode($file);


                Storage::disk('public')->put($urlFile, $file, 'public');
                return asset('storage/' . $urlFile);
            }
        } catch (Exception $ex) {
            report($ex);
            return false;
        }
    }
}
