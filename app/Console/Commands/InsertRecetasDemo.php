<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;
use App\Models\Receta;
use App\Models\Ingrediente;

class InsertRecetasDemo extends Command
{
    protected $signature = 'recetas:demo';
    protected $description = 'Inserta usuario, ingredientes y receta de prueba en MongoDB';

    public function handle()
    {
        // 👤 Usuario
        $usuario = new Usuario([
            'nombre' => 'Al Tester',
            'email' => 'al@test.com',
            'password' => bcrypt('secret123'),
        ]);
        $usuario->save();

        // 🧂 Ingredientes
        $pollo = new Ingrediente(['nombre' => 'Pollo']);
        $pollo->save();

        $arroz = new Ingrediente(['nombre' => 'Arroz']);
        $arroz->save();

        // 🍽️ Receta
        $receta = new Receta([
            'titulo' => 'Pollo con arroz',
            'descripcion' => 'Receta simple y rica',
            'calorias' => 500,
            'usuario_id' => $usuario->_id,
        ]);
        $receta->save();

        // 🔗 Asociar ingredientes
        $receta->ingredientes()->attach($pollo->_id, ['cantidad' => 1, 'unidad' => 'pieza']);
        $receta->ingredientes()->attach($arroz->_id, ['cantidad' => 100, 'unidad' => 'gramos']);

        $this->info('✅ Datos insertados correctamente en MongoDB.');
    }
}
