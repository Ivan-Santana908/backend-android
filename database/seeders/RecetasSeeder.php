<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Receta;
use App\Models\Ingrediente;
use Illuminate\Support\Facades\DB;


class RecetasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run(): void
{
    // Crea una receta
    $receta = Receta::create([
        'titulo' => 'Arroz con pollo',
        'descripcion' => 'Plato tradicional con arroz, pollo y vegetales.',
        'calorias' => 500,
        'usuario_id' => 1, // ajusta al ID de tu usuario de prueba
    ]);

    // Busca ingredientes existentes
    $pollo = Ingrediente::where('nombre', 'Pollo')->first();
    $arroz = Ingrediente::where('nombre', 'Arroz')->first();
    $tomate = Ingrediente::where('nombre', 'Tomate')->first();

    // Asocia ingredientes con cantidades
    $receta->ingredientes()->attach([
        $pollo->id => ['cantidad' => 200, 'unidad' => 'gr'],
        $arroz->id => ['cantidad' => 100, 'unidad' => 'gr'],
        $tomate->id => ['cantidad' => 1, 'unidad' => 'pieza'],
    ]);
}

}
