#!/bin/bash
# =================================================================
# post-pull.sh – Jalankan setelah git pull untuk apply perubahan
# Usage: bash post-pull.sh
# =================================================================
set -e

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo ""
echo "========================================================"
echo "  EnglishICH – Apply Git Pull"
echo "========================================================"

# Cek apakah ada perubahan di composer.json
COMPOSER_CHANGED=false
if git diff HEAD@{1} HEAD -- composer.json composer.lock 2>/dev/null | grep -q .; then
    COMPOSER_CHANGED=true
fi

# Cek apakah ada perubahan di frontend
FRONTEND_CHANGED=false
if git diff HEAD@{1} HEAD -- resources/ vite.config.js package.json 2>/dev/null | grep -q .; then
    FRONTEND_CHANGED=true
fi

# Install/update composer jika ada perubahan
if [ "$COMPOSER_CHANGED" = true ]; then
    echo -e "${YELLOW}[!]${NC} Composer dependencies changed – updating..."
    docker compose exec -T app composer install --no-dev --optimize-autoloader --quiet
fi

# Rebuild nginx jika ada perubahan frontend (Vite assets)
if [ "$FRONTEND_CHANGED" = true ]; then
    echo -e "${YELLOW}[!]${NC} Frontend changed – rebuilding Vite assets & nginx..."
    docker compose build --quiet nginx
    docker compose up -d nginx
fi

# Selalu clear & rebuild Laravel caches setelah pull
echo -e "${GREEN}[✓]${NC} Rebuilding Laravel caches..."
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache

# Restart queue worker agar pakai code terbaru
echo -e "${GREEN}[✓]${NC} Restarting queue worker..."
docker compose restart queue

echo ""
echo "========================================================"
echo -e "  ${GREEN}✅ Done! Perubahan sudah aktif.${NC}"
echo "  PHP changes: langsung aktif (bind-mount)"
if [ "$FRONTEND_CHANGED" = true ]; then
    echo "  Frontend: nginx sudah di-rebuild"
fi
echo "========================================================"
