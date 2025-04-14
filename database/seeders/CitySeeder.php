<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedCities();
    }
    /**
     * Seed the cities from a JSON file.
     *
     * @return void
     */


    public function seedCities()
    {
        $jsonPath = database_path('data/json/cities.json');

        if (!file_exists($jsonPath)) {
            $this->command->error("El archivo cities.json no existe en: $jsonPath");
            return;
        }

        $json = json_decode(file_get_contents($jsonPath), true);

        if (!is_array($json)) {
            $this->command->error("El contenido del JSON no es válido.");
            return;
        }

        $cities = array_map(function ($city) {
            return [
                'id' => $city['id'],
                'name' => strtoupper($city['name']),
                'department_id' => $city['department_id'],
            ];
        }, $json);

        \App\Models\City::upsert($cities, ['id']);

        $this->command->info("Ciudades insertadas correctamente: " . count($cities));
    }
}
