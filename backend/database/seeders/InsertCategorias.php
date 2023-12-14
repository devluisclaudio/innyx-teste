<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class InsertCategorias extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create(['nome' => 'Higiene Pessoal']);
        Categoria::create(['nome' => 'Bebidas']);
        Categoria::create(['nome' => 'Cesta Básica']);
    }
}
