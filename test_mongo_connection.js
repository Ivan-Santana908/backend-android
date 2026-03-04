import { MongoClient } from 'mongodb';

const uri = "mongodb+srv://alejandro908:polo90812@cluster0.hi5jkhs.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";

async function testConnection() {
    const client = new MongoClient(uri, {
        serverSelectionTimeoutMS: 5000
    });
    
    try {
        console.log('🔄 Intentando conectar a MongoDB Atlas...');
        console.log('Host: cluster0.hi5jkhs.mongodb.net');
        console.log('Usuario: alejandro908\n');
        
        await client.connect();
        
        await client.db('admin').command({ ping: 1 });
        console.log('✅ CONEXIÓN EXITOSA a MongoDB Atlas!\n');
        
        console.log('📊 Bases de datos disponibles:');
        const databases = await client.db().admin().listDatabases();
        databases.databases.forEach(db => console.log(`  - ${db.name}`));
        
        const db = client.db('nutriplan');
        const collections = await db.listCollections().toArray();
        console.log(`\n📁 Base de datos 'nutriplan':`);
        if (collections.length > 0) {
            console.log(`  Colecciones: ${collections.map(c => c.name).join(', ')}`);
        } else {
            console.log('  (vacía - lista para usar)');
        }
        
        console.log('\n✅ Las credenciales son CORRECTAS');
        
    } catch (error) {
        console.error('❌ ERROR DE CONEXIÓN:', error.message);
        console.log('\n🔍 Posibles causas:');
        console.log('  1. Contraseña incorrecta');
        console.log('  2. Usuario no tiene permisos');
        console.log('  3. IP no permitida en Network Access de Atlas');
        console.log('  4. Cluster pausado o no disponible');
        console.log('\n💡 Verifica en MongoDB Atlas:');
        console.log('  - Database Access: usuario "alejandro908" existe');
        console.log('  - Network Access: 0.0.0.0/0 está permitido');
        process.exit(1);
    } finally {
        await client.close();
    }
}

testConnection();
