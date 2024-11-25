<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mercancia>
 */
class MercanciaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'precio' => fake()->randomNumber(),
            'cantidad' => fake()->randomNumber(),
            'tipo_id'=> \App\Models\Categoria::all()->random()->id,
            'user_id'=> \App\Models\User::all()->random()->id,
    ];
    }
}
