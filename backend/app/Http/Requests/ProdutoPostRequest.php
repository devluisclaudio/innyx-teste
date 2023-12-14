<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required',
            'descricao' => 'required',
            'preco' => 'required|numeric',
            'data_validade' => 'required',
            'categoria_id' => 'required|numeric',
            'imagem' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'Nome do produto é obrigatório!',
            'descricao.required' => 'Descrição do produto é obrigatório!',
            'preco.required' => 'Preço do produto é obrigatório!',
            'preco.numeric' => 'Preço do produto tem que ser numerico!',
            'data_validade.required' => 'Data de validadde do produto é obrigatório!',
            'categoria_id.required' => 'Categoria do produto é obrigatório!',
            'categoria_id.numeric' => 'Categoria do produto tem que ser numerico!',
            'imagem.required' => 'Imagem do produto é obrigatório!',
            'imagem.unique' => 'Imagem do produto já está em uso!'
        ];
    }
}
