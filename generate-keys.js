import crypto from 'crypto';

// Generar APP_KEY (base64 encoded 32 bytes)
const appKeyBytes = crypto.randomBytes(32);
const appKey = 'base64:' + appKeyBytes.toString('base64');

// Generar JWT_SECRET (base64 encoded 256 bits = 32 bytes)
const jwtSecretBytes = crypto.randomBytes(32);
const jwtSecret = jwtSecretBytes.toString('base64');

console.log('✅ CLAVES GENERADAS PARA RAILWAY:\n');
console.log('APP_KEY:');
console.log(appKey);
console.log('\n' + '='.repeat(80) + '\n');
console.log('JWT_SECRET:');
console.log(jwtSecret);
console.log('\n' + '='.repeat(80) + '\n');
console.log('Copia ambos valores y pégalos en Railways → Variables');
