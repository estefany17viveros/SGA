<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
public function run()
{
    if (!User::where('email', 'admin@academico.com')->exists()) {

        User::create([
            'name' => 'Administrador',
            'email' => 'admin@academico.com',
            'password' => Hash::make('admin123'), // contraseña temporal
            'role' => 'admin',
        ]);

        echo "Administrador creado.\n";
        echo "Email: admin@academico.com\n";
        echo "Password temporal: admin123\n";
        echo "IMPORTANTE: Cambiar contraseña al iniciar sesión.\n";
    }
}
}
