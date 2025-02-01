<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

   
class AutoresSeeder extends Seeder
{
   
    public function run(): void
    {
        
          $autores = [
    [
        "nombre" => "Gabriel García Márquez",
        "biografia" => "Escritor colombiano, autor de 'Cien años de soledad', galardonado con el Premio Nobel de Literatura en 1982.",
        "fecha_nacimiento" => "1927-03-06",
        "referencia" => "https://es.wikipedia.org/wiki/Gabriel_Garc%C3%ADa_M%C3%A1rquez"
    ],
    [
        "nombre" => "Isabel Allende",
        "biografia" => "Escritora chilena reconocida por sus novelas como 'La casa de los espíritus'.",
        "fecha_nacimiento" => "1942-08-02",
        "referencia" => "https://es.wikipedia.org/wiki/Isabel_Allende"
    ],
    [
        "nombre" => "Mario Vargas Llosa",
        "biografia" => "Escritor peruano, autor de 'La ciudad y los perros' y Premio Nobel de Literatura en 2010.",
        "fecha_nacimiento" => "1936-03-28",
        "referencia" => "https://es.wikipedia.org/wiki/Mario_Vargas_Llosa"
    ],
    [
        "nombre" => "Jorge Luis Borges",
        "biografia" => "Escritor argentino conocido por sus cuentos, ensayos y poemas, como los incluidos en 'Ficciones'.",
        "fecha_nacimiento" => "1899-08-24",
        "referencia" => "https://es.wikipedia.org/wiki/Jorge_Luis_Borges"
    ],
    [
        "nombre" => "Laura Esquivel",
        "biografia" => "Escritora mexicana, famosa por su novela 'Como agua para chocolate'.",
        "fecha_nacimiento" => "1950-09-30",
        "referencia" => "https://es.wikipedia.org/wiki/Laura_Esquivel"
    ],
    [
        "nombre" => "Carlos Ruiz Zafón",
        "biografia" => "Escritor español, conocido por su obra 'La sombra del viento'.",
        "fecha_nacimiento" => "1964-09-25",
        "referencia" => "https://es.wikipedia.org/wiki/Carlos_Ruiz_Zaf%C3%B3n"
    ],
    [
        "nombre" => "Pablo Neruda",
        "biografia" => "Poeta chileno, ganador del Premio Nobel de Literatura en 1971, autor de 'Veinte poemas de amor y una canción desesperada'.",
        "fecha_nacimiento" => "1904-07-12",
        "referencia" => "https://es.wikipedia.org/wiki/Pablo_Neruda"
    ],
    [
        "nombre" => "Julio Cortázar",
        "biografia" => "Escritor argentino, destacado por su novela 'Rayuela' y sus cuentos.",
        "fecha_nacimiento" => "1914-08-26",
        "referencia" => "https://es.wikipedia.org/wiki/Julio_Cort%C3%A1zar"
    ],
    [
        "nombre" => "Miguel de Cervantes",
        "biografia" => "Escritor español, autor de 'Don Quijote de la Mancha', considerado una de las mayores obras de la literatura universal.",
        "fecha_nacimiento" => "1547-09-29",
        "referencia" => "https://es.wikipedia.org/wiki/Miguel_de_Cervantes"
    ],
    [
        "nombre" => "Federico García Lorca",
        "biografia" => "Poeta y dramaturgo español, autor de 'Bodas de sangre' y 'La casa de Bernarda Alba'.",
        "fecha_nacimiento" => "1898-06-05",
        "referencia" => "https://es.wikipedia.org/wiki/Federico_Garc%C3%ADa_Lorca"
    ]
];
//          descomentar si queremos iniciar un seeder que suba 10 autores de prueba
//        foreach($autores as $a){        
//            DB::table('autor')->insert([
//                'nombre' => $a['nombre'],
//                'descripcion' => $a['biografia'],
//                'fecha_nacimiento' => $a['fecha_nacimiento'],
//                'referencias' => $a['referencia'],
//            ]);
//        }
    }
}
