<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    protected $signature = 'user:create-test';
    protected $description = 'Crear usuario de prueba (test@test.com / 123456)';

    public function handle()
    {
        try {
            // Verificar si ya existe
            $existing = Usuario::where('email', 'test@test.com')->first();
            
            if ($existing) {
                $this->info('✓ Usuario de prueba ya existe');
                $this->info('Email: test@test.com');
                $this->info('Password: 123456');
                return 0;
            }

            // Crear usuario
            $usuario = Usuario::create([
                'nombre' => 'Usuario de Prueba',
                'email' => 'test@test.com',
                'password' => Hash::make('123456'),
                'personas' => 1,
                'rol' => 'user',
                'perfilCompleto' => false,
                'recetas_guardadas' => [],
                'alergias' => [],
                'preferencias' => ['Vegetariana', 'Sin gluten'],
                'metaCalorias' => 14000,
                'planes_semanales' => [],
                'listas_de_compra' => []
            ]);

            $this->info('✅ Usuario de prueba creado exitosamente');
            $this->info('Email: test@test.com');
            $this->info('Password: 123456');
            $this->info('ID: ' . $usuario->_id);

            // Contar usuarios
            $count = Usuario::count();
            $this->info("Total usuarios en BD: $count");

            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }
    }
}
