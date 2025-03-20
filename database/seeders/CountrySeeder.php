<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'Sudan', 'code' => 'SD'],
            ['name' => 'United States', 'code' => 'US'],
            ['name' => 'Canada', 'code' => 'CA'],
            ['name' => 'United Kingdom', 'code' => 'UK'],
            ['name' => 'Germany', 'code' => 'DE'],
            ['name' => 'France', 'code' => 'FR'],
            ['name' => 'Italy', 'code' => 'IT'],
            ['name' => 'Spain', 'code' => 'ES'],
            ['name' => 'Brazil', 'code' => 'BR'],
            ['name' => 'Argentina', 'code' => 'AR'],
            ['name' => 'Mexico', 'code' => 'MX'],
            ['name' => 'Chile', 'code' => 'CL'],
            ['name' => 'Saudia Arabia', 'code' => 'KSA'],

        ];


        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
