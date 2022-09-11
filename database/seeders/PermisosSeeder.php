<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = array(
            'Ver Usuarios',
            'Crear Usuarios',
            'Editar Usuarios',
            'Eliminar Usuarios',

            'Ver Roles y Permisos',
            'Crear Roles',
            'Editar Roles',

            'Ver Tipos Servicios',
            'Crear Tipos Servicios',
            'Editar Tipos Servicios',
            'Eliminar Tipos Servicios',

            'Ver Cuartos',
            'Crear Cuartos',
            'Editar Cuartos',
            'Eliminar Cuartos',

            'Ver Servicios',
            'Crear Servicios',
            'Editar Servicios',
            'Eliminar Servicios',
            'Reportes de Servicios',

            'Ver Facturas',
            'Eliminar Facturas',
            'Descargar Facturas',
            'Reportes de Facturas'
        );

        foreach ($permisos as $key => $value) {
            Permission::create([ 'name' => $value ]);
        }
    }
}
