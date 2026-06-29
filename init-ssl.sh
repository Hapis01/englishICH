#!/bin/bash
# =================================================================
# init-ssl.sh – Run ONCE on first deployment to obtain SSL cert
# Usage: bash init-ssl.sh
# =================================================================
set -e

DOMAIN="englishclub.hafizbatubara.my.id"
EMAIL="alifa.qadri@gmail.com"

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

info()    { echo -e "${GREEN}[✓]${NC} $1"; }
warning() { echo -e "${YELLOW}[!]${NC} $1"; }
error()   { echo -e "${RED}[✗]${NC} $1"; exit 1; }

echo ""
echo "========================================================"
echo "  EnglishICH – SSL Initialization"
echo "  Domain : $DOMAIN"
echo "  Server : 103.93.134.128"
echo "========================================================"
echo ""

# ── Preflight checks ──────────────────────────────────────────────
[ ! -f ".env" ] && error ".env not found. Copy .env.docker → .env and fill passwords."
command -v docker >/dev/null || error "Docker is not installed."
docker compose version >/dev/null 2>&1 || error "Docker Compose plugin not found."

# Ensure port 80 is accessible (DNS must point to this server)
warning "Make sure DNS A record for $DOMAIN points to 103.93.134.128"
warning "Let's Encrypt will connect to this IP to verify domain ownership."
echo ""
read -p "Continue? (y/N): " confirm
[[ "$confirm" =~ ^[Yy]$ ]] || { echo "Aborted."; exit 0; }
echo ""

# ── Step 1: Build images ──────────────────────────────────────────
info "Step 1/6 – Building Docker images (this may take a few minutes)..."
docker compose build --quiet

# ── Step 2: Start database ────────────────────────────────────────
info "Step 2/6 – Starting database..."
docker compose up -d db

echo "         Waiting for MariaDB to be ready..."
until docker compose exec -T db healthcheck.sh --connect --innodb_initialized 2>/dev/null; do
    printf "."
    sleep 3
done
echo ""
info "         Database is ready."

# ── Step 3: Create temporary self-signed certificate ─────────────
info "Step 3/6 – Creating temporary self-signed certificate..."
docker compose run --rm --entrypoint /bin/sh certbot -c "
    mkdir -p /etc/letsencrypt/live/${DOMAIN} && \
    openssl req -x509 -nodes -newkey rsa:4096 -days 1 \
        -keyout '/etc/letsencrypt/live/${DOMAIN}/privkey.pem' \
        -out    '/etc/letsencrypt/live/${DOMAIN}/fullchain.pem' \
        -subj '/CN=localhost' 2>/dev/null
"

# ── Step 4: Start app + nginx with dummy cert ─────────────────────
info "Step 4/6 – Starting app and nginx with temporary certificate..."
docker compose up -d app nginx
echo "         Waiting for nginx to be ready..."
sleep 8

# ── Step 5: Obtain real Let's Encrypt certificate ─────────────────
info "Step 5/6 – Requesting Let's Encrypt certificate for ${DOMAIN}..."
docker compose run --rm --entrypoint /usr/local/bin/certbot certbot certonly \
    --webroot \
    --webroot-path=/var/www/certbot \
    --email "$EMAIL" \
    --agree-tos \
    --no-eff-email \
    --force-renewal \
    -d "$DOMAIN"

# ── Step 6: Reload nginx + start all services ─────────────────────
info "Step 6/6 – Reloading nginx with real certificate..."
docker compose exec nginx nginx -s reload

info "         Starting all remaining services (queue, certbot renewal)..."
docker compose up -d

echo ""
echo "========================================================"
echo -e "  ${GREEN}✅ SSL setup complete!${NC}"
echo "  App : https://${DOMAIN}"
echo ""
echo "  Auto-renewal is handled by the 'certbot' container."
echo "  To check logs: docker compose logs certbot"
echo "========================================================"
