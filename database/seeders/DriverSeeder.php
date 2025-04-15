<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drivers = [
            [
                'ci' => '3636969',
                'name' => 'MARCOS QUINTANA',
                'number_car' => '1',
                'license_plate' => 'KLO898',
                'brand' => 'TOYOTA',
                'model' => 'FUN CARGO',
                'is_active' => true,
            ],
            [
                'ci' => '1234567',
                'name' => 'JUAN GONZALEZ',
                'number_car' => '2',
                'license_plate' => 'ABC123',
                'brand' => 'KIA',
                'model' => 'SPORTAGE',
                'is_active' => true,
            ],
            [
                'ci' => '7654321',
                'name' => 'MARTA FERNANDEZ',
                'number_car' => '3',
                'license_plate' => 'XYZ789',
                'brand' => 'NISSAN',
                'model' => 'FRONTIER',
                'is_active' => true,
            ],
            [
                'ci' => '2223334',
                'name' => 'CARLOS RIQUELME',
                'number_car' => '4',
                'license_plate' => 'QWE456',
                'brand' => 'CHEVROLET',
                'model' => 'S10',
                'is_active' => false,
            ],
        ];

        foreach ($drivers as $driver) {
            Driver::create($driver);
        }
    }
}
