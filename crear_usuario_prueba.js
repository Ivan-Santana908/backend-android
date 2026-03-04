import { MongoClient } from 'mongodb';
import bcrypt from 'bcryptjs';

async function crearUsuarioPrueba() {
    const uri = "mongodb+srv://alejandro908:polo90812@cluster0.hi5jkhs.mongodb.net/?retryWrites=true&w=majority";
    const client = new MongoClient(uri);

    try {
        await client.connect();
        console.log('✓ Conectado a MongoDB Atlas');

        const database = client.db('culinarysmart');
        const collection = database.collection('usuarios');

        // Verificar si ya existe
        const existingUser = await collection.findOne({ email: 'test@culinarysmart.com' });

        if (existingUser) {
            console.log('✓ Usuario de prueba ya existe');
            console.log('Email: test@culinarysmart.com');
            console.log('Password: test123');
        } else {
            // Hash de la contraseña
            const password = await bcrypt.hash('test123', 10);

            // Crear usuario
            const result = await collection.insertOne({
                nombre: 'Usuario de Prueba',
                email: 'test@culinarysmart.com',
                password: password,
                personas: 1,
                rol: 'user',
                perfilCompleto: false,
                recetas_guardadas: [],
                alergias: [],
                preferencias: ['Vegetariana', 'Sin gluten'],
                metaCalorias: 14000,
                planes_semanales: [],
                listas_de_compra: [],
                created_at: new Date(),
                updated_at: new Date()
            });

            console.log('✓ Usuario de prueba creado exitosamente');
            console.log('Email: test@culinarysmart.com');
            console.log('Password: test123');
            console.log('ID:', result.insertedId.toString());
        }

        // Contar usuarios totales
        const count = await collection.countDocuments();
        console.log(`\nTotal de usuarios en la base de datos: ${count}`);

    } catch (error) {
        console.error('❌ Error:', error.message);
    } finally {
        await client.close();
    }
}

crearUsuarioPrueba();
