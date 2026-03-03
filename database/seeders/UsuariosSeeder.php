<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::firstOrCreate(
            ['email' => 'al@culinary.mx'],
            [
                'nombre' => 'Al',
                'password' => bcrypt('password'),
                'personas' => 2
            ]
        );
    }
}

