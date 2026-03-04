<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Receta;
use App\Models\Usuario;

class SeedRecetas extends Command
{
    protected $signature = 'recetas:seed';
    protected $description = 'Poblar base de datos con recetas de ejemplo';

    public function handle()
    {
        try {
            // Verificar si hay usuarios
            $usuario = Usuario::first();
            
            if (!$usuario) {
                $this->error('❌ No hay usuarios en la base de datos');
                $this->info('Ejecuta: php artisan user:create-test');
                return 1;
            }

            // Verificar cuántas recetas hay
            $existentes = Receta::count();
            $this->info("📊 Recetas actuales: $existentes");

            $recetas = [
                [
                    'titulo' => 'Pasta Carbonara Auténtica',
                    'descripcion' => 'La receta original italiana con guanciale, huevo y pecorino. Cremosa sin usar crema.',
                    'calorias_porcion' => 520,
                    'imagen' => '/imagenes/carbonara.jpg',
                    'tiempo_preparacion' => 15,
                    'tiempo_coccion' => 12,
                    'porciones' => 4,
                    'dificultad' => 'Intermedio',
                    'tipo' => 'Italiana',
                    'ingredientes' => [
                        ['nombre' => 'Spaghetti', 'cantidad' => 320, 'unidad' => 'g'],
                        ['nombre' => 'Huevos', 'cantidad' => 3, 'unidad' => 'unidades'],
                        ['nombre' => 'Queso pecorino', 'cantidad' => 80, 'unidad' => 'g'],
                        ['nombre' => 'Guanciale', 'cantidad' => 100, 'unidad' => 'g']
                    ],
                    'pasos' => [
                        'Cocinar la pasta al dente',
                        'Freír el guanciale hasta que esté crujiente',
                        'Mezclar huevos con pecorino',
                        'Combinar todo fuera del fuego'
                    ]
                ],
                [
                    'titulo' => 'Tacos de Pollo al Pastor',
                    'descripcion' => 'Tacos mexicanos con pollo marinado, tortillas recién calentadas y vegetales frescos.',
                    'calorias_porcion' => 380,
                    'imagen' => '/imagenes/tacos.jpg',
                    'tiempo_preparacion' => 20,
                    'tiempo_coccion' => 10,
                    'porciones' => 4,
                    'dificultad' => 'Fácil',
                    'tipo' => 'Mexicana',
                    'ingredientes' => [
                        ['nombre' => 'Pechuga de pollo', 'cantidad' => 500, 'unidad' => 'g'],
                        ['nombre' => 'Tortillas de maíz', 'cantidad' => 12, 'unidad' => 'unidades'],
                        ['nombre' => 'Lechuga', 'cantidad' => 1, 'unidad' => 'taza'],
                        ['nombre' => 'Tomates', 'cantidad' => 2, 'unidad' => 'unidades']
                    ],
                    'pasos' => [
                        'Marinar el pollo con especias',
                        'Asar el pollo hasta dorar',
                        'Calentar las tortillas',
                        'Servir con vegetales frescos'
                    ]
                ],
                [
                    'titulo' => 'Ensalada César Clásica',
                    'descripcion' => 'Ensalada fresca con lechuga romana, crutones crujientes y aderezo césar casero.',
                    'calorias_porcion' => 290,
                    'imagen' => '/imagenes/cesar.jpg',
                    'tiempo_preparacion' => 15,
                    'tiempo_coccion' => 0,
                    'porciones' => 2,
                    'dificultad' => 'Fácil',
                    'tipo' => 'Ensaladas',
                    'ingredientes' => [
                        ['nombre' => 'Lechuga romana', 'cantidad' => 2, 'unidad' => 'tazas'],
                        ['nombre' => 'Pechuga de pollo', 'cantidad' => 200, 'unidad' => 'g'],
                        ['nombre' => 'Crutones', 'cantidad' => 50, 'unidad' => 'g'],
                        ['nombre' => 'Queso parmesano', 'cantidad' => 30, 'unidad' => 'g']
                    ],
                    'pasos' => [
                        'Lavar y cortar la lechuga',
                        'Asar el pollo y cortarlo',
                        'Preparar aderezo césar',
                        'Mezclar todo y servir'
                    ]
                ],
                [
                    'titulo' => 'Sushi Roll California',
                    'descripcion' => 'Roll de sushi con surimi, aguacate y pepino, cubierto con sésamo.',
                    'calorias_porcion' => 320,
                    'imagen' => '/imagenes/sushi.jpg',
                    'tiempo_preparacion' => 30,
                    'tiempo_coccion' => 20,
                    'porciones' => 3,
                    'dificultad' => 'Intermedio',
                    'tipo' => 'Japonesa',
                    'ingredientes' => [
                        ['nombre' => 'Arroz para sushi', 'cantidad' => 200, 'unidad' => 'g'],
                        ['nombre' => 'Surimi', 'cantidad' => 150, 'unidad' => 'g'],
                        ['nombre' => 'Aguacate', 'cantidad' => 1, 'unidad' => 'unidad'],
                        ['nombre' => 'Pepino', 'cantidad' => 1, 'unidad' => 'unidad']
                    ],
                    'pasos' => [
                        'Cocinar el arroz con vinagre',
                        'Extender alga nori',
                        'Agregar ingredientes y enrollar',
                        'Cortar en piezas'
                    ]
                ],
                [
                    'titulo' => 'Hamburguesa Gourmet',
                    'descripcion' => 'Hamburguesa de carne premium con queso cheddar, tomate y cebolla caramelizada.',
                    'calorias_porcion' => 650,
                    'imagen' => '/imagenes/burger.jpg',
                    'tiempo_preparacion' => 15,
                    'tiempo_coccion' => 12,
                    'porciones' => 2,
                    'dificultad' => 'Fácil',
                    'tipo' => 'Americana',
                    'ingredientes' => [
                        ['nombre' => 'Carne molida', 'cantidad' => 400, 'unidad' => 'g'],
                        ['nombre' => 'Queso cheddar', 'cantidad' => 100, 'unidad' => 'g'],
                        ['nombre' => 'Pan para hamburguesa', 'cantidad' => 2, 'unidad' => 'unidades'],
                        ['nombre' => 'Tomate', 'cantidad' => 1, 'unidad' => 'unidad']
                    ],
                    'pasos' => [
                        'Formar las hamburguesas',
                        'Cocinar a la parrilla',
                        'Caramelizar cebolla',
                        'Armar con todos los ingredientes'
                    ]
                ]
            ];

            $creadas = 0;
            foreach ($recetas as $recetaData) {
                // Verificar si ya existe por título
                $existe = Receta::where('titulo', $recetaData['titulo'])->first();
                
                if ($existe) {
                    $this->info("⏭️  Ya existe: {$recetaData['titulo']}");
                    continue;
                }

                // Preparar ingredientes
                $ingredientes = [];
                foreach ($recetaData['ingredientes'] as $ing) {
                    $ingredientes[] = [
                        'ingrediente' => [
                            'id' => rand(1, 1000),
                            'nombre' => $ing['nombre'],
                            'unidad' => $ing['unidad']
                        ],
                        'cantidad' => $ing['cantidad']
                    ];
                }

                // Crear receta
                $receta = Receta::create([
                    'titulo' => $recetaData['titulo'],
                    'descripcion' => $recetaData['descripcion'],
                    'calorias_porcion' => $recetaData['calorias_porcion'],
                    'imagen' => $recetaData['imagen'],
                    'tiempo_preparacion' => $recetaData['tiempo_preparacion'],
                    'tiempo_coccion' => $recetaData['tiempo_coccion'],
                    'porciones' => $recetaData['porciones'],
                    'dificultad' => $recetaData['dificultad'],
                    'tipo' => $recetaData['tipo'],
                    'ingredientes' => $ingredientes,
                    'pasos' => $recetaData['pasos'],
                    'autor' => [
                        'id' => $usuario->_id,
                        'nombre' => $usuario->nombre
                    ],
                    'usuario_id' => (string) $usuario->_id
                ]);

                $this->info("✅ Creada: {$receta->titulo}");
                $creadas++;
            }

            $total = Receta::count();
            $this->info("\n🎉 Proceso completado:");
            $this->info("   📊 Recetas creadas: $creadas");
            $this->info("   📚 Total en BD: $total");

            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }
    }
}
