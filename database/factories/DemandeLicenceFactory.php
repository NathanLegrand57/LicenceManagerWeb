<?php

namespace Database\Factories;

use App\Models\Licence;
use App\Models\LicenceChoisie;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DemandeLicence>
 */
class DemandeLicenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'a_renouveler' => $this->faker->boolean(),
            'date_debut_licence' => Carbon::parse('14-05-2024'),
            'date_fin_licence' => Carbon::parse('14-06-2024'),
            'licencechoisie_id' => LicenceChoisie::factory()->create(),
            'licence_id' => Licence::factory()->create(),
            'user_id' => User::factory()->create(),
        ];
    }
}
