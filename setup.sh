#!/usr/bin/env bash

# =====================================================
# setup.sh
# Cross-platform Laravel auto setup
# Windows / macOS / Linux / WSL
# =====================================================

set -e

# -----------------------------------------------------
# COLORS
# -----------------------------------------------------
GREEN='\033[0;32m'
RED='\033[0;31m'
CYAN='\033[0;36m'
YELLOW='\033[1;33m'
NC='\033[0m'

# -----------------------------------------------------
# CONFIG
# -----------------------------------------------------
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

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
MAILPIT_WIN="$SCRIPT_DIR/mailpit/mailpit.exe"
MAILPIT_UNIX="$SCRIPT_DIR/mailpit/mailpit"

# -----------------------------------------------------
# HELPERS
# -----------------------------------------------------
step(){ echo ""; echo -e "${CYAN}$1${NC}"; }
ok(){ echo -e "${GREEN}$1${NC}"; }
warn(){ echo -e "${YELLOW}$1${NC}"; }
fail(){ echo -e "${RED}ERROR: $1${NC}"; exit 1; }

# -----------------------------------------------------
# MAILPIT DETECTION
# -----------------------------------------------------
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

# -----------------------------------------------------
# SAFE ENV UPDATE
# -----------------------------------------------------
set_env() {
    KEY=$1
    VALUE=$2

    if grep -q "^${KEY}=" .env; then
        sed -i.bak "s|^${KEY}=.*|${KEY}=${VALUE}|" .env
    else
        echo "${KEY}=${VALUE}" >> .env
    fi
}

# -----------------------------------------------------
# HEADER
# -----------------------------------------------------
clear
echo ""
echo "====================================================="
echo " Quick Start(setup.sh)"
echo "====================================================="
echo ""

# -----------------------------------------------------
# PASSWORD INPUT
# -----------------------------------------------------
echo -n "Enter MySQL root password (leave blank if none): "
read -s DB_PASS
echo ""
echo ""

# -----------------------------------------------------
# 1. COMPOSER
# -----------------------------------------------------
step "[1/10] Checking Composer dependencies..."

if [ ! -d "vendor" ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader || fail "Composer install failed."
else
    echo "Composer dependencies already installed."
fi

# -----------------------------------------------------
# 2. .ENV
# -----------------------------------------------------
step "[2/10] Checking .env..."

if [ ! -f ".env" ]; then
    cp .env.example .env
    echo ".env created."
else
    echo ".env exists."
fi

# -----------------------------------------------------
# 3. CONFIGURE ENV
# -----------------------------------------------------
step "[3/10] Writing environment configuration..."

set_env DB_CONNECTION "$DB_CONN"
set_env DB_HOST "$DB_HOST"
set_env DB_PORT "$DB_PORT"
set_env DB_DATABASE "$DB_NAME"
set_env DB_USERNAME "$DB_USER"
set_env DB_PASSWORD "$DB_PASS"

set_env MAIL_MAILER "$MAIL_MAILER"
set_env MAIL_HOST "$MAIL_HOST"
set_env MAIL_PORT "$MAIL_PORT"
set_env MAIL_USERNAME "null"
set_env MAIL_PASSWORD "null"
set_env MAIL_ENCRYPTION "null"
set_env MAIL_FROM_ADDRESS "\"$MAIL_FROM_ADDRESS\""
set_env MAIL_FROM_NAME "\"$MAIL_FROM_NAME\""

rm -f .env.bak

# HARD RESET CACHE
php artisan optimize:clear >/dev/null 2>&1 || true

ok ".env configured successfully."

# -----------------------------------------------------
# 4. APP KEY
# -----------------------------------------------------
step "[4/10] Generating application key..."
php artisan key:generate --force || fail "Key generation failed."

# -----------------------------------------------------
# 5. BREEZE
# -----------------------------------------------------
step "[5/10] Checking Laravel Breeze..."

if [ ! -f "resources/views/auth/login.blade.php" ]; then
    composer require laravel/breeze --dev --no-interaction || fail "Breeze install failed."
    php artisan breeze:install blade --no-interaction || fail "Breeze setup failed."
else
    echo "Laravel Breeze already installed."
fi

# -----------------------------------------------------
# 6. NODE
# -----------------------------------------------------
step "[6/10] Installing npm packages..."
npm install || fail "npm install failed."

# -----------------------------------------------------
# 7. BUILD
# -----------------------------------------------------
step "[7/10] Building frontend..."
npm run build || fail "npm build failed."

# -----------------------------------------------------
# 8. DATABASE
# -----------------------------------------------------
step "[8/10] Preparing database..."

# Export variables so Laravel uses them NOW
export DB_CONNECTION="$DB_CONN"
export DB_HOST="$DB_HOST"
export DB_PORT="$DB_PORT"
export DB_DATABASE="$DB_NAME"
export DB_USERNAME="$DB_USER"
export DB_PASSWORD="$DB_PASS"

php artisan optimize:clear >/dev/null 2>&1 || true



echo "Running migrations..."
php artisan migrate:fresh --force || fail "Migration failed."

echo "Running seeders..."
php artisan db:seed --force || fail "Seeder failed."

php artisan db:seed --class=AdminUserSeeder --force || true

ok "Database ready."

# -----------------------------------------------------
# 9. STORAGE
# -----------------------------------------------------
step "[9/10] Creating storage link..."
php artisan storage:link --force >/dev/null 2>&1 || true
ok "Storage linked."

# -----------------------------------------------------
# 10. CACHE CLEAR
# -----------------------------------------------------
step "[10/10] Clearing Laravel caches..."
php artisan optimize:clear >/dev/null 2>&1 || true
ok "Caches cleared."

# =====================================================
# START SERVICES
# =====================================================
step "[11/10] Starting development services..."

WIN_PATH=$(pwd -W 2>/dev/null || true)
UNIX_PATH=$(pwd)

# -----------------------------------------------------
# WINDOWS / GIT BASH / MINGW
# -----------------------------------------------------
if [[ "$OSTYPE" == "msys"* || "$OSTYPE" == "cygwin"* || "$OSTYPE" == "win32"* ]]; then

    MP_WIN=$(cygpath -w "$MAILPIT_CMD" 2>/dev/null || echo "$MAILPIT_CMD")

    powershell.exe -NoProfile -Command "Start-Process powershell -ArgumentList '-NoExit','-Command','cd \"${WIN_PATH}\"; php artisan serve'"
    powershell.exe -NoProfile -Command "Start-Process powershell -ArgumentList '-NoExit','-Command','cd \"${WIN_PATH}\"; php artisan queue:work'"
    powershell.exe -NoProfile -Command "Start-Process powershell -ArgumentList '-NoExit','-Command','cd \"${WIN_PATH}\"; npm run dev'"
    powershell.exe -NoProfile -Command "Start-Process powershell -ArgumentList '-NoExit','-Command','& \"${MP_WIN}\"'"

# -----------------------------------------------------
# macOS
# -----------------------------------------------------
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

# -----------------------------------------------------
# Linux
# -----------------------------------------------------
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
        warn "No supported terminal detected."
        warn "Run manually:"
        echo "php artisan serve"
        echo "php artisan queue:work"
        echo "npm run dev"
        echo "$MAILPIT_CMD"
    fi
fi

# =====================================================
# DONE
# =====================================================
echo ""
ok "====================================================="
ok " SETUP COMPLETE!"
ok "====================================================="
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