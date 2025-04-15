<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Autor;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Autor>
 */
class AutorFactory extends Factory
{
    
        protected $model = Autor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'descripcion' => fake()->paragraph(), // Descripción aleatoria
            'fecha_nacimiento'=> fake()->numberBetween(0, 2025), // Descripción aleatoria
            'referencias' => fake()->url(), // Referencia aleatoria
//            'foto' => fake()->imageUrl(), // URL de foto aleatoria
        ];
    }
}
