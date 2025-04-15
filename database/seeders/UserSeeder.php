<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'Superadministrador',
            ],
            [
                'name' => 'Juan Caceres',
                'email' => 'juan@ruta10.com',
                'password' => Hash::make('password'),
                'ci' => '2345678',
                'phone' => '992300200',
                'position' => 'Agente',
                'area' => 'Comercial',
                'agency_id' => 1,
                'role' => 'Usuario',
            ],
        ];

        foreach ($users as $userData) {
            $role = $userData['role'];
            unset($userData['role']);

            $user = User::create($userData);
            $user->assignRole($role);
        }
    }
}
