<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Libro;

class LibroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        for ($i = 0;$i<5;$i++){
            
//            $libro = new Libro();
//            $libro ->titulo ='TITULO EJEMPLO';
//            $libro ->descripcion ='DESCRIPCION EJEMPLO';
//            $libro ->autor='AUTOR EJEMPLO';
//            $libro ->numero_paginas=99;
//            $libro ->ISBN='ISBN EJEMPLO';
//            $libro ->fecha_lanzamiento='FECHA EJEMPLO';
//            $libro ->precio=99.99;
//            $libro->save();
        }
        
        DB::table('libros')->insert([
            'titulo' => 'titulo ejemplo',
            'descripcion' => 'DESCRIPCION EJEMPLO',
            'autor' => 'AUTOR EJEMPLO',
            'numero_paginas' => 99,
            'ISBN' => 'ISBN EJEMPLO',
            'fecha_lanzamiento' => 'FECHA EJEMPLO',
            'precio' => 99.99,
            
        ]);
        
    }
}
