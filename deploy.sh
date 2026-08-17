#!/bin/bash
# ==============================================================
# deploy.sh - Script Deploy Otomatis untuk cPanel Terminal
# SIT Robbani SmartEdu System
# ==============================================================
# Jalankan di terminal cPanel setelah git pull:
#   bash deploy.sh
# atau untuk pull sekaligus deploy:
#   bash deploy.sh --pull
# ==============================================================

set -e
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}  SIT Robbani SmartEdu - Auto Deploy${NC}"
echo -e "${BLUE}========================================${NC}"

# Tentukan PHP binary (override 8.1 di cPanel)
PHP_BIN=""
for bin in /usr/local/php84/bin/php /opt/cpanel/ea-php84/root/usr/bin/php /usr/bin/php8.4 /usr/local/bin/php8.4; do
    if [ -f "$bin" ]; then
        PHP_BIN="$bin"
        break
    fi
done

# Fallback ke php default jika 8.4 tidak ditemukan
if [ -z "$PHP_BIN" ]; then
    PHP_BIN="php"
    echo -e "${YELLOW}⚠️  PHP 8.4 tidak ditemukan, pakai default: $(which php)${NC}"
    echo -e "${YELLOW}   Versi: $(php -v | head -n1)${NC}"
else
    echo -e "${GREEN}✅ PHP ditemukan: $PHP_BIN${NC}"
    echo -e "${GREEN}   Versi: $($PHP_BIN -v | head -n1)${NC}"
fi

# Tentukan Composer binary
COMPOSER_BIN=""
for bin in /usr/local/php84/bin/composer /usr/bin/composer /usr/local/bin/composer ~/composer.phar; do
    if [ -f "$bin" ]; then
        COMPOSER_BIN="$bin"
        break
    fi
done

if [ -z "$COMPOSER_BIN" ]; then
    echo -e "${YELLOW}⚠️  Composer tidak ditemukan, download dulu...${NC}"
    $PHP_BIN -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    $PHP_BIN composer-setup.php --install-dir=. --filename=composer.phar
    COMPOSER_BIN="./composer.phar"
fi

echo -e "${GREEN}✅ Composer: $COMPOSER_BIN${NC}"

# =====================
# 1. Aktifkan maintenance mode
# =====================
echo -e "\n${YELLOW}[1/8] Mengaktifkan maintenance mode...${NC}"
$PHP_BIN artisan down --render="errors.503" --retry=60 || true

# =====================
# 2. Git pull (opsional)
# =====================
if [ "$1" == "--pull" ]; then
    echo -e "\n${YELLOW}[2/8] Git pull dari GitHub...${NC}"
    git pull origin main
else
    echo -e "\n${YELLOW}[2/8] Lewati git pull (jalankan manual atau via cPanel Git)${NC}"
fi

# =====================
# 3. Install/Update Composer dependencies
# =====================
echo -e "\n${YELLOW}[3/8] Update dependencies Composer...${NC}"
$PHP_BIN $COMPOSER_BIN install --optimize-autoloader --no-dev --no-interaction

# =====================
# 4. Jalankan migrasi database
# =====================
echo -e "\n${YELLOW}[4/8] Migrasi database...${NC}"
$PHP_BIN artisan migrate --force

# =====================
# 5. Clear dan cache semua
# =====================
echo -e "\n${YELLOW}[5/8] Clear cache & optimize...${NC}"
$PHP_BIN artisan config:clear
$PHP_BIN artisan cache:clear
$PHP_BIN artisan view:clear
$PHP_BIN artisan route:clear

$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache
$PHP_BIN artisan view:cache

# =====================
# 6. Set permission folder storage & bootstrap/cache
# =====================
echo -e "\n${YELLOW}[6/8] Set permissions...${NC}"
chmod -R 755 storage bootstrap/cache
find storage -type d -exec chmod 755 {} \;
find storage -type f -exec chmod 644 {} \;
chmod -R 755 public/uploads

# =====================
# 7. Generate symlink storage
# =====================
echo -e "\n${YELLOW}[7/8] Symlink storage...${NC}"
$PHP_BIN artisan storage:link || true

# =====================
# 8. Nonaktifkan maintenance mode
# =====================
echo -e "\n${YELLOW}[8/8] Menonaktifkan maintenance mode...${NC}"
$PHP_BIN artisan up

echo -e "\n${GREEN}========================================${NC}"
echo -e "${GREEN}  ✅ DEPLOY SELESAI!${NC}"
echo -e "${GREEN}  Website: $($PHP_BIN artisan env 2>/dev/null | grep APP_URL || echo 'cek .env APP_URL')${NC}"
echo -e "${GREEN}  Waktu: $(date '+%Y-%m-%d %H:%M:%S')${NC}"
echo -e "${GREEN}========================================${NC}"
