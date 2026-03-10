@echo off
echo ================================================
echo  Aplicando Mejoras de Seguridad - BoviTrack
echo ================================================
echo.

echo [1/4] Limpiando cache de configuracion...
php artisan config:clear

echo.
echo [2/4] Limpiando cache de aplicacion...
php artisan cache:clear

echo.
echo [3/4] Verificando tabla de sesiones...
php artisan session:table 2>nul
if %errorlevel% == 0 (
    echo Migracion de sesiones creada.
) else (
    echo Tabla de sesiones ya existe.
)

echo.
echo [4/4] Ejecutando migraciones...
php artisan migrate --force

echo.
echo ================================================
echo  MUY IMPORTANTE: Actualiza tu archivo .env
echo ================================================
echo.
echo Agrega o actualiza estas lineas en tu archivo .env:
echo.
echo SESSION_LIFETIME=60
echo SESSION_ENCRYPT=true
echo SESSION_EXPIRE_ON_CLOSE=true
echo SESSION_SAME_SITE=strict
echo SESSION_HTTP_ONLY=true
echo.
echo ================================================
echo  Proceso completado!
echo ================================================
echo.
echo Reinicia el servidor para aplicar todos los cambios.
echo.
pause
