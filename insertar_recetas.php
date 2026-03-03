<?php

use App\Models\Receta;
use MongoDB\BSON\ObjectId;

// Recetas a insertar
$recetas = [
    [
        '_id' => new ObjectId('689e1b70a96733d4bbaaff67'),
        'titulo' => 'Salmón con costra de hierbas',
        'descripcion' => 'Filete de salmón con costra crujiente de hierbas y limón.',
        'tiempo_preparacion' => 15,
        'tiempo_coccion' => 20,
        'calorias_porcion' => 350,
        'porciones' => 4,
        'dificultad' => 'Media',
        'tipo' => 'Sin gluten',
        'imagen' => '/imagenes/salmon.jpg',
        'ingredientes' => [
            ['nombre' => 'Salmón', 'cantidad' => 600, 'unidad' => 'g'],
            ['nombre' => 'Pan rallado sin gluten', 'cantidad' => 100, 'unidad' => 'g'],
            ['nombre' => 'Perejil fresco', 'cantidad' => 30, 'unidad' => 'g'],
            ['nombre' => 'Ajo', 'cantidad' => 2, 'unidad' => 'dientes'],
            ['nombre' => 'Limón', 'cantidad' => 1, 'unidad' => 'unidad'],
            ['nombre' => 'Aceite de oliva', 'cantidad' => 2, 'unidad' => 'cucharadas']
        ],
        'pasos' => [
            'Precalienta el horno a 200°C. Lava y seca el salmón. Colócalo en una bandeja engrasada con papel pergamino.',
            'En un bowl, mezcla 100g de pan rallado sin gluten, 30g de perejil picado fino, 2 dientes de ajo picados, ralladura de 1 limón, sal y pimienta al gusto.',
            'Presiona suavemente la mezcla sobre la superficie del salmón, cubriendo completamente. Rocía con aceite de oliva.',
            'Hornea durante 15-18 minutos hasta que el salmón esté cocido y la costra dorada. La temperatura interna debe ser 63°C.',
            'Deja reposar 3 minutos. Sirve con rodajas de limón y una ensalada verde.'
        ],
        'autor' => ['nombre' => 'Chef Especial'],
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        '_id' => new ObjectId('689e1b72a96733d4bbaaff6b'),
        'titulo' => 'Curry de lentejas',
        'descripcion' => 'Curry aromático de lentejas rojas con leche de coco.',
        'tiempo_preparacion' => 10,
        'tiempo_coccion' => 25,
        'calorias_porcion' => 310,
        'porciones' => 6,
        'dificultad' => 'Fácil',
        'tipo' => 'Vegana',
        'imagen' => '/imagenes/curry.jpg',
        'ingredientes' => [
            ['nombre' => 'Lentejas rojas', 'cantidad' => 300, 'unidad' => 'g'],
            ['nombre' => 'Leche de coco', 'cantidad' => 400, 'unidad' => 'ml'],
            ['nombre' => 'Espinacas', 'cantidad' => 200, 'unidad' => 'g'],
            ['nombre' => 'Cebolla', 'cantidad' => 1, 'unidad' => 'unidad'],
            ['nombre' => 'Ajo', 'cantidad' => 3, 'unidad' => 'dientes'],
            ['nombre' => 'Curry en polvo', 'cantidad' => 2, 'unidad' => 'cucharadas'],
            ['nombre' => 'Jengibre fresco', 'cantidad' => 1, 'unidad' => 'cucharadita'],
            ['nombre' => 'Caldo de verduras', 'cantidad' => 500, 'unidad' => 'ml']
        ],
        'pasos' => [
            'Enjuaga 300g de lentejas rojas bajo agua fría hasta que salga clara. Escurre bien.',
            'En una olla grande, calienta 2 cucharadas de aceite a fuego medio. Sofríe 1 cebolla picada durante 3 minutos.',
            'Agrega 3 dientes de ajo picados, 1 cucharadita de jengibre rallado y 2 cucharadas de curry en polvo. Cocina 1 minuto removiendo.',
            'Añade las lentejas, 500ml de caldo de verduras y 400ml de leche de coco. Lleva a hervor, luego reduce el fuego.',
            'Cocina a fuego lento durante 20 minutos, removiendo ocasionalmente hasta que las lentejas estén tiernas.',
            'Agrega 200g de espinacas frescas y cocina 2 minutos más hasta que se marchiten. Ajusta sal y pimienta.',
            'Sirve caliente con arroz basmati o pan naan.'
        ],
        'autor' => ['nombre' => 'Chef Verde'],
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        '_id' => new ObjectId('689e1b73a96733d4bbaaff6c'),
        'titulo' => 'Bowl de Buddha vegetariano',
        'descripcion' => 'Bowl nutritivo con garbanzos, verduras asadas y tahini.',
        'tiempo_preparacion' => 20,
        'tiempo_coccion' => 30,
        'calorias_porcion' => 420,
        'porciones' => 4,
        'dificultad' => 'Media',
        'tipo' => 'Vegetariana',
        'imagen' => '/imagenes/buddha-bowl.jpg',
        'ingredientes' => [
            ['nombre' => 'Garbanzos cocidos', 'cantidad' => 400, 'unidad' => 'g'],
            ['nombre' => 'Batata', 'cantidad' => 300, 'unidad' => 'g'],
            ['nombre' => 'Kale', 'cantidad' => 200, 'unidad' => 'g'],
            ['nombre' => 'Quinoa', 'cantidad' => 150, 'unidad' => 'g'],
            ['nombre' => 'Aguacate', 'cantidad' => 1, 'unidad' => 'unidad'],
            ['nombre' => 'Tahini', 'cantidad' => 3, 'unidad' => 'cucharadas'],
            ['nombre' => 'Limón', 'cantidad' => 1, 'unidad' => 'unidad']
        ],
        'pasos' => [
            'Precalienta el horno a 200°C. Pela y corta 300g de batata en cubos de 2cm. Colócalos en una bandeja.',
            'Enjuaga 400g de garbanzos cocidos. Agrégalos a la bandeja. Rocía con aceite de oliva, pimentón, comino, sal y pimienta.',
            'Hornea durante 25-30 minutos hasta que la batata esté tierna y los garbanzos crujientes.',
            'Mientras, cocina 150g de quinoa según instrucciones del paquete. Escurre y reserva.',
            'Prepara la salsa: mezcla 3 cucharadas de tahini, jugo de 1 limón, 1 diente de ajo picado y agua hasta lograr consistencia cremosa.',
            'Masajea 200g de kale con un poco de aceite y sal durante 2 minutos para suavizarla.',
            'Monta los bowls: base de quinoa, kale, batata y garbanzos asados, aguacate en rodajas. Vierte la salsa de tahini por encima.'
        ],
        'autor' => ['nombre' => 'Chef Verde'],
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        '_id' => new ObjectId('689e1b74a96733d4bbaaff6d'),
        'titulo' => 'Ensalada proteica de atún',
        'descripcion' => 'Ensalada completa con atún, huevo y verduras frescas.',
        'tiempo_preparacion' => 15,
        'tiempo_coccion' => 10,
        'calorias_porcion' => 290,
        'porciones' => 4,
        'dificultad' => 'Fácil',
        'tipo' => 'Alta proteína',
        'imagen' => '/imagenes/ensalada-atun.jpg',
        'ingredientes' => [
            ['nombre' => 'Atún en agua', 'cantidad' => 300, 'unidad' => 'g'],
            ['nombre' => 'Huevos', 'cantidad' => 4, 'unidad' => 'unidades'],
            ['nombre' => 'Mix de lechugas', 'cantidad' => 200, 'unidad' => 'g'],
            ['nombre' => 'Tomates cherry', 'cantidad' => 150, 'unidad' => 'g'],
            ['nombre' => 'Pepino', 'cantidad' => 1, 'unidad' => 'unidad'],
            ['nombre' => 'Aceitunas negras', 'cantidad' => 50, 'unidad' => 'g'],
            ['nombre' => 'Aceite de oliva', 'cantidad' => 3, 'unidad' => 'cucharadas'],
            ['nombre' => 'Vinagre balsámico', 'cantidad' => 1, 'unidad' => 'cucharada']
        ],
        'pasos' => [
            'Cocina 4 huevos: colócalos en agua fría, lleva a hervor y cocina 9 minutos. Enfría en agua helada, pela y corta en cuartos.',
            'Lava y escurre bien 200g de mix de lechugas. Colócalas en un bowl grande.',
            'Corta 150g de tomates cherry por la mitad. Corta 1 pepino en rodajas finas. Añade a la ensalada.',
            'Escurre 300g de atún en agua. Desmenuza con un tenedor y añade sobre las lechugas.',
            'Agrega 50g de aceitunas negras y los huevos en cuartos.',
            'Prepara la vinagreta: mezcla 3 cucharadas de aceite de oliva, 1 cucharada de vinagre balsámico, mostaza dijon, sal y pimienta.',
            'Vierte la vinagreta sobre la ensalada justo antes de servir. Mezcla suavemente.'
        ],
        'autor' => ['nombre' => 'Chef Principal'],
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        '_id' => new ObjectId('689e1b75a96733d4bbaaff6e'),
        'titulo' => 'Pizza sin gluten de verduras',
        'descripcion' => 'Pizza casera con masa sin gluten y verduras asadas.',
        'tiempo_preparacion' => 30,
        'tiempo_coccion' => 20,
        'calorias_porcion' => 285,
        'porciones' => 4,
        'dificultad' => 'Media',
        'tipo' => 'Sin gluten',
        'imagen' => '/imagenes/pizza.jpg',
        'ingredientes' => [
            ['nombre' => 'Harina sin gluten', 'cantidad' => 300, 'unidad' => 'g'],
            ['nombre' => 'Levadura seca', 'cantidad' => 7, 'unidad' => 'g'],
            ['nombre' => 'Calabacín', 'cantidad' => 1, 'unidad' => 'unidad'],
            ['nombre' => 'Pimiento rojo', 'cantidad' => 1, 'unidad' => 'unidad'],
            ['nombre' => 'Champiñones', 'cantidad' => 150, 'unidad' => 'g'],
            ['nombre' => 'Mozzarella sin lactosa', 'cantidad' => 200, 'unidad' => 'g'],
            ['nombre' => 'Salsa de tomate', 'cantidad' => 150, 'unidad' => 'g']
        ],
        'pasos' => [
            'En un bowl, mezcla 300g de harina sin gluten con 7g de levadura, 1 cucharadita de sal y 1 cucharadita de azúcar.',
            'Agrega 200ml de agua tibia y 2 cucharadas de aceite. Amasa durante 5 minutos hasta obtener una masa suave. Deja reposar 20 minutos cubierta.',
            'Precalienta el horno a 220°C. Corta 1 calabacín, 1 pimiento rojo y 150g de champiñones en rodajas finas.',
            'Estira la masa en una bandeja con papel pergamino. Forma un círculo de 30cm.',
            'Extiende 150g de salsa de tomate sobre la base. Distribuye las verduras y 200g de mozzarella rallada.',
            'Hornea durante 18-20 minutos hasta que los bordes estén dorados y el queso burbujeante.',
            'Deja reposar 3 minutos, corta en porciones y sirve caliente.'
        ],
        'autor' => ['nombre' => 'Chef Especial'],
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        '_id' => new ObjectId('689e1b76a96733d4bbaaff6f'),
        'titulo' => 'Batido verde proteico',
        'descripcion' => 'Batido nutritivo con espinacas, plátano y proteína vegetal.',
        'tiempo_preparacion' => 5,
        'tiempo_coccion' => 0,
        'calorias_porcion' => 180,
        'porciones' => 2,
        'dificultad' => 'Fácil',
        'tipo' => 'Baja en calorías',
        'imagen' => '/imagenes/batido.jpg',
        'ingredientes' => [
            ['nombre' => 'Espinacas frescas', 'cantidad' => 100, 'unidad' => 'g'],
            ['nombre' => 'Plátano', 'cantidad' => 1, 'unidad' => 'unidad'],
            ['nombre' => 'Proteína vegetal en polvo', 'cantidad' => 30, 'unidad' => 'g'],
            ['nombre' => 'Leche de almendras', 'cantidad' => 300, 'unidad' => 'ml'],
            ['nombre' => 'Mango congelado', 'cantidad' => 100, 'unidad' => 'g'],
            ['nombre' => 'Semillas de chía', 'cantidad' => 1, 'unidad' => 'cucharada']
        ],
        'pasos' => [
            'Lava bien 100g de espinacas frescas bajo agua fría. Escúrrelas completamente.',
            'Pela 1 plátano maduro y córtalo en rodajas.',
            'En una licuadora potente, añade las espinacas, el plátano, 100g de mango congelado, 300ml de leche de almendras.',
            'Agrega 30g de proteína vegetal en polvo y 1 cucharada de semillas de chía.',
            'Licúa a alta velocidad durante 45-60 segundos hasta obtener una mezcla completamente suave.',
            'Si está muy espeso, agrega más leche. Si está muy líquido, añade hielo.',
            'Sirve inmediatamente en vasos altos. Puedes decorar con semillas de chía o coco rallado.'
        ],
        'autor' => ['nombre' => 'Chef Verde'],
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        '_id' => new ObjectId('689e1b77a96733d4bbaaff70'),
        'titulo' => 'Bowl de avena proteica',
        'descripcion' => 'Avena con proteína, frutas y mantequilla de almendras.',
        'tiempo_preparacion' => 5,
        'tiempo_coccion' => 5,
        'calorias_porcion' => 320,
        'porciones' => 1,
        'dificultad' => 'Fácil',
        'tipo' => 'Alta proteína',
        'imagen' => '/imagenes/avena.jpg',
        'ingredientes' => [
            ['nombre' => 'Avena en hojuelas', 'cantidad' => 80, 'unidad' => 'g'],
            ['nombre' => 'Proteína en polvo', 'cantidad' => 30, 'unidad' => 'g'],
            ['nombre' => 'Mantequilla de almendras', 'cantidad' => 20, 'unidad' => 'g'],
            ['nombre' => 'Plátano', 'cantidad' => 1, 'unidad' => 'unidad'],
            ['nombre' => 'Arándanos', 'cantidad' => 50, 'unidad' => 'g'],
            ['nombre' => 'Canela', 'cantidad' => 1, 'unidad' => 'cucharadita'],
            ['nombre' => 'Leche', 'cantidad' => 250, 'unidad' => 'ml']
        ],
        'pasos' => [
            'En una olla pequeña, añade 80g de avena, 250ml de leche (o bebida vegetal) y 1 cucharadita de canela.',
            'Cocina a fuego medio-bajo durante 4-5 minutos, removiendo frecuentemente hasta que espese.',
            'Retira del fuego y deja enfriar 1 minuto. Incorpora 30g de proteína en polvo y mezcla bien hasta integrar.',
            'Transfiere a un bowl. Pela y corta 1 plátano en rodajas.',
            'Decora el bowl con rodajas de plátano, 50g de arándanos frescos.',
            'Agrega 20g de mantequilla de almendras en el centro.',
            'Opcionalmente, espolvorea con semillas de chía, coco rallado o frutos secos. Sirve caliente.'
        ],
        'autor' => ['nombre' => 'Chef Principal'],
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        '_id' => new ObjectId('689e1b78a96733d4bbaaff71'),
        'titulo' => 'Wrap de lechuga con hummus',
        'descripcion' => 'Wrap saludable usando hojas de lechuga con hummus y verduras.',
        'tiempo_preparacion' => 10,
        'tiempo_coccion' => 0,
        'calorias_porcion' => 165,
        'porciones' => 2,
        'dificultad' => 'Fácil',
        'tipo' => 'Baja en calorías',
        'imagen' => '/imagenes/wrap.jpg',
        'ingredientes' => [
            ['nombre' => 'Hojas de lechuga romana', 'cantidad' => 6, 'unidad' => 'unidades'],
            ['nombre' => 'Hummus', 'cantidad' => 150, 'unidad' => 'g'],
            ['nombre' => 'Zanahoria rallada', 'cantidad' => 100, 'unidad' => 'g'],
            ['nombre' => 'Pepino', 'cantidad' => 1, 'unidad' => 'unidad'],
            ['nombre' => 'Tomate', 'cantidad' => 1, 'unidad' => 'unidad'],
            ['nombre' => 'Pimiento rojo', 'cantidad' => 0.5, 'unidad' => 'unidad'],
            ['nombre' => 'Germinados', 'cantidad' => 30, 'unidad' => 'g']
        ],
        'pasos' => [
            'Lava y seca cuidadosamente 6 hojas grandes de lechuga romana. Deben estar crujientes e intactas.',
            'Ralla finamente 100g de zanahoria. Corta 1 pepino y 1 tomate en tiras delgadas. Corta ½ pimiento en juliana.',
            'Prepara las hojas: coloca cada hoja con la parte cóncava hacia arriba sobre una superficie limpia.',
            'Extiende aproximadamente 25g de hummus en el centro de cada hoja, dejando 2cm en los bordes.',
            'Distribuye las verduras sobre el hummus: zanahoria rallada, pepino, tomate, pimiento y germinados.',
            'Enrolla cada wrap: dobla primero los lados hacia el centro, luego enrolla desde abajo firmemente.',
            'Corta cada wrap por la mitad en diagonal. Sirve inmediatamente o envuelve en papel film para llevar.'
        ],
        'autor' => ['nombre' => 'Chef Verde'],
        'created_at' => now(),
        'updated_at' => now()
    ]
];

// Insertar recetas
foreach ($recetas as $recetaData) {
    try {
        $receta = Receta::where('_id', $recetaData['_id'])->first();
        
        if (!$receta) {
            Receta::create($recetaData);
            echo "✓ Insertada: {$recetaData['titulo']}\n";
        } else {
            echo "• Ya existe: {$recetaData['titulo']}\n";
        }
    } catch (Exception $e) {
        echo "✗ Error en {$recetaData['titulo']}: {$e->getMessage()}\n";
    }
}

echo "\n¡Proceso completado!\n";
echo "Total de recetas en BD: " . Receta::count() . "\n";
