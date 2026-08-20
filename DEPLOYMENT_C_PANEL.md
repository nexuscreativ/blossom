# BLOSSOM Magazine — cPanel Shared Hosting Deployment Guide

## Project Status (Production Ready)

| Component | Status |
|-----------|--------|
| Laravel 11.55.1 | ✅ Configured |
| Filament v4.12.6 (Admin) | ✅ 4 Resources, 13 routes |
| Tailwind CSS v4 (local build) | ✅ 77KB minified |
| Paystack/Monnify/Nomba | ✅ Service layer ready |
| Database | ✅ 25 tables, seeded with content |
| Admin User | ✅ admin@blossom.ng / password |
| Public Pages | ✅ 12 pages (all 200) |
| Auth (Login/Register) | ✅ Working |
| Newsletter System | ✅ Livewire + Mail + Job |
| Contact Page | ✅ Form + info |
| Community Feed | ✅ Livewire component |
| Subscription Checkout | ✅ Livewire (kobo bug fixed) |

## Directory Structure on Server

```
~/public_html/              ← Document root (point domain here)
  └── public/               ← Laravel's public folder (symlink or rename)
       ├── index.php
       ├── .htaccess
       ├── assets/
       │    ├── css/blossom.css
       │    └── js/animations.js
       └── build/            ← Vite build output (if used)

~/app/                      ← Laravel application (one level above doc root)
~/config/
~/database/
~/resources/
~/routes/
~/storage/                  ← Must be writable (chmod 775)
~/vendor/
```

## Step-by-Step Deployment

### 1. Upload Project

Via cPanel File Manager or SSH:

```bash
# Upload the entire project (minus node_modules, .git) to ~/blossom/
# Then symlink public → public_html
ln -s ~/blossom/public ~/public_html
```

**Alternative (if symlinks not allowed):**
Copy contents of `public/` into `public_html/` and edit `index.php`:
```php
require __DIR__.'/../blossom/vendor/autoload.php';
$app = require_once __DIR__.'/../blossom/bootstrap/app.php';
```

### 2. Environment Configuration

Upload `.env` to project root (one level above `public/`):

```env
APP_NAME="BLOSSOM Magazine"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY
APP_URL=https://yourdomain.com
APP_DEBUG=false

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=hello@blossom.ng
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@blossom.ng
MAIL_FROM_NAME="BLOSSOM Magazine"

# Paystack
PAYSTACK_SECRET_KEY=sk_live_xxx
PAYSTACK_PUBLIC_KEY=pk_live_xxx
PAYSTACK_WEBHOOK_SECRET=whsec_xxx

# Monnify
MONNIFY_API_KEY=mk_live_xxx
MONNIFY_SECRET_KEY=sk_live_xxx
MONNIFY_CONTRACT_CODE=MNF_xxx
MONNIFY_SUBACCOUNT_CODE=ACCT_xxx

# Nomba
NOMBA_API_KEY=nk_live_xxx
NOMBA_SECRET_KEY=nsk_live_xxx
NOMBA_MERCHANT_ID=xxx
```

### 3. Generate App Key

```bash
cd ~/blossom
php artisan key:generate
```

### 4. Database Setup

1. Create MySQL database in cPanel → MySQL Databases
2. Create database user, assign to database with ALL PRIVILEGES
3. Update `.env` with credentials
4. Import database (choose one):

**Option A — Full import (with seed data including admin user):**
```bash
mysql -u user -p database_name < database/blossom_full.sql
```

**Option B — Schema only (fresh install, then seed):**
```bash
mysql -u user -p database_name < database/blossom_schema.sql
php artisan db:seed --force
php artisan blossom:create-admin
```

### 5. Storage Symlink

```bash
php artisan storage:link
```

If this fails (common on shared hosting), manually create:
```bash
ln -s ~/blossom/storage/app/public ~/blossom/public/storage
```

### 6. Set Permissions

```bash
chmod -R 775 ~/blossom/storage
chmod -R 775 ~/blossom/bootstrap/cache
chmod -R 775 ~/blossom/public/storage
```

### 7. Cache Configuration (Performance)

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 8. Cron Job for Queues

In cPanel → Cron Jobs, add:

```bash
# Run queue worker every 5 minutes
*/5 * * * * cd /home/youruser/blossom && php artisan queue:work --sleep=30 --tries=3 --max-time=300 >> /dev/null 2>&1
```

### 9. Cron for Scheduler

```bash
# Run Laravel scheduler every minute
* * * * * cd /home/youruser/blossom && php artisan schedule:run >> /dev/null 2>&1
```

## .htaccess (public root)

The `public/.htaccess` file handles Laravel routing:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Front Controller
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## Troubleshooting

| Issue | Fix |
|-------|-----|
| 500 error | Check `.env` exists and `APP_KEY` is set. Verify `storage/` permissions. |
| White screen | Set `APP_DEBUG=true` temporarily to see errors. |
| Assets not loading | Ensure `public/` is the document root. Check file paths. |
| Queue not processing | Verify cron job is active. Check `failed_jobs` table. |
| Mail not sending | Use Gmail app password or configure Amazon SES SMTP. |
| Storage not writable | `chmod -R 775 storage` or contact hosting provider. |

## Performance Tips for Shared Hosting

1. **Always cache**: `php artisan config:cache && php artisan route:cache && php artisan view:cache`
2. **File caching only** — no Redis/Memcached on shared hosting
3. **Database queues** — no Redis/Beanstalkd available
4. **Compress assets** — CSS/JS minification via build tools
5. **Use CDN** — Cloudflare free tier for static assets
6. **Optimize images** — compress before upload, use WebP where possible

## Backup Strategy

```bash
# Database backup
mysqldump -u user -p database_name > backup_$(date +%Y%m%d).sql

# Full backup
tar -czf blossom_backup_$(date +%Y%m%d).tar.gz ~/blossom/
```
