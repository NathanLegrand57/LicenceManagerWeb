<?php

namespace Database\Factories;

use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Licence>
 */
class LicenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'libelle' => $this->faker->name(1),
            'prix' => $this->faker->randomNumber(2),
            'duree' => $this->faker->randomNumber(2),
            'produit_id' => Produit::factory()->create()
        ];
    }
}
