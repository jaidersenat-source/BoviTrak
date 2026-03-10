@echo off
echo ====================================
echo Optimizando BoviTrack para Rendimiento
echo ====================================
echo.

echo [1/5] Optimizando autoload de Composer...
call composer dump-autoload -o
echo.

echo [2/5] Cacheando configuracion de Laravel...
call php artisan config:cache
echo.

echo [3/5] Cacheando rutas...
call php artisan route:cache
echo.

echo [4/5] Cacheando vistas Blade...
call php artisan view:cache
echo.

echo [5/5] Compilando assets de produccion con Vite...
call npm run build
echo.

echo ====================================
echo Optimizacion completada exitosamente!
echo ====================================
echo.
echo Tu aplicacion ahora esta optimizada para mejor rendimiento.
echo Para desarrollo normal, ejecuta: iniciar-desarrollo.bat
echo.
pause
