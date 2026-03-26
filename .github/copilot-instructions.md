# Copilot / Agent instructions for BoviTrack

Propósito
-------
Proveer a Copilot/agents un punto de entrada conciso con enlaces a la documentación y artefactos clave del repositorio. Siga el principio: "Link, don't embed" — no incluir grandes fragmentos de código ni secretos.

Cómo pedir ayuda (ejemplos)
--------------------------------
- "Resumen rápido: ¿qué hace [routes/web.php](routes/web.php)?"
- "Propón un PR para mejorar la validación en [app/Http/Controllers/GanadoController.php](app/Http/Controllers/GanadoController.php)."
- "¿Qué pasos sigo para arrancar el entorno en Windows? Refiérete a [iniciar-desarrollo.bat](iniciar-desarrollo.bat)."
- "Genera tests Pest para la creación de `Animal` (ver [app/Models/Animal.php](app/Models/Animal.php) y `database/migrations`)."

Qué evitar
-----------
- No exponer ni leer archivos de entorno o secretos (`.env`).
- No ejecutar comandos destructivos sin confirmar (por ejemplo migraciones con `--force`, borrados masivos).
- No reemplazar archivos de configuración críticos sin verificación humana previa (p.ej. `composer.json`, `vite.config.js`, `tailwind.config.js`).

Enlaces rápidos
--------------
- [README.md](README.md)
- [BOOTSTRAP-INTEGRATION.md](BOOTSTRAP-INTEGRATION.md)
- [OPTIMIZACIONES.md](OPTIMIZACIONES.md)
- [SEGURIDAD.md](SEGURIDAD.md)
- [GUIA-MIGRACION-CSS.md](GUIA-MIGRACION-CSS.md)
- [package.json](package.json)
- [composer.json](composer.json)
- [phpunit.xml](phpunit.xml)
- [iniciar-desarrollo.bat](iniciar-desarrollo.bat)
- [optimizar-rendimiento.bat](optimizar-rendimiento.bat)
- [aplicar-seguridad.bat](aplicar-seguridad.bat)
- [vite.config.js](vite.config.js)
- [tailwind.config.js](tailwind.config.js)
- [artisan](artisan)
- [routes/web.php](routes/web.php)
- [app/Models/Animal.php](app/Models/Animal.php)
- [app/Models/AnimalPhoto.php](app/Models/AnimalPhoto.php)
- [app/Models/User.php](app/Models/User.php)
- [app/Http/Controllers/GanadoController.php](app/Http/Controllers/GanadoController.php)
- [resources/views/public/animal-show.blade.php](resources/views/public/animal-show.blade.php)
- [resources/views/dashboard.blade.php](resources/views/dashboard.blade.php)
- [database/migrations/](database/migrations/)
- [tests/](tests/)

Notas de mantenimiento
---------------------
Mantener este archivo breve. Al reorganizar la estructura del repo o agregar subsistemas (p.ej. frontend separado), añadir secciones con `applyTo` o archivos de instrucciones específicos por área.

Si deseas, puedo:
- Añadir instrucciones específicas para desarrollo en Windows (pasos detallados).
- Crear un `AGENTS.md` con roles/limitaciones más estrictas por tipo de agente.
