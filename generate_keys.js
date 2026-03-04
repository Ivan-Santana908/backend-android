import crypto from 'crypto';
import base64 from 'base-64';

// Generar APP_KEY (Laravel usa base64 de 32 bytes random)
const appKeyBytes = crypto.randomBytes(32);
const appKey = 'base64:' + Buffer.from(appKeyBytes).toString('base64');

// Generar JWT_SECRET (256 bits = 32 bytes en base64)
const jwtSecretBytes = crypto.randomBytes(64);
const jwtSecret = Buffer.from(jwtSecretBytes).toString('base64');

console.log('🔑 VARIABLES GENERADAS PARA RAILWAY:\n');
console.log('APP_KEY=' + appKey);
console.log('JWT_SECRET=' + jwtSecret);
console.log('\n📋 Copia estas variables a Railway Dashboard → Variables');
