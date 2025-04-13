<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['id' => 1, 'name' => 'Central'],
            ['id' => 2, 'name' => 'Concepción'],
            ['id' => 3, 'name' => 'San Pedro'],
            ['id' => 4, 'name' => 'Coordillera'],
            ['id' => 5, 'name' => 'Guairá'],
            ['id' => 6, 'name' => 'Caaguazú'],
            ['id' => 7, 'name' => 'Caazapá'],
            ['id' => 8, 'name' => 'Itapúa'],
            ['id' => 9, 'name' => 'Misiones'],
            ['id' => 10, 'name' => 'Paraguarí'],
            ['id' => 11, 'name' => 'Alto Paraná'],
            ['id' => 12, 'name' => 'Ñeembucú'],
            ['id' => 13, 'name' => 'Amambay'],
            ['id' => 14, 'name' => 'Canindeyú'],
            ['id' => 15, 'name' => 'Presidente Hayes'],
            ['id' => 16, 'name' => 'Boquerón'],
            ['id' => 17, 'name' => 'Alto Paraguay'],
        ];

        foreach ($departments as $data) {
            \App\Models\Department::updateOrCreate(
                ['id' => $data['id']],
                ['name' => $data['name']]
            );
        }
    }
}
