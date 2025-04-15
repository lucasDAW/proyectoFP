<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Autor;
use App\Models\Categoria;
use App\Models\Libro;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Libro>
 */
class LibroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => fake()->sentence(3), // Título del libro (3 palabras)
            'descripcion' => fake()->paragraph(3), // Descripción del libro (3 párrafos)
            'precio' => fake()->randomFloat(2, 5, 50), // Precio del libro (entre 5 y 50)
            'categoria_id' => Categoria::factory(), // Esto creará una nueva Categoria
            'fecha_lanzamiento' => fake()->numberBetween(1, 2025),
            'autor_id' => Autor::factory()
        ];
    }
}
