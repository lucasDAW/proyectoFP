<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Autor>
 */
class AutorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(),
            'descripcion' => $this->faker->paragraph(), // Descripción aleatoria
            'fecha_nacimiento' => $this->fake()->numberBetween(0, 2025), // Descripción aleatoria
            'referencias' => $this->faker->url(), // Referencia aleatoria
            'foto' => $this->faker->imageUrl(), // URL de foto aleatoria
        ];
    }
}
