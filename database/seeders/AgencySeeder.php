<?php

namespace Database\Seeders;

use App\Models\Agency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agencies = [
            ['name' => 'CARAPEGUA', 'city' => 'CARAPEGUA', 'address' => 'Calle 1', 'phone' => '972153857'],
            ['name' => 'SAN IGNACIO MISIONES', 'city' => 'SAN IGNACIO MISIONES', 'address' => 'Calle 1', 'phone' => '971172460'],
            ['name' => 'CORONEL BOGADO', 'city' => 'CORONEL BOGADO', 'address' => 'Calle 1', 'phone' => '985769658'],
            ['name' => 'ENCARNACIÓN', 'city' => 'ENCARNACIÓN', 'address' => 'Calle 1', 'phone' => '985731829'],
            ['name' => 'CORONEL OVIEDO', 'city' => 'CORONEL OVIEDO', 'address' => 'Calle 1', 'phone' => '981318717'],
            ['name' => 'CAAGUAZÚ', 'city' => 'CAAGUAZÚ', 'address' => 'Calle 1', 'phone' => '984425495'],
            ['name' => 'VILLARRICA', 'city' => 'VILLARRICA', 'address' => 'Calle 1', 'phone' => '981108966'],
            ['name' => 'SAN JUAN NEPOMUCENO', 'city' => 'SAN JUAN NEPOMUCENO', 'address' => 'Calle 1', 'phone' => '994161472'],
            ['name' => 'CAMPO 9', 'city' => 'CAMPO 9', 'address' => 'Calle 1', 'phone' => '981318756'],
            ['name' => 'CIUDAD DEL ESTE', 'city' => 'CIUDAD DEL ESTE', 'address' => 'Calle 1', 'phone' => '992713157'],
            ['name' => 'SANTA RITA', 'city' => 'SANTA RITA', 'address' => 'Calle 1', 'phone' => '981969475'],
            ['name' => 'SANTANÍ', 'city' => 'SANTANÍ', 'address' => 'Calle 1', 'phone' => '982693837'],
            ['name' => 'CAPIIBARY', 'city' => 'CAPIIBARY', 'address' => 'Calle 1', 'phone' => '983992855'],
            ['name' => 'CURUGUATY', 'city' => 'CURUGUATY', 'address' => 'Calle 1', 'phone' => '983564495'],
            ['name' => 'KATUETÉ', 'city' => 'KATUETÉ', 'address' => 'Calle 1', 'phone' => '982854988'],
            ['name' => 'ASUNCIÓN', 'city' => 'ASUNCIÓN', 'address' => 'Calle 1', 'phone' => '994440139'],
        ];

        foreach ($agencies as $data) {
            Agency::firstOrCreate(
                ['name' => $data['name']],
                [
                    'city' => $data['city'],
                    'address' => $data['address'],
                    'phone' => $data['phone']
                ]
            );
        }
    }
}
