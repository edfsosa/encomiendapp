<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Itinerary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItinerarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'agency_id' => 1,
                'origin_city_id' => 1,  // Asunción
                'destination_city_id' => 2, // Bahía Negra
            ],
            [
                'agency_id' => 2,
                'origin_city_id' => 3,  // Carmelo Peralta
                'destination_city_id' => 1, // Asunción
            ],
            [
                'agency_id' => 3,
                'origin_city_id' => 4,
                'destination_city_id' => 5,
            ],
        ];

        foreach ($data as $item) {
            $origin = City::find($item['origin_city_id']);
            $destination = City::find($item['destination_city_id']);

            if (!$origin || !$destination) {
                continue; // evita errores si faltan ciudades
            }

            $name = $origin->name . ' - ' . $destination->name;

            Itinerary::updateOrCreate([
                'agency_id' => $item['agency_id'],
                'origin_city_id' => $item['origin_city_id'],
                'destination_city_id' => $item['destination_city_id'],
            ], [
                'name' => $name,
            ]);
        }
    }
}
