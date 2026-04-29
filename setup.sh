#!/usr/bin/env bash

# =============================================
# setup.sh
# Cross-platform Laravel Dev Environment
# Windows / macOS / Linux
# Local Mailpit support + global fallback
# =============================================

set -e

# ---------------------------------------------
# COLORS
# ---------------------------------------------
GREEN='\033[0;32m'
RED='\033[0;31m'
CYAN='\033[0;36m'
YELLOW='\033[1;33m'
NC='\033[0m'

# ---------------------------------------------
# CONFIG
# ---------------------------------------------
DB_CONN="mysql"
DB_HOST="127.0.0.1"
DB_PORT="3306"
DB_NAME="db_evolucija_na_sonot_nikolovski_dejan"
DB_USER="root"

MAIL_MAILER="smtp"
MAIL_HOST="127.0.0.1"
MAIL_PORT="1025"
MAIL_FROM_ADDRESS="noreply@evolucija.com"
MAIL_FROM_NAME="Еволуција на Сонот"

# ---------------------------------------------
# PATHS
# ---------------------------------------------
SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"

MAILPIT_WIN="$SCRIPT_DIR/mailpit/mailpit.exe"
MAILPIT_UNIX="$SCRIPT_DIR/mailpit/mailpit"

# ---------------------------------------------
# HELPERS
# ---------------------------------------------
step(){ echo ""; echo -e "${CYAN}$1${NC}"; }
ok(){ echo -e "${GREEN}$1${NC}"; }
warn(){ echo -e "${YELLOW}$1${NC}"; }
fail(){ echo -e "${RED}ERROR: $1${NC}"; exit 1; }

# ---------------------------------------------
# MAILPIT DETECTION
# ---------------------------------------------
get_mailpit_cmd() {
    if [[ "$OSTYPE" == "msys"* || "$OSTYPE" == "cygwin"* || "$OSTYPE" == "win32"* ]]; then
        if [ -f "$MAILPIT_WIN" ]; then
            echo "$MAILPIT_WIN"
        else
            echo "mailpit.exe"
        fi
    else
        if [ -f "$MAILPIT_UNIX" ]; then
            chmod +x "$MAILPIT_UNIX" >/dev/null 2>&1 || true
            echo "$MAILPIT_UNIX"
        else
            echo "mailpit"
        fi
    fi
}

MAILPIT_CMD=$(get_mailpit_cmd)

# ---------------------------------------------
# HEADER
# ---------------------------------------------
clear
echo ""
echo "============================================="
echo " ULTIMATE setup.sh v3"
echo "============================================="
echo ""

# ---------------------------------------------
# PASSWORD
# ---------------------------------------------
echo -n "Enter MySQL root password (blank if none): "
read -s DB_PASS
echo ""
echo ""

# ---------------------------------------------
# 1. COMPOSER
# ---------------------------------------------
step "[1/10] Checking Composer dependencies..."

if [ ! -d "vendor" ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader || fail "Composer install failed."
else
    echo "Composer already installed."
fi

# ---------------------------------------------
# 2. .ENV
# ---------------------------------------------
step "[2/10] Checking .env..."

if [ ! -f ".env" ]; then
    cp .env.example .env
    echo ".env created."
else
    echo ".env exists."
fi

# ---------------------------------------------
# 3. CONFIGURE ENV
# ---------------------------------------------
step "[3/10] Configuring .env..."

sed -i.bak "s|^#\?DB_CONNECTION=.*|DB_CONNECTION=${DB_CONN}|" .env
sed -i.bak "s|^#\?DB_HOST=.*|DB_HOST=${DB_HOST}|" .env
sed -i.bak "s|^#\?DB_PORT=.*|DB_PORT=${DB_PORT}|" .env
sed -i.bak "s|^#\?DB_DATABASE=.*|DB_DATABASE=${DB_NAME}|" .env
sed -i.bak "s|^#\?DB_USERNAME=.*|DB_USERNAME=${DB_USER}|" .env
sed -i.bak "s|^#\?DB_PASSWORD=.*|DB_PASSWORD=${DB_PASS}|" .env

sed -i.bak "s|^#\?MAIL_MAILER=.*|MAIL_MAILER=${MAIL_MAILER}|" .env
sed -i.bak "s|^#\?MAIL_HOST=.*|MAIL_HOST=${MAIL_HOST}|" .env
sed -i.bak "s|^#\?MAIL_PORT=.*|MAIL_PORT=${MAIL_PORT}|" .env
sed -i.bak "s|^#\?MAIL_USERNAME=.*|MAIL_USERNAME=null|" .env
sed -i.bak "s|^#\?MAIL_PASSWORD=.*|MAIL_PASSWORD=null|" .env
sed -i.bak "s|^#\?MAIL_ENCRYPTION=.*|MAIL_ENCRYPTION=null|" .env
sed -i.bak "s|^#\?MAIL_FROM_ADDRESS=.*|MAIL_FROM_ADDRESS=${MAIL_FROM_ADDRESS}|" .env
sed -i.bak "s|^#\?MAIL_FROM_NAME=.*|MAIL_FROM_NAME=\"${MAIL_FROM_NAME}\"|" .env

rm -f .env.bak

php artisan config:clear >/dev/null 2>&1 || true
php artisan cache:clear >/dev/null 2>&1 || true

ok ".env configured."

# ---------------------------------------------
# 4. APP KEY
# ---------------------------------------------
step "[4/10] Generating application key..."
php artisan key:generate --force || fail "Key generation failed."

# ---------------------------------------------
# 5. BREEZE
# ---------------------------------------------
step "[5/10] Checking Laravel Breeze..."

if [ ! -f "resources/views/auth/login.blade.php" ]; then
    composer require laravel/breeze --dev --no-interaction || fail "Breeze install failed."
    php artisan breeze:install blade --no-interaction || fail "Breeze setup failed."
else
    echo "Breeze already installed."
fi

# ---------------------------------------------
# 6. NODE
# ---------------------------------------------
step "[6/10] Installing npm packages..."
npm install || fail "npm install failed."

# ---------------------------------------------
# 7. BUILD
# ---------------------------------------------
step "[7/10] Building frontend..."
npm run build || fail "npm build failed."

# ---------------------------------------------
# 8. DATABASE
# ---------------------------------------------
step "[8/10] Running migrations..."

php artisan config:clear >/dev/null 2>&1 || true
php artisan cache:clear >/dev/null 2>&1 || true

php artisan migrate --force || fail "Migration failed. Check MySQL and credentials."

echo ""
echo "Running migrate:fresh --seed..."
php artisan migrate:fresh --seed --force || fail "Seed failed."

php artisan db:seed --class=AdminUserSeeder --force || true

ok "Database ready."

# ---------------------------------------------
# 9. STORAGE
# ---------------------------------------------
step "[9/10] Storage link..."
php artisan storage:link --force || true

# ---------------------------------------------
# 10. CLEAR CACHE
# ---------------------------------------------
step "[10/10] Clearing caches..."

php artisan config:clear >/dev/null 2>&1 || true
php artisan cache:clear >/dev/null 2>&1 || true
php artisan route:clear >/dev/null 2>&1 || true
php artisan view:clear >/dev/null 2>&1 || true

ok "Caches cleared."

# =============================================
# START SERVICES
# =============================================
step "[11/10] Starting development services..."

WIN_PATH=$(pwd -W 2>/dev/null || true)
UNIX_PATH=$(pwd)

# ---------------------------------------------
# WINDOWS
# ---------------------------------------------
if [[ "$OSTYPE" == "msys"* || "$OSTYPE" == "cygwin"* || "$OSTYPE" == "win32"* ]]; then

    MP_WIN=$(cygpath -w "$MAILPIT_CMD" 2>/dev/null || echo "$MAILPIT_CMD")

    powershell.exe -NoProfile -Command "Start-Process powershell -ArgumentList '-NoExit','-Command','cd \"${WIN_PATH}\"; php artisan serve'"
    powershell.exe -NoProfile -Command "Start-Process powershell -ArgumentList '-NoExit','-Command','cd \"${WIN_PATH}\"; php artisan queue:work'"
    powershell.exe -NoProfile -Command "Start-Process powershell -ArgumentList '-NoExit','-Command','cd \"${WIN_PATH}\"; npm run dev'"
    powershell.exe -NoProfile -Command "Start-Process powershell -ArgumentList '-NoExit','-Command','& \"${MP_WIN}\"'"

# ---------------------------------------------
# MACOS
# ---------------------------------------------
elif [[ "$OSTYPE" == "darwin"* ]]; then

osascript <<EOF
tell application "Terminal"
    do script "cd '$UNIX_PATH'; php artisan serve"
    do script "cd '$UNIX_PATH'; php artisan queue:work"
    do script "cd '$UNIX_PATH'; npm run dev"
    do script "'$MAILPIT_CMD'"
    activate
end tell
EOF

# ---------------------------------------------
# LINUX
# ---------------------------------------------
else

    if command -v gnome-terminal >/dev/null 2>&1; then

        gnome-terminal -- bash -c "cd '$UNIX_PATH'; php artisan serve; exec bash"
        gnome-terminal -- bash -c "cd '$UNIX_PATH'; php artisan queue:work; exec bash"
        gnome-terminal -- bash -c "cd '$UNIX_PATH'; npm run dev; exec bash"
        gnome-terminal -- bash -c "'$MAILPIT_CMD'; exec bash"

    elif command -v xterm >/dev/null 2>&1; then

        xterm -e "cd '$UNIX_PATH'; php artisan serve" &
        xterm -e "cd '$UNIX_PATH'; php artisan queue:work" &
        xterm -e "cd '$UNIX_PATH'; npm run dev" &
        xterm -e "'$MAILPIT_CMD'" &

    else
        warn "No supported terminal found."
        warn "Run manually:"
        echo "php artisan serve"
        echo "php artisan queue:work"
        echo "npm run dev"
        echo "$MAILPIT_CMD"
    fi
fi

# =============================================
# DONE
# =============================================
echo ""
ok "============================================="
ok " SETUP COMPLETE!"
ok "============================================="
echo ""
echo "App URL      : http://127.0.0.1:8000"
echo "Admin Panel  : http://127.0.0.1:8000/admin"
echo "Database     : $DB_NAME"
echo ""
echo "Admin Login:"
echo "Email        : admin@evolucija.com"
echo "Password     : password"
echo ""
echo "Mailpit:"
echo "SMTP         : localhost:1025"
echo "Web UI       : http://localhost:8025"
echo ""
ok "All services launched."
echo ""