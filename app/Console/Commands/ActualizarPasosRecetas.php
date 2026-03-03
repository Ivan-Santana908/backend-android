<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Receta;

class ActualizarPasosRecetas extends Command
{
    protected $signature = 'recetas:actualizar-pasos {--force : Forzar actualización de recetas que ya tienen pasos}';
    protected $description = 'Actualiza los pasos de todas las recetas con instrucciones más detalladas';

    public function handle()
    {
        $pasosTemplates = [
            'default' => [
                'Lava todos los ingredientes frescos bajo agua fría. Seca con papel absorbente. Coloca todos los ingredientes organizados en tu mesa de trabajo.',
                'Corta cada ingrediente con un cuchillo afilado: verduras en cubos de 2cm, proteínas en trozos uniformes de 3cm. Separa en bowls diferentes.',
                'Precalienta un sartén grande a fuego medio durante 2 minutos. Agrega 2 cucharadas de aceite y espera a que brille.',
                'Cocina los ingredientes principales sin mover durante 3-4 minutos. Voltea y cocina 3-4 minutos más hasta dorar. Temperatura interna: 75°C.',
                'Reduce el fuego a bajo. Agrega sal (1 cucharadita), pimienta (½ cucharadita) y tus especias favoritas. Mezcla con cuchara de madera.',
                'Con movimientos envolventes, mezcla de abajo hacia arriba durante 1 minuto hasta integrar todos los sabores.',
                'Apaga el fuego. Sirve en platos calientes. Decora con hierbas frescas picadas. Sirve inmediatamente mientras está caliente.'
            ],
            'tacos' => [
                'Corta 500g de pollo en cubos de 2cm. Colócalos en un bowl. Añade 1 cucharadita de sal, ½ cucharadita de pimienta, 1 cucharadita de comino y ½ cucharadita de pimentón. Mezcla bien con las manos durante 30 segundos.',
                'Calienta un sartén grande con 3 cucharadas de aceite vegetal a fuego medio-alto durante 2 minutos. El aceite debe estar brillante pero sin humear.',
                'Agrega el pollo al sartén en una sola capa (no amontones). Cocina sin mover durante 4 minutos hasta que se dore. Voltea cada pieza y cocina 4-5 minutos más. El pollo debe estar dorado y con temperatura interna de 75°C.',
                'Mientras el pollo cocina, calienta 8-10 tortillas: colócalas directamente sobre la llama del fogón (o en un comal seco) durante 15-20 segundos por lado. Guárdalas en un trapo limpio para mantenerlas calientes.',
                'Lava y seca las verduras. Corta 1 taza de lechuga en tiras finas. Pica 2 tomates en cubos pequeños de 0.5cm. Corta 1 cebolla en cubitos muy finos. Separa cada ingrediente en bowls pequeños.',
                'Toma una tortilla caliente, coloca 3-4 piezas de pollo en el centro. No sobrecargues o se romperá la tortilla.',
                'Agrega al gusto: lechuga, tomate, cebolla. Añade 1 cucharada de salsa, unas gotas de limón y cilantro fresco. Dobla y come inmediatamente mientras está caliente.'
            ],
            'pasta' => [
                'Llena una olla grande (4-5 litros) con agua hasta ¾ de su capacidad. Agrega 2 cucharadas de sal gruesa. Enciende el fuego alto. Pon la tapa para que hierva más rápido (tomará 8-10 minutos).',
                'Cuando el agua hierva a borbotones, retira la tapa. Agrega 400g de pasta. Revuelve inmediatamente con cuchara de madera para evitar que se pegue. Cocina según el tiempo del paquete (generalmente 8-12 minutos). Revuelve cada 2-3 minutos. Prueba 1 minuto antes del tiempo indicado.',
                'Mientras la pasta cocina, calienta un sartén grande a fuego medio. Agrega 3 cucharadas de aceite de oliva o 30g de mantequilla. Espera 30 segundos a que se caliente.',
                'En el sartén caliente, añade ajo picado (3 dientes) y sofríe durante 30 segundos hasta que huela bien (cuidado, no debe quemarse). Agrega tu salsa o ingredientes principales. Cocina removiendo constantemente durante 4-5 minutos a fuego medio.',
                'Cuando la pasta esté al dente (firme al morderla, no dura), reserva 1 taza del agua de cocción en un vaso. Escurre la pasta en un colador. NO LA ENJUAGUES. Sacude el colador para eliminar el exceso de agua.',
                'Agrega inmediatamente la pasta escurrida al sartén con la salsa. Mezcla con pinzas o dos cucharas durante 1-2 minutos a fuego medio. Si se ve seca, agrega el agua de cocción reservada poco a poco (2-3 cucharadas).',
                'Apaga el fuego. Sirve en platos calientes. Espolvorea 2 cucharadas de queso parmesano rallado sobre cada plato. Decora con albahaca fresca o perejil picado. Come inmediatamente.'
            ],
            'carbonara' => [
                'Corta 100g de guanciale (o panceta) en cubos de 1cm. Si usas tocino, córtalo en tiras de 0.5cm. Separa en un plato.',
                'Pon una olla grande con 3-4 litros de agua y 2 cucharadas de sal. Lleva a hervor fuerte (toma 8-10 minutos). Cuando hierva, agrega 320g de spaghetti. Remueve bien y cocina 8-10 minutos hasta al dente.',
                'En un bowl grande, bate 3 huevos enteros + 1 yema hasta que estén espumosos (30 segundos). Agrega 80g de queso pecorino rallado fino y pimienta negra recién molida (1 cucharadita). Mezcla bien hasta formar una crema espesa.',
                'En un sartén grande frío, coloca el guanciale. Enciende a fuego medio-bajo. Cocina durante 6-8 minutos sin tocar hasta que suelte su grasa y quede crujiente y dorado. Retira el sartén del fuego.',
                'Cuando la pasta esté lista, reserva 1 taza del agua de cocción. Escurre la pasta rápidamente (no la enjuagues). Inmediatamente agrégala al sartén con el guanciale. Mezcla 30 segundos.',
                'Con el sartén fuera del fuego, agrega la mezcla de huevo y queso. Mezcla rápido con movimientos circulares durante 1 minuto. Agrega agua de cocción (2-3 cucharadas) si está muy espesa. El calor de la pasta cocinará el huevo.',
                'Sirve inmediatamente en platos calientes. Agrega más pecorino rallado y pimienta negra al gusto. NO dejes reposar, la carbonara debe comerse al instante.'
            ]
        ];

        $recetas = Receta::all();
        $actualizadas = 0;
        $force = $this->option('force');

        $this->info("🔍 Encontradas {$recetas->count()} recetas");
        $this->info("📝 Actualizando pasos...\n");

        foreach ($recetas as $receta) {
            if (!$force && !empty($receta->pasos) && is_array($receta->pasos) && count($receta->pasos) > 0) {
                $this->line("⏭️  Omitiendo '{$receta->titulo}' - Ya tiene pasos");
                continue;
            }

            $titulo = strtolower($receta->titulo);
            $pasos = $pasosTemplates['default'];

            if (str_contains($titulo, 'carbonara')) {
                $pasos = $pasosTemplates['carbonara'];
            } elseif (str_contains($titulo, 'taco')) {
                $pasos = $pasosTemplates['tacos'];
            } elseif (str_contains($titulo, 'pasta') || str_contains($titulo, 'spaguetti')) {
                $pasos = $pasosTemplates['pasta'];
            }

            $receta->pasos = $pasos;
            $receta->save();

            $actualizadas++;
            $this->info("✅ Actualizada: '{$receta->titulo}' con " . count($pasos) . " pasos");
        }

        $this->info("\n🎉 Proceso completado!");
        $this->info("📊 Total de recetas actualizadas: $actualizadas");

        return 0;
    }
}
