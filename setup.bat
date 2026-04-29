@echo off
setlocal EnableDelayedExpansion
title setup.bat
color 0A

REM =============================================
REM setup.bat
REM Laravel Full Dev Auto Setup (Windows)
REM Fully corrected / stable version
REM =============================================

echo.
echo =============================================
echo Quick Start(setup.bat)
echo =============================================
echo.

REM ---------------------------------------------
REM CONFIG
REM ---------------------------------------------
set "DB_CONN=mysql"
set "DB_HOST=127.0.0.1"
set "DB_PORT=3306"
set "DB_NAME=db_evolucija_na_sonot_nikolovski_dejan"
set "DB_USER=root"

set "MAIL_MAILER=smtp"
set "MAIL_HOST=127.0.0.1"
set "MAIL_PORT=1025"
set "MAIL_FROM_ADDRESS=noreply@evolucija.com"

REM IMPORTANT: no spaces = avoids .env parser issues
set "MAIL_FROM_NAME=Evolucija_na_Sonot"

set "ROOT_DIR=%~dp0"
set "MAILPIT_PATH=%ROOT_DIR%mailpit\mailpit.exe"

REM ---------------------------------------------
REM ASK PASSWORD (hidden)
REM ---------------------------------------------
echo Enter MySQL root password (leave blank if none):
for /f "delims=" %%p in ('powershell -Command "$p=Read-Host -AsSecureString; $B=[Runtime.InteropServices.Marshal]::SecureStringToBSTR($p); [Runtime.InteropServices.Marshal]::PtrToStringAuto($B)"') do set "DB_PASS=%%p"
echo.

REM ---------------------------------------------
REM 1. COMPOSER
REM ---------------------------------------------
echo [1/10] Checking Composer dependencies...
if not exist "vendor" (
    call composer install --no-interaction --prefer-dist --optimize-autoloader
    if errorlevel 1 goto :failComposer
) else (
    echo Composer already installed.
)

REM ---------------------------------------------
REM 2. .ENV
REM ---------------------------------------------
echo.
echo [2/10] Checking .env...
if not exist ".env" (
    copy .env.example .env >nul
    echo .env created.
) else (
    echo .env exists.
)

REM ---------------------------------------------
REM 3. CONFIGURE .ENV
REM ---------------------------------------------
echo.
echo [3/10] Configuring .env...

powershell -Command "(Get-Content .env) -replace '^#?\s*DB_CONNECTION=.*','DB_CONNECTION=%DB_CONN%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*DB_HOST=.*','DB_HOST=%DB_HOST%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*DB_PORT=.*','DB_PORT=%DB_PORT%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*DB_DATABASE=.*','DB_DATABASE=%DB_NAME%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*DB_USERNAME=.*','DB_USERNAME=%DB_USER%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*DB_PASSWORD=.*','DB_PASSWORD=%DB_PASS%' | Set-Content .env"

powershell -Command "(Get-Content .env) -replace '^#?\s*MAIL_MAILER=.*','MAIL_MAILER=%MAIL_MAILER%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*MAIL_HOST=.*','MAIL_HOST=%MAIL_HOST%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*MAIL_PORT=.*','MAIL_PORT=%MAIL_PORT%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*MAIL_USERNAME=.*','MAIL_USERNAME=null' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*MAIL_PASSWORD=.*','MAIL_PASSWORD=null' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*MAIL_ENCRYPTION=.*','MAIL_ENCRYPTION=null' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*MAIL_FROM_ADDRESS=.*','MAIL_FROM_ADDRESS=%MAIL_FROM_ADDRESS%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^#?\s*MAIL_FROM_NAME=.*','MAIL_FROM_NAME=%MAIL_FROM_NAME%' | Set-Content .env"

php artisan config:clear >nul
php artisan cache:clear >nul

echo .env configured.

REM ---------------------------------------------
REM 4. KEY
REM ---------------------------------------------
echo.
echo [4/10] Generating application key...
php artisan key:generate --force
if errorlevel 1 goto :failKey

REM ---------------------------------------------
REM 5. BREEZE
REM ---------------------------------------------
echo.
echo [5/10] Checking Laravel Breeze...
if not exist "resources\views\auth\login.blade.php" (
    call composer require laravel/breeze --dev --no-interaction
    if errorlevel 1 goto :failBreeze

    php artisan breeze:install blade --no-interaction
    if errorlevel 1 goto :failBreeze
) else (
    echo Breeze already installed.
)

REM ---------------------------------------------
REM 6. NPM INSTALL
REM ---------------------------------------------
echo.
echo [6/10] Installing NPM dependencies...
call npm install
if errorlevel 1 goto :failNpm

REM ---------------------------------------------
REM 7. BUILD
REM ---------------------------------------------
echo.
echo [7/10] Building frontend...
call npm run build
if errorlevel 1 goto :failBuild

REM ---------------------------------------------
REM 8. DATABASE
REM ---------------------------------------------
echo.
echo [8/10] Running migrations...

php artisan config:clear >nul
php artisan cache:clear >nul

php artisan migrate --force
if errorlevel 1 goto :failMigrate

echo.
echo Running migrate:fresh --seed...
php artisan migrate:fresh --seed --force
if errorlevel 1 goto :failSeed

php artisan db:seed --class=AdminUserSeeder --force

echo Database ready.

REM ---------------------------------------------
REM 9. STORAGE
REM ---------------------------------------------
echo.
echo [9/10] Creating storage symlink...
php artisan storage:link --force

REM ---------------------------------------------
REM 10. CACHE CLEAR
REM ---------------------------------------------
echo.
echo [10/10] Clearing caches...

php artisan config:clear >nul
php artisan cache:clear >nul
php artisan route:clear >nul
php artisan view:clear >nul

echo Caches cleared.

REM ---------------------------------------------
REM START SERVICES
REM ---------------------------------------------
echo.
echo [11/10] Starting development services...

start "Laravel Server" powershell -NoExit -Command "php artisan serve"
start "Queue Worker" powershell -NoExit -Command "php artisan queue:work"
start "Vite Dev Server" powershell -NoExit -Command "npm run dev"

if exist "%MAILPIT_PATH%" (
    start "Mailpit" "%MAILPIT_PATH%"
) else (
    echo Mailpit not found:
    echo %MAILPIT_PATH%
)

REM ---------------------------------------------
REM DONE
REM ---------------------------------------------
echo.
echo =============================================
echo   SETUP COMPLETE!
echo =============================================
echo.
echo App URL      : http://127.0.0.1:8000
echo Admin Panel  : http://127.0.0.1:8000/admin
echo Database     : %DB_NAME%
echo.
echo Admin Login:
echo Email        : admin@evolucija.com
echo Password     : password
echo.
echo Mailpit:
echo SMTP         : localhost:1025
echo Web UI       : http://localhost:8025
echo.
echo All services launched.
echo.
pause
exit /b

REM ---------------------------------------------
REM FAIL HANDLERS
REM ---------------------------------------------
:failComposer
echo ERROR: Composer install failed.
pause
exit /b 1

:failKey
echo ERROR: Key generation failed.
pause
exit /b 1

:failBreeze
echo ERROR: Laravel Breeze install failed.
pause
exit /b 1

:failNpm
echo ERROR: npm install failed.
pause
exit /b 1

:failBuild
echo ERROR: npm run build failed.
pause
exit /b 1

:failMigrate
echo ERROR: Migration failed. Check MySQL and credentials.
pause
exit /b 1

:failSeed
echo ERROR: Seeding failed.
pause
exit /b 1