<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_administrador = Role::create(['name' => 'Administrador']);

        $permisos = Permission::all();
        if(count($permisos) > 0){
            foreach ($permisos as $key => $value) {
                $role_administrador->givePermissionTo($value->name);
            }
        }
    }
}
