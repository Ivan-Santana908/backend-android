<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Models\Usuario;
use App\Models\Receta;
use App\Models\Ingrediente;

class RecetasTestSeeder extends Seeder
{
    public function run()
    {
        // 🔧 Forzar conexión MongoDB
        config(['database.default' => 'mongodb']);
        Eloquent::setConnectionResolver(app('db'));

        // 👤 Crear usuario
        $usuario = new Usuario([
            'nombre' => 'Al Tester',
            'email' => 'al@test.com',
            'password' => bcrypt('secret123'),
        ]);
        $usuario->save();

        // 🧂 Crear ingredientes
        $ingrediente1 = new Ingrediente(['nombre' => 'Pollo']);
        $ingrediente1->save();

        $ingrediente2 = new Ingrediente(['nombre' => 'Arroz']);
        $ingrediente2->save();

        // 🍽️ Crear receta
        $receta = new Receta([
            'titulo' => 'Pollo con arroz',
            'descripcion' => 'Receta simple y rica',
            'calorias' => 500,
            'usuario_id' => $usuario->_id,
        ]);
        $receta->save();

        // 🔗 Asociar ingredientes
        $receta->ingredientes()->attach($ingrediente1->_id, [
            'cantidad' => 1,
            'unidad' => 'pieza',
        ]);

        $receta->ingredientes()->attach($ingrediente2->_id, [
            'cantidad' => 100,
            'unidad' => 'gramos',
        ]);

        echo "✅ Seeder ejecutado correctamente.\n";
    }
}
