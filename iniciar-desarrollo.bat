@echo off
echo ================================================
echo  Iniciando BoviTrack con Bootstrap
echo ================================================
echo.

echo [INFO] Verificando instalación de dependencias...
if not exist "node_modules" (
    echo [WARN] Instalando dependencias de Node...
    cmd /c "npm install"
)

echo.
echo [INFO] Compilando assets con Vite...
cmd /c "npm run build"

echo.
echo ================================================
echo  Servidor listo!
echo ================================================
echo.
echo Abre tu navegador en: http://localhost:8000
echo.
echo Para desarrollo con hot-reload, ejecuta en otra terminal:
echo   npm run dev
echo.
echo ================================================
pause
