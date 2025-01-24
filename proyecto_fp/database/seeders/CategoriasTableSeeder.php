<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generos = [
            'Aventura',
            'Ciencia Ficción',
            'Policiaca',
            'Terror y Misterio',
            'Romantica',
            'Educación',
            'Humor',
            'Historia',
        ];
        
        foreach($generos as $genero){        
            DB::table('categoria')->insert([
                'nombre' => $genero,
            ]);
        }
    }
}
