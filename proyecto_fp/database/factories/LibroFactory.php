<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'categoria_id' => fake()->numberBetween(1, 10), // Categoría aleatoria
            'fecha_lanzamiento' => fake()->numberBetween(1, 2025),
            'autor_id' => fake()->numberBetween(1, 10), // Nombre del autor aleatorio
        ];
    }
}
