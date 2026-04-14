<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Administrador Principal',
                'email' => 'admin@academico.com',
            ],
            [
                'name' => 'Administrador Secundario',
                'email' => 'admin2@academico.com',
            ],
        ];

        foreach ($admins as $admin) {

            // Evitar duplicados
            if (!User::where('email', $admin['email'])->exists()) {

                User::create([
                    'name' => $admin['name'],
                    'email' => $admin['email'],
                    'password' => Hash::make('admin123'),
                    'role' => 'admin',
                ]);
            }
        }

        $this->command->info('✅ Administradores creados correctamente');
        $this->command->info('📧 admin@academico.com / admin2@academico.com');
        $this->command->info('🔑 Password: admin123');
        $this->command->warn('⚠️ Recuerda cambiar las contraseñas después del login');
    }
}