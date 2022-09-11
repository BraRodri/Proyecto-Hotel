<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'tipo_documento' => 'Cédula de Ciudadania',
            'numero_documento' => '123456789',
            'nombres' => 'Super Administrador',
            'email' => 'administrador@gmail.com',
            'password' => Hash::make('123456789'),
            'estado' => 1
        ]);

        $user->assignRole('Administrador');
    }
}
