<?php

namespace Database\Factories;

use App\Models\Licence;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LicenceChoisie>
 */
class LicenceChoisieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_debut' => Carbon::parse('13-04-2024'),
            'date_fin' => Carbon::parse('13-05-2024'),
            'licence_id' => Licence::factory()->create(),
            'user_id' => User::factory()->create(),
        ];
    }
}
