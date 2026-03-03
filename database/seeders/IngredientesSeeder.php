<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingrediente; 

class IngredientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   // database/seeders/IngredientesSeeder.php
public function run()
{
    $ingredientes = [
        ['nombre' => 'Tomate', 'calorias' => 18],
        ['nombre' => 'Pollo', 'calorias' => 165],
        ['nombre' => 'Arroz', 'calorias' => 130],
        ['nombre' => 'Cebolla', 'calorias' => 40],
    ];

    foreach ($ingredientes as $data) {
        Ingrediente::create($data);
    }
}

}
