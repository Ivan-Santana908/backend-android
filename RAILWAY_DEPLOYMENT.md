# ☁️ RAILWAY DEPLOYMENT CHECKLIST

## 📋 Variables de Entorno Requeridas

Configura estas variables en el Dashboard de Railway antes de desplegar:

### 🔐 Aplicación
```
APP_NAME=CulinarySmart
APP_ENV=production
APP_KEY=base64:TU_APP_KEY_AQUI
APP_DEBUG=false
APP_URL=https://tu-app.up.railway.app
```

**⚠️ IMPORTANTE:** Genera `APP_KEY` ejecutando localmente:
```bash
php artisan key:generate --show
```

### 🗄️ MongoDB Atlas
```
DB_CONNECTION=mongodb
DB_HOST=cluster0.xxxxx.mongodb.net
DB_PORT=27017
DB_DATABASE=nutriplan
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
DB_AUTHENTICATION_DATABASE=admin
```

**📝 TIP:** Obtén estos valores desde MongoDB Atlas:
1. Connect → Drivers → Connection String
2. Formato: `mongodb+srv://USUARIO:PASSWORD@CLUSTER.mongodb.net/`

### 🔑 JWT Authentication
```
JWT_SECRET=tu_secret_jwt_muy_largo_y_seguro
```

**⚠️ IMPORTANTE:** Genera manualmente:
```bash
php artisan jwt:secret
```

O usa un generador online de 256-bit secrets.

### 🌐 CORS (Orígenes permitidos)
```
CORS_ALLOWED_ORIGINS=https://tu-frontend.azurestaticapps.net,http://localhost:5173
```

**📝 TIP:** Separa múltiples orígenes con comas (sin espacios).

### 📧 Mail (Opcional - para reseteo de passwords)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@culinarysmart.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🚀 Comandos de Build & Start

Railway detectará automáticamente Laravel, pero asegúrate que usa:

### Build Command
```bash
composer install --no-dev --optimize-autoloader && php artisan config:cache && php artisan route:cache
```

### Start Command
```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

**✅ NOTA:** Railway configura `$PORT` automáticamente.

---

## ✅ Pre-deployment Checklist

Antes de hacer push a Railway:

- [ ] ✅ Variables de entorno configuradas en Railway Dashboard
- [ ] ✅ MongoDB Atlas Cluster creado (M0 Free Tier)
- [ ] ✅ Usuario de DB con permisos de lectura/escritura
- [ ] ✅ Network Access en MongoDB Atlas permite conexiones desde Railway (0.0.0.0/0)
- [ ] ✅ `APP_KEY` generado con `php artisan key:generate`
- [ ] ✅ `JWT_SECRET` generado con `php artisan jwt:secret`
- [ ] ✅ CORS configurado con origen de Azure Static Web App
- [ ] ✅ `APP_DEBUG=false` en producción
- [ ] ✅ Procfile existe en la raíz del proyecto

---

## 🧪 Testing API después del despliegue

Prueba estos endpoints:

### 1. Health Check
```bash
curl https://tu-app.up.railway.app/api/home
```

Debería retornar `401 Unauthorized` (correcto, necesitas auth).

### 2. Register
```bash
curl -X POST https://tu-app.up.railway.app/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

Debería retornar un token JWT.

### 3. Login
```bash
curl -X POST https://tu-app.up.railway.app/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'
```

Debería retornar un token JWT.

---

## 🔍 Troubleshooting

### Error: "Base table or collection not found"
✅ Ejecuta migraciones/seeders localmente contra MongoDB Atlas primero:
```bash
php artisan migrate
php artisan db:seed
```

### Error: "CORS policy blocked"
✅ Verifica que `CORS_ALLOWED_ORIGINS` incluya tu frontend de Azure.

### Error: "Unauthenticated"
✅ Verifica que `JWT_SECRET` esté configurado correctamente.

### Error: 500 Internal Server Error
✅ Activa temporalmente `APP_DEBUG=true` y revisa logs en Railway Dashboard.

---

## 📱 Siguiente paso: Configurar Android App

Una vez que Railway esté funcionando, actualiza la app Android:

1. Editar `culinarysmart-android/gradle.properties`:
```properties
API_BASE_URL=https://tu-app.up.railway.app/api/
```

2. Rebuild y genera AAB para Play Store:
```bash
cd culinarysmart-android
./gradlew mobile:bundleRelease
```

---

**🎉 ¡Listo para desplegar a Railway!**
