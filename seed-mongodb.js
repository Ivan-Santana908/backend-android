import { MongoClient } from 'mongodb';

const uri = "mongodb+srv://alejandro908:polo90812@cluster0.hi5jkhs.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";

async function seedDatabase() {
    const client = new MongoClient(uri, { serverSelectionTimeoutMS: 5000 });
    
    try {
        console.log('🔄 Conectando a MongoDB Atlas...\n');
        await client.connect();
        
        const db = client.db('culinarysmart');
        
        // Limpiar colecciones existentes
        console.log('🗑️  Limpiando colecciones...');
        await db.collection('recetas').deleteMany({});
        await db.collection('ingredientes').deleteMany({});
        await db.collection('usuarios').deleteMany({});
        console.log('✅ Colecciones limpiadas\n');
        
        // Crear usuario de prueba
        console.log('👤 Creando usuario de prueba...');
        const usuarioResult = await db.collection('usuarios').insertOne({
            nombre: 'Usuario Test',
            email: 'test@example.com',
            password: '$2y$10$dXJ3SW6G7P50feHQbq0fDu1VjKoKLSDrKLJoGvZXp6zAW.P5a/RQq', // password: secret
            created_at: new Date(),
            updated_at: new Date()
        });
        const usuarioId = usuarioResult.insertedId;
        console.log(`✅ Usuario creado con ID: ${usuarioId}\n`);
        
        // Crear ingredientes base
        console.log('🥘 Creando ingredientes...');
        const ingredientes = [
            { nombre: 'Spaghetti', unidad: 'g' },
            { nombre: 'Huevos', unidad: 'unidades' },
            { nombre: 'Queso pecorino', unidad: 'g' },
            { nombre: 'Guanciale', unidad: 'g' },
            { nombre: 'Pimienta negra', unidad: 'cucharadita' },
            { nombre: 'Sal', unidad: 'cucharadita' },
            { nombre: 'Pollo', unidad: 'g' },
            { nombre: 'Tortillas', unidad: 'unidades' },
            { nombre: 'Lechuga', unidad: 'taza' },
            { nombre: 'Tomate', unidad: 'unidades' },
            { nombre: 'Cebolla', unidad: 'unidades' },
            { nombre: 'Aceite vegetal', unidad: 'cucharadas' },
            { nombre: 'Comino', unidad: 'cucharadita' },
            { nombre: 'Pimentón', unidad: 'cucharadita' },
            { nombre: 'Limón', unidad: 'unidades' },
            { nombre: 'Cilantro', unidad: 'taza' },
            { nombre: 'Arroz', unidad: 'tazas' },
        ];
        
        const ingResult = await db.collection('ingredientes').insertMany(ingredientes);
        console.log(`✅ ${ingredientes.length} ingredientes creados\n`);
        
        // Crear recetas
        console.log('🍝 Creando recetas...');
        const recetas = [
            {
                titulo: 'Pasta Carbonara Auténtica',
                descripcion: 'La receta original italiana con guanciale, huevo y pecorino. Cremosa sin usar crema.',
                tiempo_preparacion: 15,
                tiempo_coccion: 12,
                calorias_porcion: 520,
                porciones: 4,
                dificultad: 'Media',
                tipo: 'Italiana',
                usuario_id: usuarioId,
                ingredientes: [
                    { nombre: 'Spaghetti', cantidad: 320, unidad: 'g' },
                    { nombre: 'Huevos', cantidad: 3, unidad: 'unidades' },
                    { nombre: 'Queso pecorino', cantidad: 80, unidad: 'g' },
                    { nombre: 'Guanciale', cantidad: 100, unidad: 'g' },
                ],
                pasos: [
                    'Corta 100g de guanciale en cubos de 1cm.',
                    'Pon una olla grande con 3-4 litros de agua y 2 cucharadas de sal.',
                    'En un bowl, bate 3 huevos enteros + 1 yema.',
                    'Cocina el guanciale a fuego medio-bajo durante 6-8 minutos.',
                    'Cuando la pasta esté lista, agrégala al sartén.',
                    'Con el sartén fuera del fuego, agrega la mezcla de huevo.',
                    'Sirve inmediatamente con más queso y pimienta.'
                ],
                created_at: new Date(),
                updated_at: new Date()
            },
            {
                titulo: 'Tacos de Pollo al Pastor',
                descripcion: 'Tacos mexicanos con pollo marinado y vegetales frescos.',
                tiempo_preparacion: 20,
                tiempo_coccion: 10,
                calorias_porcion: 380,
                porciones: 4,
                dificultad: 'Fácil',
                tipo: 'Mexicana',
                usuario_id: usuarioId,
                ingredientes: [
                    { nombre: 'Pollo', cantidad: 500, unidad: 'g' },
                    { nombre: 'Tortillas', cantidad: 12, unidad: 'unidades' },
                    { nombre: 'Lechuga', cantidad: 1, unidad: 'taza' },
                    { nombre: 'Tomate', cantidad: 2, unidad: 'unidades' },
                ],
                pasos: [
                    'Corta 500g de pollo en cubos de 2cm.',
                    'Sazona con sal, pimienta y comino.',
                    'Calienta aceite a fuego medio-alto.',
                    'Agrega el pollo y cocina 4 minutos sin mover.',
                    'Voltea y cocina 4-5 minutos más.',
                    'Calienta tortillas sobre la llama.',
                    'Arma los tacos con pollo, lechuga, tomate y salsa.'
                ],
                created_at: new Date(),
                updated_at: new Date()
            },
            {
                titulo: 'Arroz con Pollo Tradicional',
                descripcion: 'Arroz amarillo con pollo jugoso. Perfecto para toda la familia.',
                tiempo_preparacion: 15,
                tiempo_coccion: 30,
                calorias_porcion: 420,
                porciones: 6,
                dificultad: 'Fácil',
                tipo: 'Latinoamericana',
                usuario_id: usuarioId,
                ingredientes: [
                    { nombre: 'Arroz', cantidad: 2, unidad: 'tazas' },
                    { nombre: 'Pollo', cantidad: 6, unidad: 'piezas' },
                    { nombre: 'Cebolla', cantidad: 1, unidad: 'unidad' },
                ],
                pasos: [
                    'Lava 2 tazas de arroz bajo agua fría.',
                    'Sazona el pollo con sal, pimienta y comino.',
                    'Dora el pollo por ambos lados.',
                    'Sofríe cebolla y ajo.',
                    'Agrega el arroz y mezcla.',
                    'Vierte caldo de pollo.',
                    'Tapa y cocina 20-25 minutos.'
                ],
                created_at: new Date(),
                updated_at: new Date()
            }
        ];
        
        const recResult = await db.collection('recetas').insertMany(recetas);
        console.log(`✅ ${recetas.length} recetas creadas\n`);
        
        console.log('=' .repeat(60));
        console.log('🎉 BASE DE DATOS POBLADA EXITOSAMENTE');
        console.log('=' .repeat(60));
        console.log('\n📊 Resumen:');
        console.log(`  ✅ ${ingredientes.length} ingredientes`);
        console.log(`  ✅ ${recetas.length} recetas`);
        console.log(`  ✅ 1 usuario de prueba`);
        console.log('\n🚀 Ahora prueba: https://backend-android-production-55c1.up.railway.app/api/alexa/recetas');
        
    } catch (error) {
        console.error('❌ ERROR:', error.message);
        process.exit(1);
    } finally {
        await client.close();
    }
}

seedDatabase();
