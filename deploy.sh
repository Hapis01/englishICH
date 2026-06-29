#!/bin/bash
# =================================================================
# deploy.sh – Run for every subsequent update after first deploy
# Usage: bash deploy.sh
# =================================================================
set -e

GREEN='\033[0;32m'
NC='\033[0m'
info() { echo -e "${GREEN}[✓]${NC} $1"; }

echo ""
echo "========================================================"
echo "  EnglishICH – Deploy Update"
echo "========================================================"
echo ""

info "Step 1/3 – Building updated Docker images..."
docker compose build --quiet

info "Step 2/3 – Restarting services with new images..."
docker compose up -d --remove-orphans

info "Step 3/3 – Service status:"
docker compose ps

echo ""
echo "========================================================"
echo -e "  ${GREEN}✅ Deployment complete!${NC}"
echo "  https://englishclub.hafizbatubara.my.id"
echo "========================================================"
