<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['id' => 1, 'department_id' => 1, 'name' => 'ASUNCION'],
        ];

        foreach ($cities as $data) {
            \App\Models\City::updateOrCreate(
                ['id' => $data['id']],
                ['name' => $data['name']]
            );
        }
    }
}
