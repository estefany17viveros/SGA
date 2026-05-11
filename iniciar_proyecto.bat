@echo off

set PROYECTO=C:\xampp\htdocs\SGA

cd /d %PROYECTO%

:: INICIAR XAMPP
cscript //nologo %PROYECTO%\start_xampp_hidden.vbs

:: ESPERAR MYSQL
timeout /t 10 >nul

:: LIMPIAR CACHE
php artisan optimize:clear >nul 2>&1

:: ELIMINAR HOT
if exist public\hot del /f /q public\hot

:: INICIAR VITE
start "" /min cmd /c "cd /d %PROYECTO% && npm run dev -- --host"

:: ESPERAR VITE
timeout /t 8 >nul

:: INICIAR LARAVEL
start "" /min cmd /c "cd /d %PROYECTO% && php artisan serve --host=0.0.0.0 --port=8000"

:: ESPERAR
timeout /t 5 >nul

:: ABRIR SISTEMA
start http://192.168.10.30:8000

exit