<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Comentario_PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "fecha"=>"2023-06-01",
            "comentario_id"=>fake()->numberBetween(1,6),
            "participante_id"=>fake()->numberBetween(1,607),
            "post_id"=>fake()->numberBetween(1,30)
        ];
    }
}
