<?php

namespace Database\Seeders;

use App\Models\PackageStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['id' => 1, 'code' => '001', 'name' => "EN ESPERA DE PROCESO"],
            ['id' => 2, 'code' => '002', 'name' => "EN PROCESO"],
            ['id' => 3, 'code' => '003', 'name' => "EN RUTA"],
            ['id' => 4, 'code' => '004', 'name' => "ENTREGADO"],
            ['id' => 5, 'code' => '005', 'name' => "DEVUELTO"],
            ['id' => 6, 'code' => '006', 'name' => "RECHAZADO"],
        ];

        foreach ($states as $data) {
            PackageStatus::updateOrCreate(
                ['name' => $data['name']],
                [
                    'id' => $data['id'],
                    'code' => $data['code']
                ]
            );
        }
    }
}
