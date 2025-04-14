<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Clientes
            'ver clientes',
            'crear clientes',
            'editar clientes',
            'eliminar clientes',

            // Roles
            'ver roles',
            'crear roles',
            'editar roles',
            'eliminar roles',

            // Envios
            'ver envios',
            'crear envios',
            'editar envios',
            'eliminar envios',

            // Conductores
            'ver conductores',
            'crear conductores',
            'editar conductores',
            'eliminar conductores',

            // Agencias
            'ver agencias',
            'crear agencias',
            'editar agencias',
            'eliminar agencias',

            // Productos
            'ver productos',
            'crear productos',
            'editar productos',
            'eliminar productos',

            // Direcciones
            'ver direcciones',
            'crear direcciones',
            'editar direcciones',
            'eliminar direcciones',

            // Ciudades
            'ver ciudades',
            'crear ciudades',
            'editar ciudades',
            'eliminar ciudades',

            // Departamentos
            'ver departamentos',
            'crear departamentos',
            'editar departamentos',
            'eliminar departamentos',

            // Itinerarios
            'ver itinerarios',
            'crear itinerarios',
            'editar itinerarios',
            'eliminar itinerarios',

            // Estados de envios
            'ver estados',
            'crear estados',
            'editar estados',
            'eliminar estados',

            // Articulos de envios
            'ver articulos',
            'crear articulos',
            'editar articulos',
            'eliminar articulos',

            // Tipos de envios
            'ver tipos',
            'crear tipos',
            'editar tipos',
            'eliminar tipos',

            // Usuarios
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',

            // Reportes
            'view reports',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }
    }
}
