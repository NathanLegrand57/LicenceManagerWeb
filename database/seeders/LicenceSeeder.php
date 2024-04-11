<?php

namespace Database\Seeders;

use App\Models\Licence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LicenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Licence::factory()
            ->count(5)
            ->create();
    }
}
