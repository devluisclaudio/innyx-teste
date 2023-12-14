<?php

namespace Database\Seeders;

use App\Models\Produto;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InsertProdutos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produto::create(
            [
                'nome' => 'Creme dental',
                'descricao' => 'Creme dental da colgate 100g',
                'preco' => 5.60,
                'data_validade' => Carbon::now()->addDay(5),
                'imagem' => 'creme-dental-colgate.jpg',
                'categoria_id' => 1,
            ]
        );
        Produto::create(
            [
                'nome' => 'Coca Cola',
                'descricao' => 'Bebida gasificada coca cola 2L',
                'preco' => 9.60,
                'data_validade' => Carbon::now()->addDay(15),
                'imagem' => 'coca-cola.jpg',
                'categoria_id' => 2,
            ]
        );
        Produto::create(
            [
                'nome' => 'Arroz',
                'descricao' => 'Arroz Branco 1kg',
                'preco' => 3.50,
                'data_validade' => Carbon::now()->addDay(20),
                'imagem' => 'arroz.jpg',
                'categoria_id' => 3,
            ]
        );
    }
}
