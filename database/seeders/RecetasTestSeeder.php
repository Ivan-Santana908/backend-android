<?php
// database/seeders/RecetasTestSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Receta;
use App\Models\Ingrediente;

class RecetasTestSeeder extends Seeder
{
    public function run()
{
    $usuario = new \App\Models\Usuario([
        'nombre' => 'Al Tester',
        'email' => 'al@test.com',
        'password' => bcrypt('secret123'),
    ]);
    $usuario->save();

    $ingrediente1 = new \App\Models\Ingrediente(['nombre' => 'Pollo']);
    $ingrediente1->save();

    $ingrediente2 = new \App\Models\Ingrediente(['nombre' => 'Arroz']);
    $ingrediente2->save();

    $receta = new \App\Models\Receta([
        'titulo' => 'Pollo con arroz',
        'descripcion' => 'Receta simple y rica',
        'calorias' => 500,
        'usuario_id' => $usuario->_id,
    ]);
    $receta->save();

    $receta->ingredientes()->attach($ingrediente1->_id, ['cantidad' => 1, 'unidad' => 'pieza']);
    $receta->ingredientes()->attach($ingrediente2->_id, ['cantidad' => 100, 'unidad' => 'gramos']);
}

}
