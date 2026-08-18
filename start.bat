@echo off
title AutoLux Car Rental - Starting...
color 0B

echo.
echo  ============================================
echo    AutoLux Car Rental System - Quick Start
echo  ============================================
echo.

:: Set paths
set PHP=C:\xampp\php\php.exe
set MYSQL=C:\xampp\mysql\bin\mysql.exe
set XAMPP=C:\xampp\xampp_start.exe
set PROJECT_DIR=%~dp0

:: Check if PHP exists
if not exist "%PHP%" (
    echo  [ERROR] PHP not found at %PHP%
    echo  Make sure XAMPP is installed at C:\xampp
    pause
    exit /b 1
)

:: ---- Step 1: Start XAMPP Apache & MySQL if not running ----
echo  [1/5] Checking Apache and MySQL...

netstat -an | findstr "0.0.0.0:80" >nul 2>&1
if errorlevel 1 (
    echo        Starting Apache...
    start "" /B C:\xampp\apache\bin\httpd.exe >nul 2>&1
    timeout /t 2 >nul
) else (
    echo        Apache is already running.
)

netstat -an | findstr "0.0.0.0:3306" >nul 2>&1
if errorlevel 1 (
    echo        Starting MySQL...
    start "" /B C:\xampp\mysql\bin\mysqld.exe --defaults-file=C:\xampp\mysql\bin\my.ini >nul 2>&1
    echo        Waiting for MySQL to start...
    timeout /t 5 >nul
) else (
    echo        MySQL is already running.
)

:: ---- Step 2: Create database if it doesn't exist ----
echo  [2/5] Checking database...
"%MYSQL%" -u root -e "CREATE DATABASE IF NOT EXISTS car_rental_db;" >nul 2>&1
if errorlevel 1 (
    echo        [WARNING] Could not create database. Make sure MySQL is running.
    echo        Open XAMPP Control Panel and start MySQL manually.
    pause
    exit /b 1
) else (
    echo        Database 'car_rental_db' is ready.
)

:: ---- Step 3: Run migrations ----
echo  [3/5] Running database migrations...
cd /d "%PROJECT_DIR%"
"%PHP%" artisan migrate --force >nul 2>&1
echo        Migrations complete.

:: ---- Step 4: Start Vite (frontend) ----
echo  [4/5] Starting Vite dev server...
start "Vite Dev Server" cmd /k "cd /d "%PROJECT_DIR%" && npm run dev"
timeout /t 3 >nul

:: ---- Step 5: Start Laravel server ----
echo  [5/5] Starting Laravel server...
echo.
echo  ============================================
echo    App is running at: http://127.0.0.1:8000
echo    Press Ctrl+C to stop the server
echo  ============================================
echo.

:: Open browser automatically
start "" http://127.0.0.1:8000

:: Start Laravel (this keeps the window open)
"%PHP%" artisan serve
