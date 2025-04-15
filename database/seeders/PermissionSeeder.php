<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permisos por entidad
        $entities = [
            'shipment',
            'customer',
            'product',
            'driver',
            'user',
            'agency',
            'city',
            'department',
            'itinerary',
            'packageStatus',
            'permission',
            'role',
            'report',
        ];

        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($entities as $entity) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "$action $entity"]);
            }
        }

        // Roles
        $Superadministrador = Role::firstOrCreate(['name' => 'Superadministrador']);
        $Administrador = Role::firstOrCreate(['name' => 'Administrador']);
        $Usuario = Role::firstOrCreate(['name' => 'Usuario']);

        // Superadministrador tiene todo
        $Superadministrador->syncPermissions(Permission::all());

        // Administrador tiene todo menos gestión de usuarios
        $Administrador->syncPermissions(Permission::whereNotIn('name', ['view user', 'create user', 'edit user', 'delete user'])->get());

        // Usuario solo puede ver y crear envíos y clientes
        $Usuario->syncPermissions([
            'view shipment',
            'create shipment',
            'view customer',
            'create customer',
        ]);
    }
}
