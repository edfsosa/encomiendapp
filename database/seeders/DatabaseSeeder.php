<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /* User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // password
        ]); */

        $this->call([
            AgencySeeder::class,
            DepartmentSeeder::class,
            CitySeeder::class,
            PackageStatusSeeder::class,
            ItinerarySeeder::class,
            DriverSeeder::class,
            CustomerSeeder::class,
            PermissionSeeder::class,
            ProductSeeder::class,
            // RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
