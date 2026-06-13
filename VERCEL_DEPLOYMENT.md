# AfriLoc - Deploiement Vercel

Vercel ne fournit pas PHP comme runtime officiel. Cette configuration utilise le runtime communautaire `vercel-php`.

## Base de donnees

N'utilise pas SQLite en production Vercel : les fonctions Vercel ont un filesystem en lecture seule, avec uniquement `/tmp` en ecriture temporaire. Il faut utiliser une base externe PostgreSQL ou MySQL.

Option recommandee pour une demo client :

- Neon PostgreSQL
- Supabase PostgreSQL
- Railway PostgreSQL
- Aiven PostgreSQL

## Variables Vercel a configurer

Dans Vercel > Project > Settings > Environment Variables :

```env
APP_KEY=base64:...
APP_URL=https://ton-projet.vercel.app
DB_CONNECTION=pgsql
DB_HOST=...
DB_PORT=5432
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...
DB_SSLMODE=require
```

Pour generer une cle localement :

```bash
php artisan key:generate --show
```

## Build et deploy

```bash
npm install
composer install
npm run build
vercel
```

Apres avoir cree la base externe, execute les migrations et seeders depuis ta machine en pointant `.env` vers la base distante :

```bash
php artisan migrate:fresh --seed
```

Comptes de demo apres seed :

```text
admin@afriloc.com / password123
promoteur.valide@afriloc.com / password123
client1@afriloc.com / password123
```
