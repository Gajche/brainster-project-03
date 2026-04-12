@echo off
title One Click Setup
color 0A
echo.
echo =============================================
echo One Click Setup
echo =============================================
echo.

REM --------------------------------------------
REM CONFIGURATION
REM --------------------------------------------
set "DB_CONN=mysql"
set "DB_HOST=127.0.0.1"
set "DB_PORT=3306"
set "DB_NAME=db_evolucija_na_sonot_nikolovski_dejan"
set "DB_USER=root"

set "MAIL_MAILER=smtp"
set "MAIL_HOST=127.0.0.1"
set "MAIL_PORT=1025"
set "MAIL_FROM_ADDRESS=noreply@evolucija.com"
set "MAIL_FROM_NAME="Еволуција на Сонот""

REM --------------------------------------------
REM Ask for MySQL password
REM --------------------------------------------
echo Please enter your MySQL root password
echo (leave blank and press Enter if no password):
for /f "delims=" %%p in ('powershell -Command "$p = Read-Host -AsSecureString; $BSTR=[Runtime.InteropServices.Marshal]::SecureStringToBSTR($p); [Runtime.InteropServices.Marshal]::PtrToStringAuto($BSTR)"') do set "DB_PASS=%%p"
echo.

REM --------------------------------------------
REM 1. Install Composer Dependencies
REM --------------------------------------------
echo [1/10] Checking Composer dependencies...
if not exist "vendor" (
    call composer install --no-interaction --prefer-dist --optimize-autoloader
    if errorlevel 1 (
        echo ERROR: Composer install failed.
        pause
        exit /b 1
    )
) else (
    echo Composer dependencies already installed.
)

REM --------------------------------------------
REM 2. Copy .env if missing
REM --------------------------------------------
echo.
echo [2/10] Checking .env file...
if not exist ".env" (
    copy .env.example .env >nul
    echo .env created from .env.example.
) else (
    echo .env already exists. Skipping copy.
)

REM --------------------------------------------
REM 3. Configure .env - Database
REM --------------------------------------------
echo.
echo [3/10] Configuring .env ...

powershell -Command "(Get-Content .env) -replace '^#?\s*DB_CONNECTION=.*', 'DB_CONNECTION=%DB_CONN%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*DB_HOST=.*', 'DB_HOST=%DB_HOST%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*DB_PORT=.*', 'DB_PORT=%DB_PORT%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*DB_DATABASE=.*', 'DB_DATABASE=%DB_NAME%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*DB_USERNAME=.*', 'DB_USERNAME=%DB_USER%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*DB_PASSWORD=.*', 'DB_PASSWORD=%DB_PASS%' | Set-Content .env"

REM --------------------------------------------
REM 3b. Configure .env - Mailpit
REM --------------------------------------------
powershell -Command "(Get-Content .env) -replace '^#?\s*MAIL_MAILER=.*', 'MAIL_MAILER=%MAIL_MAILER%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*MAIL_HOST=.*', 'MAIL_HOST=%MAIL_HOST%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*MAIL_PORT=.*', 'MAIL_PORT=%MAIL_PORT%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*MAIL_USERNAME=.*', 'MAIL_USERNAME=null' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*MAIL_PASSWORD=.*', 'MAIL_PASSWORD=null' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*MAIL_ENCRYPTION=.*', 'MAIL_ENCRYPTION=null' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*MAIL_FROM_ADDRESS=.*', 'MAIL_FROM_ADDRESS=%MAIL_FROM_ADDRESS%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*MAIL_FROM_NAME=.*', 'MAIL_FROM_NAME=""%MAIL_FROM_NAME%""' | Set-Content .env"

php artisan config:clear >nul
echo .env configured successfully.

REM --------------------------------------------
REM 4. Generate Application Key
REM --------------------------------------------
echo.
echo [4/10] Generating application key...
php artisan key:generate --force
if errorlevel 1 (
    echo ERROR: Key generation failed.
    pause
    exit /b 1
)

REM --------------------------------------------
REM 5. Install Laravel Breeze (if missing)
REM --------------------------------------------
echo.
echo [5/10] Checking Laravel Breeze...
if not exist "resources\views\auth\login.blade.php" (
    echo Installing Laravel Breeze...
    call composer require laravel/breeze --dev --no-interaction
    if errorlevel 1 (
        echo ERROR: Breeze install failed.
        pause
        exit /b 1
    )
    php artisan breeze:install blade --no-interaction
) else (
    echo Breeze already installed. Skipping.
)


REM --------------------------------------------
REM 6. Install Node Dependencies
REM --------------------------------------------
echo.
echo [6/10] Installing NPM dependencies...
call npm install
if errorlevel 1 (
    echo ERROR: npm install failed.
    pause
    exit /b 1
)

REM --------------------------------------------
REM 7. Build Frontend Assets
REM --------------------------------------------
echo.
echo [7/10] Building frontend assets (Tailwind + Bootstrap via Vite)...
call npm run build
if errorlevel 1 (
    echo ERROR: npm run build failed.
    pause
    exit /b 1
)

REM --------------------------------------------
REM 8. Run Migrations + Seed Admin User
REM --------------------------------------------
echo.
echo [8/9] Running migrations...
php artisan migrate --force
if errorlevel 1 (
    echo ERROR: Migration failed.
    echo Make sure MySQL is running and your password is correct.
    pause
    exit /b 1
)

echo.
echo Running migrate:fresh --seed...
php artisan migrate:fresh --seed --force
if errorlevel 1 (
    echo ERROR: migrate:fresh --seed failed.
    pause
    exit /b 1
)

echo.
echo Seeding admin user...
php artisan db:seed --class=AdminUserSeeder --force
if errorlevel 1 (
    echo ERROR: Seeding failed.
    pause
    exit /b 1
)

REM --------------------------------------------
REM 9. Storage Symlink
REM --------------------------------------------
echo.
echo [9/10] Creating storage symlink...
php artisan storage:link --force
if errorlevel 1 (
    echo ERROR: storage:link failed.
    pause
    exit /b 1
)

REM --------------------------------------------
REM 10. Clear All Caches
REM --------------------------------------------
echo.
echo [10/10] Clearing caches...
php artisan config:clear >nul
php artisan cache:clear >nul
php artisan route:clear >nul
php artisan view:clear >nul
echo Caches cleared.

REM --------------------------------------------
REM Done
REM --------------------------------------------
echo.
echo =============================================
echo  Setup Complete!
echo =============================================
echo.
echo  App URL     : http://127.0.0.1:8000
echo  Database    : %DB_NAME%
echo.
echo  Admin login :
echo    URL       : http://127.0.0.1:8000/admin
echo    Email     : admin@evolucija.com
echo    Password  : password
echo.
echo  Mail testing (Mailpit):
echo    Start     : mailpit
echo    SMTP      : localhost:1025
echo    Web UI    : http://localhost:8025
echo.
echo  NOTE: Place your image assets in:
echo    storage\app\public\images\
echo  then run: php artisan storage:link
echo.
echo =============================================
echo  Starting Laravel development server...
echo =============================================
echo.
php artisan serve
pause