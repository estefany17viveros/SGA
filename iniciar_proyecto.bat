@echo off

set PROYECTO=C:\xampp\htdocs\SGA

cd /d %PROYECTO%

:: INICIAR XAMPP OCULTO
cscript //nologo %PROYECTO%\start_xampp_hidden.vbs

:: ESPERAR MYSQL
timeout /t 10 >nul

:: LIMPIAR
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan route:clear >nul 2>&1

:: 🔥 INICIAR VITE DEV OCULTO (LA CLAVE)
start "" /min cmd /c "cd /d %PROYECTO% && npm run dev"

:: ESPERAR VITE
timeout /t 8 >nul

:: LARAVEL OCULTO
start "" /min cmd /c "cd /d %PROYECTO% && php artisan serve --host=0.0.0.0 --port=8000"

timeout /t 5 >nul

:: ABRIR
start http://localhost:8000

exit