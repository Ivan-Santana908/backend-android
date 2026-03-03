<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Receta;
use App\Models\Ingrediente;

class RecetasCompletasSeeder extends Seeder
{
    public function run()
    {
        // Limpiar colecciones
        Receta::truncate();
        Ingrediente::truncate();

        $this->command->info('🗑️  Colecciones limpiadas');

        // Crear ingredientes base
        $ingredientes = [
            ['nombre' => 'Spaghetti', 'unidad' => 'g'],
            ['nombre' => 'Huevos', 'unidad' => 'unidades'],
            ['nombre' => 'Queso pecorino', 'unidad' => 'g'],
            ['nombre' => 'Guanciale', 'unidad' => 'g'],
            ['nombre' => 'Pimienta negra', 'unidad' => 'cucharadita'],
            ['nombre' => 'Sal', 'unidad' => 'cucharadita'],
            ['nombre' => 'Pollo', 'unidad' => 'g'],
            ['nombre' => 'Tortillas', 'unidad' => 'unidades'],
            ['nombre' => 'Lechuga', 'unidad' => 'taza'],
            ['nombre' => 'Tomate', 'unidad' => 'unidades'],
            ['nombre' => 'Cebolla', 'unidad' => 'unidades'],
            ['nombre' => 'Aceite vegetal', 'unidad' => 'cucharadas'],
            ['nombre' => 'Comino', 'unidad' => 'cucharadita'],
            ['nombre' => 'Pimentón', 'unidad' => 'cucharadita'],
            ['nombre' => 'Limón', 'unidad' => 'unidades'],
            ['nombre' => 'Cilantro', 'unidad' => 'taza'],
            ['nombre' => 'Salsa', 'unidad' => 'cucharadas'],
            ['nombre' => 'Arroz', 'unidad' => 'tazas'],
            ['nombre' => 'Caldo de pollo', 'unidad' => 'ml'],
            ['nombre' => 'Ajo', 'unidad' => 'dientes'],
            ['nombre' => 'Zanahoria', 'unidad' => 'unidades'],
            ['nombre' => 'Calabacín', 'unidad' => 'unidades'],
        ];

        foreach ($ingredientes as $ing) {
            Ingrediente::create($ing);
        }

        $this->command->info('✅ ' . count($ingredientes) . ' ingredientes creados');

        // Crear recetas completas con ingredientes embebidos
        $recetas = [
            [
                'titulo' => 'Pasta Carbonara Auténtica',
                'descripcion' => 'La receta original italiana con guanciale, huevo y pecorino. Cremosa sin usar crema.',
                'tiempo_preparacion' => 15,
                'tiempo_coccion' => 12,
                'calorias_porcion' => 520,
                'porciones' => 4,
                'dificultad' => 'Media',
                'tipo' => 'Italiana',
                'imagen' => '/imagenes/carbonara.jpg',
                'ingredientes' => [
                    ['nombre' => 'Spaghetti', 'cantidad' => 320, 'unidad' => 'g'],
                    ['nombre' => 'Huevos', 'cantidad' => 3, 'unidad' => 'unidades'],
                    ['nombre' => 'Yemas de huevo', 'cantidad' => 1, 'unidad' => 'unidad'],
                    ['nombre' => 'Queso pecorino rallado', 'cantidad' => 80, 'unidad' => 'g'],
                    ['nombre' => 'Guanciale o panceta', 'cantidad' => 100, 'unidad' => 'g'],
                    ['nombre' => 'Pimienta negra recién molida', 'cantidad' => 1, 'unidad' => 'cucharadita'],
                    ['nombre' => 'Sal gruesa', 'cantidad' => 2, 'unidad' => 'cucharadas'],
                ],
                'pasos' => [
                    'Corta 100g de guanciale (o panceta) en cubos de 1cm. Si usas tocino, córtalo en tiras de 0.5cm. Separa en un plato.',
                    'Pon una olla grande con 3-4 litros de agua y 2 cucharadas de sal. Lleva a hervor fuerte (toma 8-10 minutos). Cuando hierva, agrega 320g de spaghetti. Remueve bien y cocina 8-10 minutos hasta al dente.',
                    'En un bowl grande, bate 3 huevos enteros + 1 yema hasta que estén espumosos (30 segundos). Agrega 80g de queso pecorino rallado fino y pimienta negra recién molida (1 cucharadita). Mezcla bien hasta formar una crema espesa.',
                    'En un sartén grande frío, coloca el guanciale. Enciende a fuego medio-bajo. Cocina durante 6-8 minutos sin tocar hasta que suelte su grasa y quede crujiente y dorado. Retira el sartén del fuego.',
                    'Cuando la pasta esté lista, reserva 1 taza del agua de cocción. Escurre la pasta rápidamente (no la enjuagues). Inmediatamente agrégala al sartén con el guanciale. Mezcla 30 segundos.',
                    'Con el sartén fuera del fuego, agrega la mezcla de huevo y queso. Mezcla rápido con movimientos circulares durante 1 minuto. Agrega agua de cocción (2-3 cucharadas) si está muy espesa. El calor de la pasta cocinará el huevo.',
                    'Sirve inmediatamente en platos calientes. Agrega más pecorino rallado y pimienta negra al gusto. NO dejes reposar, la carbonara debe comerse al instante.'
                ],
                'autor' => ['nombre' => 'Chef Antonio']
            ],
            [
                'titulo' => 'Tacos de Pollo al Pastor',
                'descripcion' => 'Tacos mexicanos con pollo marinado, tortillas recién calentadas y vegetales frescos.',
                'tiempo_preparacion' => 20,
                'tiempo_coccion' => 10,
                'calorias_porcion' => 380,
                'porciones' => 4,
                'dificultad' => 'Fácil',
                'tipo' => 'Mexicana',
                'imagen' => '/imagenes/tacos.jpg',
                'ingredientes' => [
                    ['nombre' => 'Pechuga de pollo', 'cantidad' => 500, 'unidad' => 'g'],
                    ['nombre' => 'Tortillas de maíz', 'cantidad' => 12, 'unidad' => 'unidades'],
                    ['nombre' => 'Lechuga romana', 'cantidad' => 1, 'unidad' => 'taza'],
                    ['nombre' => 'Tomates', 'cantidad' => 2, 'unidad' => 'unidades'],
                    ['nombre' => 'Cebolla blanca', 'cantidad' => 1, 'unidad' => 'unidad'],
                    ['nombre' => 'Aceite vegetal', 'cantidad' => 3, 'unidad' => 'cucharadas'],
                    ['nombre' => 'Comino molido', 'cantidad' => 1, 'unidad' => 'cucharadita'],
                    ['nombre' => 'Pimentón', 'cantidad' => 0.5, 'unidad' => 'cucharadita'],
                    ['nombre' => 'Sal', 'cantidad' => 1, 'unidad' => 'cucharadita'],
                    ['nombre' => 'Pimienta', 'cantidad' => 0.5, 'unidad' => 'cucharadita'],
                    ['nombre' => 'Limones', 'cantidad' => 2, 'unidad' => 'unidades'],
                    ['nombre' => 'Cilantro fresco', 'cantidad' => 0.5, 'unidad' => 'taza'],
                ],
                'pasos' => [
                    'Corta 500g de pollo en cubos de 2cm. Colócalos en un bowl. Añade 1 cucharadita de sal, ½ cucharadita de pimienta, 1 cucharadita de comino y ½ cucharadita de pimentón. Mezcla bien con las manos durante 30 segundos.',
                    'Calienta un sartén grande con 3 cucharadas de aceite vegetal a fuego medio-alto durante 2 minutos. El aceite debe estar brillante pero sin humear.',
                    'Agrega el pollo al sartén en una sola capa (no amontones). Cocina sin mover durante 4 minutos hasta que se dore. Voltea cada pieza y cocina 4-5 minutos más. El pollo debe estar dorado y con temperatura interna de 75°C.',
                    'Mientras el pollo cocina, calienta 8-10 tortillas: colócalas directamente sobre la llama del fogón (o en un comal seco) durante 15-20 segundos por lado. Guárdalas en un trapo limpio para mantenerlas calientes.',
                    'Lava y seca las verduras. Corta 1 taza de lechuga en tiras finas. Pica 2 tomates en cubos pequeños de 0.5cm. Corta 1 cebolla en cubitos muy finos. Separa cada ingrediente en bowls pequeños.',
                    'Toma una tortilla caliente, coloca 3-4 piezas de pollo en el centro. No sobrecargues o se romperá la tortilla.',
                    'Agrega al gusto: lechuga, tomate, cebolla. Añade 1 cucharada de salsa, unas gotas de limón y cilantro fresco. Dobla y come inmediatamente mientras está caliente.'
                ],
                'autor' => ['nombre' => 'Chef María']
            ],
            [
                'titulo' => 'Arroz con Pollo Tradicional',
                'descripcion' => 'Arroz amarillo con pollo jugoso y vegetales. Perfecto para toda la familia.',
                'tiempo_preparacion' => 15,
                'tiempo_coccion' => 30,
                'calorias_porcion' => 420,
                'porciones' => 6,
                'dificultad' => 'Fácil',
                'tipo' => 'Latinoamericana',
                'imagen' => '/imagenes/arroz-pollo.jpg',
                'ingredientes' => [
                    ['nombre' => 'Arroz blanco', 'cantidad' => 2, 'unidad' => 'tazas'],
                    ['nombre' => 'Muslos de pollo', 'cantidad' => 6, 'unidad' => 'piezas'],
                    ['nombre' => 'Caldo de pollo', 'cantidad' => 4, 'unidad' => 'tazas'],
                    ['nombre' => 'Cebolla', 'cantidad' => 1, 'unidad' => 'unidad'],
                    ['nombre' => 'Ajo', 'cantidad' => 4, 'unidad' => 'dientes'],
                    ['nombre' => 'Zanahoria', 'cantidad' => 2, 'unidad' => 'unidades'],
                    ['nombre' => 'Pimientos rojos', 'cantidad' => 1, 'unidad' => 'unidad'],
                    ['nombre' => 'Aceite de oliva', 'cantidad' => 3, 'unidad' => 'cucharadas'],
                    ['nombre' => 'Azafrán o colorante', 'cantidad' => 1, 'unidad' => 'cucharadita'],
                    ['nombre' => 'Sal', 'cantidad' => 2, 'unidad' => 'cucharaditas'],
                    ['nombre' => 'Comino', 'cantidad' => 1, 'unidad' => 'cucharadita'],
                ],
                'pasos' => [
                    'Lava 2 tazas de arroz bajo agua fría en un colador hasta que el agua salga clara (3-4 enjuagues). Deja escurrir. Pica 1 cebolla, 4 dientes de ajo, 2 zanahorias en cubos y 1 pimiento rojo en tiras.',
                    'Sazona 6 muslos de pollo con sal (1 cucharadita), pimienta (½ cucharadita) y comino (½ cucharadita). Calienta 3 cucharadas de aceite en una olla grande a fuego medio-alto durante 2 minutos.',
                    'Dora el pollo en la olla por ambos lados durante 5 minutos por lado hasta que esté dorado. No necesita estar cocido completamente. Retira el pollo y reserva en un plato.',
                    'En la misma olla (sin limpiar), agrega la cebolla y ajo picados. Sofríe durante 2 minutos hasta que estén transparentes. Agrega las zanahorias y pimientos. Cocina 3 minutos más removiendo.',
                    'Añade el arroz escurrido a la olla. Mezcla con las verduras durante 2 minutos para que se impregne de los sabores. Agrega el azafrán o colorante (1 cucharadita) y mezcla bien.',
                    'Vierte 4 tazas de caldo de pollo caliente. Agrega sal (1 cucharadita restante) y mezcla. Coloca los muslos de pollo encima del arroz. Lleva a hervor fuerte.',
                    'Cuando hierva, reduce el fuego a bajo. Tapa la olla y cocina sin destapar durante 20-25 minutos. El arroz debe absorber todo el líquido y el pollo estar bien cocido. Apaga, deja reposar tapado 5 minutos y sirve.'
                ],
                'autor' => ['nombre' => 'Chef Carmen']
            ]
        ];

        foreach ($recetas as $recetaData) {
            $receta = new Receta();
            $receta->titulo = $recetaData['titulo'];
            $receta->descripcion = $recetaData['descripcion'];
            $receta->tiempo_preparacion = $recetaData['tiempo_preparacion'];
            $receta->tiempo_coccion = $recetaData['tiempo_coccion'];
            $receta->calorias_porcion = $recetaData['calorias_porcion'];
            $receta->porciones = $recetaData['porciones'];
            $receta->dificultad = $recetaData['dificultad'];
            $receta->tipo = $recetaData['tipo'];
            $receta->imagen = $recetaData['imagen'];
            $receta->ingredientes = $recetaData['ingredientes'];
            $receta->pasos = $recetaData['pasos'];
            $receta->autor = $recetaData['autor'];
            $receta->save();
            
            $this->command->info("✅ Receta creada: {$recetaData['titulo']}");
            $this->command->info("   → Ingredientes: " . count($recetaData['ingredientes']));
        }

        $this->command->info("\n🎉 Base de datos poblada exitosamente!");
        $this->command->info("📊 Total: " . count($recetas) . " recetas con ingredientes embebidos");
    }
}
