#!/bin/bash
set -e

# ── Install vendor jika belum ada (first boot atau vendor volume kosong) ──────
if [ ! -f "vendor/autoload.php" ]; then
    echo "[entrypoint] Installing composer dependencies..."
    composer install --no-dev --optimize-autoloader --no-interaction --quiet
fi

# ── Wait for MariaDB ──────────────────────────────────────────────────────────
echo "[entrypoint] Waiting for database at ${DB_HOST}:${DB_PORT}..."
max_tries=30
count=0
until php -r "
    try {
        new PDO(
            'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD'),
            [PDO::ATTR_TIMEOUT => 3]
        );
    } catch (Exception \$e) { exit(1); }
" 2>/dev/null; do
    count=$((count + 1))
    if [ "$count" -ge "$max_tries" ]; then
        echo "[entrypoint] ERROR: database not reachable after ${max_tries} attempts."
        exit 1
    fi
    echo "[entrypoint] Not ready yet ($count/$max_tries)... retrying in 3s"
    sleep 3
done
echo "[entrypoint] Database is ready."

# ── App key ───────────────────────────────────────────────────────────────────
if [ -z "$APP_KEY" ]; then
    echo "[entrypoint] No APP_KEY – generating one (tambahkan ke .env)."
    php artisan key:generate --force
fi

# ── Storage symlink ───────────────────────────────────────────────────────────
php artisan storage:link --force 2>/dev/null || true

# ── Laravel caches ───────────────────────────────────────────────────────────
if [ "$APP_ENV" = "production" ]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    echo "[entrypoint] Laravel caches built."
fi

echo "[entrypoint] Starting PHP-FPM..."
exec "$@"
