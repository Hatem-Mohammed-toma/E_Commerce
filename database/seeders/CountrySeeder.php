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
        Country::create([
            'country_name' => 'Egypt',
            'city_name' => 'Cairo',
            'event_name' => 'The Castle Incident by Muhammad Ali',
            'desc_name' => 'A significant historical event where Muhammad Ali Pasha seized power in Egypt and established a dynasty that ruled for over a century.',
            'date' => '1811-03-01',  // The date of the Castle Incident
            'latitude' => 30.0444,
            'longitude' => 31.2357,
        ]);

        Country::create([
            'country_name' => 'Egypt',
            'city_name' => 'Port Said',
            'event_name' => 'The Suez Crisis',
            'desc_name' => 'A diplomatic and military confrontation in 1956 involving Egypt, Israel, the UK, and France, centering around control of the Suez Canal.',
            'date' => '1956-10-29',
            'latitude' => 31.2653,
            'longitude' => 32.3019,
        ]);
    }
}
