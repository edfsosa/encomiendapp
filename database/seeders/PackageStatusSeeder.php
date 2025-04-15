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
            ['name' => "EN PROCESO"],
            ['name' => "EN RUTA"],
            ['name' => "ENTREGADO"],
            ['name' => "RECHAZADO"],
        ];

        foreach ($states as $data) {
            PackageStatus::updateOrCreate(
                [
                    'name' => $data['name'],
                ]
            );
        }
    }
}
