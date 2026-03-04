import sys

try:
    from pymongo import MongoClient
    from pymongo.server_api import ServerApi
    
    # Datos de conexión
    uri = "mongodb+srv://alejandro908:polo90812@cluster0.hi5jkhs.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0"
    
    print("🔄 Intentando conectar a MongoDB Atlas...")
    print(f"Host: cluster0.hi5jkhs.mongodb.net")
    print(f"Usuario: alejandro908")
    print()
    
    # Crear cliente
    client = MongoClient(uri, server_api=ServerApi('1'), serverSelectionTimeoutMS=5000)
    
    # Probar conexión
    client.admin.command('ping')
    
    print("✅ CONEXIÓN EXITOSA a MongoDB Atlas!")
    print()
    
    # Listar bases de datos
    print("📊 Bases de datos disponibles:")
    for db in client.list_database_names():
        print(f"  - {db}")
    
    # Verificar/crear base de datos nutriplan
    db = client['nutriplan']
    print(f"\n📁 Base de datos 'nutriplan':")
    collections = db.list_collection_names()
    if collections:
        print(f"  Colecciones: {', '.join(collections)}")
    else:
        print("  (vacía - lista para usar)")
    
    client.close()
    print("\n✅ Las credenciales son CORRECTAS")
    
except ImportError:
    print("❌ pymongo no está instalado")
    print("\nPara instalar: pip install pymongo")
    print("\nAlternativamente, verifica en Railway Shell con:")
    print("  php artisan tinker")
    print("  DB::connection()->getMongoDB()->command(['ping' => 1]);")
    sys.exit(1)
    
except Exception as e:
    print(f"❌ ERROR DE CONEXIÓN: {str(e)}")
    print("\n🔍 Posibles causas:")
    print("  1. Contraseña incorrecta")
    print("  2. Usuario no tiene permisos")
    print("  3. IP no permitida en Network Access de Atlas")
    print("  4. Cluster pausado o no disponible")
    print("\n💡 Verifica en MongoDB Atlas:")
    print("  - Database Access: usuario 'alejandro908' existe")
    print("  - Network Access: 0.0.0.0/0 está permitido")
    sys.exit(1)
