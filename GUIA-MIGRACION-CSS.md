# Guía de Migración CSS Profesional — BoviTrack

> Conversión de Tailwind CDN + estilos inline → arquitectura compilada con Vite  
> Fecha: Febrero 2026 | Stack: Laravel 11 + Vite 7 + Tailwind 3 + Bootstrap Icons

---

## Tabla de Contenidos

1. [Diagnóstico Actual](#1-diagnóstico-actual)
2. [Arquitectura Objetivo](#2-arquitectura-objetivo)
3. [Paso 1: Dependencias npm](#3-paso-1-dependencias-npm)
4. [Paso 2: tailwind.config.js](#4-paso-2-tailwindconfigjs)
5. [Paso 3: postcss.config.js](#5-paso-3-postcssconfigjs)
6. [Paso 4: vite.config.js](#6-paso-4-viteconfigjs)
7. [Paso 5: Estructura de CSS con @layer](#7-paso-5-estructura-de-css-con-layer)
8. [Paso 6: Integración de Bootstrap Icons vía npm](#8-paso-6-integración-de-bootstrap-icons-vía-npm)
9. [Paso 7: Layouts Blade](#9-paso-7-layouts-blade)
10. [Paso 8: Componentes Blade Reutilizables](#10-paso-8-componentes-blade-reutilizables)
11. [Paso 9: Migración de Estilos Inline](#11-paso-9-migración-de-estilos-inline)
12. [Paso 10: Eliminar animal-show.blade.php standalone](#12-paso-10-eliminar-animal-showbladephp-standalone)
13. [Paso 11: Build para Producción](#13-paso-11-build-para-producción)
14. [Paso 12: Verificación y Testing](#14-paso-12-verificación-y-testing)
15. [Estructura Final del Proyecto](#15-estructura-final-del-proyecto)
16. [Checklist de Migración](#16-checklist-de-migración)

---

## 1. Diagnóstico Actual

### Problemas encontrados

| Problema | Severidad | Detalle |
|----------|-----------|---------|
| Tailwind CDN en `animal-show.blade.php` | 🔴 Crítico | Script CDN bloquea rendering, sin tree-shaking (~300KB) |
| Bootstrap Icons CDN | 🟡 Medio | Ya instalado por npm pero se carga por CDN |
| ~200+ estilos inline | 🔴 Crítico | `style="..."` en todos los archivos |
| ~40+ handlers `onmouseover`/`onfocus` inline | 🔴 Crítico | JS inline para hover/focus |
| Bootstrap CSS + Tailwind importados juntos | 🟡 Medio | Conflicto de resets CSS |
| Focus rings inconsistentes | 🟡 Medio | Mezcla de `indigo`, `blue`, `#3E7C47` |
| Directorio `css/admin/` vacío | 🟢 Bajo | Estructura sin usar |
| `welcome.blade.php` sin personalizar | 🟢 Bajo | Template Laravel default |

### Paleta de colores actual (PRESERVAR)

```
Verde oscuro principal:  #1F4D2B  → bovi-green-800
Verde medio:             #3E7C47  → bovi-green-600
Verde intermedio:        #2F6038  → bovi-green-700
Verde muy oscuro:        #0F2A17  → bovi-green-950
Verde muy claro:         #f0f7f0  → bovi-green-50
Verde claro:             #e8f5e9  → bovi-green-100
Verde casi blanco:       #f9fdf9  → bovi-green-25
Verde claro 2:           #d4edda  → bovi-green-200

Marrón principal:        #8B6B4E  → bovi-brown-600
Marrón oscuro:           #6B5440  → bovi-brown-800
Marrón claro:            #D4A574  → bovi-brown-300

Beige fondo:             #F4EFE6  → bovi-beige-100
Beige oscuro:            #E8DED0  → bovi-beige-200
Beige borde:             #D4C5B0  → bovi-beige-300
Beige claro card:        #f5f0eb  → bovi-beige-50

Texto oscuro:            #2B2B2B  → bovi-dark

Ámbar/naranja:           #d97706  → amber-600 (Tailwind nativo)
Ámbar oscuro:            #b45309  → amber-700 (Tailwind nativo)
Ámbar muy oscuro:        #92400e  → amber-800 (Tailwind nativo)
```

---

## 2. Arquitectura Objetivo

```
resources/
├── css/
│   ├── app.css              ← Entry point principal (layouts autenticados)
│   ├── public.css            ← Entry point público (animal-show, etc.)
│   ├── base/
│   │   ├── _reset.css        ← Overrides base de Tailwind
│   │   └── _typography.css   ← Fuentes y tipografía global
│   ├── components/
│   │   ├── _buttons.css      ← .btn-primary, .btn-secondary, .btn-danger
│   │   ├── _cards.css        ← .card-bovi, .card-info, .card-section
│   │   ├── _forms.css        ← .input-bovi, .select-bovi, .file-input-bovi
│   │   ├── _badges.css       ← .badge-success, .badge-warning, etc.
│   │   ├── _navigation.css   ← .nav-brand, .nav-link-bovi, .nav-stats
│   │   └── _alerts.css       ← .alert-success, .alert-danger
│   ├── layouts/
│   │   ├── _header.css       ← Estilos header/navbar
│   │   ├── _footer.css       ← Estilos footer
│   │   └── _sidebar.css      ← Si se necesita en futuro
│   └── utilities/
│       └── _animations.css   ← Keyframes y animaciones
├── js/
│   ├── app.js
│   └── bootstrap.js
└── views/
    ├── components/
    │   ├── ui/               ← Componentes UI genéricos
    │   │   ├── button.blade.php
    │   │   ├── card.blade.php
    │   │   ├── badge.blade.php
    │   │   ├── input.blade.php
    │   │   ├── select.blade.php
    │   │   ├── icon.blade.php
    │   │   └── section-header.blade.php
    │   └── animal/           ← Componentes de dominio
    │       ├── info-card.blade.php
    │       ├── photo-card.blade.php
    │       └── stats-badge.blade.php
    ├── layouts/
    │   ├── app.blade.php     ← Layout autenticado
    │   ├── guest.blade.php   ← Layout auth (login, register)
    │   └── public.blade.php  ← Layout público (animal-show) ← NUEVO
    └── ...
```

---

## 3. Paso 1: Dependencias npm

### Verificar lo instalado

Tu `package.json` ya tiene las dependencias core. Solo necesitas verificar e instalar lo faltante:

```bash
# Desde la raíz del proyecto
cd c:\laragon\www\BoviTrack

# Instalar dependencias existentes (si no lo has hecho)
npm install

# Verificar versiones instaladas
npm ls tailwindcss @tailwindcss/forms bootstrap-icons autoprefixer postcss
```

### Dependencias actuales (ya presentes, NO reinstalar)

```json
{
  "devDependencies": {
    "tailwindcss": "^3.1.0",
    "@tailwindcss/forms": "^0.5.2",
    "autoprefixer": "^10.4.2",
    "postcss": "^8.4.31",
    "laravel-vite-plugin": "^2.0.0",
    "vite": "^7.0.7",
    "bootstrap-icons": "^1.13.1",
    "alpinejs": "^3.4.2",
    "bootstrap": "^5.3.8",
    "@popperjs/core": "^2.11.8",
    "axios": "^1.11.0"
  }
}
```

### (Opcional) Agregar plugin de tipografía si necesitas contenido de texto largo:

```bash
npm install -D @tailwindcss/typography
```

> ⚠️ **NOTA sobre `@tailwindcss/vite`**: Tu package.json tiene `@tailwindcss/vite: ^4.0.0` que es para Tailwind v4. Como usas Tailwind v3, **NO lo uses**. La compilación se hace vía PostCSS (que ya tienes configurado).

---

## 4. Paso 2: tailwind.config.js

Reemplazar **completamente** el archivo actual con:

```js
// tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            // ──────────────────────────────────────
            // PALETA DE MARCA BOVITRACK
            // ──────────────────────────────────────
            colors: {
                'bovi-green': {
                    25:  '#f9fdf9',
                    50:  '#f0f7f0',
                    100: '#e8f5e9',
                    200: '#d4edda',
                    300: '#a8d5b8',
                    400: '#6bb380',
                    500: '#4a9960',
                    600: '#3E7C47',
                    700: '#2F6038',
                    800: '#1F4D2B',
                    900: '#163d20',
                    950: '#0F2A17',
                },
                'bovi-brown': {
                    50:  '#faf6f1',
                    100: '#f5f0eb',
                    200: '#e8ddd0',
                    300: '#D4A574',
                    400: '#c4956a',
                    500: '#a07a5a',
                    600: '#8B6B4E',
                    700: '#7a5d44',
                    800: '#6B5440',
                    900: '#5a4636',
                },
                'bovi-beige': {
                    50:  '#f5f0eb',
                    100: '#F4EFE6',
                    200: '#E8DED0',
                    300: '#D4C5B0',
                    400: '#c4b49a',
                },
                'bovi-dark': '#2B2B2B',
            },

            // ──────────────────────────────────────
            // TIPOGRAFÍA
            // ──────────────────────────────────────
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            // ──────────────────────────────────────
            // SOMBRAS PERSONALIZADAS
            // ──────────────────────────────────────
            boxShadow: {
                'bovi':    '0 4px 14px -3px rgba(31, 77, 43, 0.15)',
                'bovi-lg': '0 10px 25px -5px rgba(31, 77, 43, 0.2)',
                'bovi-xl': '0 20px 40px -10px rgba(31, 77, 43, 0.25)',
                '3xl':     '0 35px 60px -15px rgba(0, 0, 0, 0.3)',
            },

            // ──────────────────────────────────────
            // ANIMACIONES
            // ──────────────────────────────────────
            animation: {
                'fade-in':     'fadeIn 0.5s ease-out',
                'fade-in-up':  'fadeInUp 0.5s ease-out',
                'slide-down':  'slideDown 0.3s ease-out',
                'check-bounce': 'checkBounce 0.3s ease-in-out',
                'pulse-slow':  'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%':   { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                fadeInUp: {
                    '0%':   { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideDown: {
                    '0%':   { opacity: '0', transform: 'translateY(-10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                checkBounce: {
                    '0%, 100%': { transform: 'scale(1)' },
                    '50%':      { transform: 'scale(1.2)' },
                },
            },

            // ──────────────────────────────────────
            // GRADIENTES REUTILIZABLES (via bg-gradient-to-*)
            // ──────────────────────────────────────
            backgroundImage: {
                'gradient-bovi-green':  'linear-gradient(to right, #1F4D2B, #3E7C47)',
                'gradient-bovi-brown':  'linear-gradient(to right, #8B6B4E, #6B5440)',
                'gradient-bovi-amber':  'linear-gradient(to right, #d97706, #b45309)',
                'gradient-bovi-green-v': 'linear-gradient(to bottom right, #1F4D2B, #3E7C47)',
                'gradient-bovi-body':   'linear-gradient(to bottom right, #F4EFE6, #E8DED0, #F4EFE6)',
            },
        },
    },

    plugins: [forms],
};
```

### Qué resuelve esto:

| Antes (inline) | Después (clase Tailwind) |
|-----------------|-------------------------|
| `style="background-color: #1F4D2B;"` | `bg-bovi-green-800` |
| `style="color: #3E7C47;"` | `text-bovi-green-600` |
| `style="color: #8B6B4E;"` | `text-bovi-brown-600` |
| `style="background-color: #F4EFE6;"` | `bg-bovi-beige-100` |
| `style="background: linear-gradient(to right, #1F4D2B, #3E7C47);"` | `bg-gradient-bovi-green` |
| `style="color: #2B2B2B;"` | `text-bovi-dark` |

---

## 5. Paso 3: postcss.config.js

Tu archivo actual es correcto. NO necesita cambios:

```js
// postcss.config.js
export default {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
    },
};
```

---

## 6. Paso 4: vite.config.js

Actualizar para soportar múltiples entry points (público + autenticado):

```js
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/public.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],

    // Optimización para producción
    build: {
        // Nombres con hash para cache busting automático
        rollupOptions: {
            output: {
                manualChunks: {
                    // Separar vendor de app code
                    vendor: ['alpinejs', 'axios'],
                },
            },
        },
    },
});
```

### ¿Por qué dos CSS entry points?

- **`app.css`** → Layouts `app.blade.php` y `guest.blade.php` (incluye Bootstrap CSS para componentes admin)
- **`public.css`** → Layout `public.blade.php` (SIN Bootstrap CSS, solo Tailwind + Bootstrap Icons)

Esto evita cargar Bootstrap CSS (~170KB) en páginas públicas que no lo necesitan.

---

## 7. Paso 5: Estructura de CSS con @layer

### 7.1. `resources/css/app.css` — Entry point autenticado

```css
/* ================================================================
   BOVITRACK — App CSS (Layouts autenticados)
   Entry point: resources/css/app.css
   ================================================================ */

/* ── Vendor ─────────────────────────────────────────────────────── */
@import 'bootstrap/dist/css/bootstrap.min.css';
@import 'bootstrap-icons/font/bootstrap-icons.css';

/* ── Tailwind Layers ────────────────────────────────────────────── */
@tailwind base;
@tailwind components;
@tailwind utilities;

/* ── Base Overrides ─────────────────────────────────────────────── */
@import './base/_reset.css';
@import './base/_typography.css';

/* ── Component Classes ──────────────────────────────────────────── */
@import './components/_buttons.css';
@import './components/_cards.css';
@import './components/_forms.css';
@import './components/_badges.css';
@import './components/_navigation.css';
@import './components/_alerts.css';

/* ── Layout-specific ────────────────────────────────────────────── */
@import './layouts/_header.css';
@import './layouts/_footer.css';

/* ── Utilities & Animations ─────────────────────────────────────── */
@import './utilities/_animations.css';
```

### 7.2. `resources/css/public.css` — Entry point público

```css
/* ================================================================
   BOVITRACK — Public CSS (Páginas públicas sin auth)
   Entry point: resources/css/public.css
   Sin Bootstrap CSS (no se necesita), solo iconos
   ================================================================ */

/* ── Vendor ─────────────────────────────────────────────────────── */
@import 'bootstrap-icons/font/bootstrap-icons.css';

/* ── Tailwind Layers ────────────────────────────────────────────── */
@tailwind base;
@tailwind components;
@tailwind utilities;

/* ── Base ───────────────────────────────────────────────────────── */
@import './base/_reset.css';
@import './base/_typography.css';

/* ── Components (solo los necesarios para público) ──────────────── */
@import './components/_buttons.css';
@import './components/_cards.css';
@import './components/_badges.css';

/* ── Utilities ──────────────────────────────────────────────────── */
@import './utilities/_animations.css';
```

### 7.3. `resources/css/base/_reset.css`

```css
/* ================================================================
   Base Layer — Resets & Overrides
   ================================================================ */

@layer base {
    /* Fondo global de marca */
    body {
        @apply bg-bovi-beige-100 text-bovi-dark antialiased;
    }

    /* Override del reset de Tailwind para inputs con @tailwindcss/forms */
    [type='text']:focus,
    [type='email']:focus,
    [type='url']:focus,
    [type='password']:focus,
    [type='number']:focus,
    [type='date']:focus,
    [type='datetime-local']:focus,
    [type='month']:focus,
    [type='search']:focus,
    [type='tel']:focus,
    [type='time']:focus,
    [type='week']:focus,
    textarea:focus,
    select:focus {
        @apply border-bovi-green-600 ring-2 ring-bovi-green-600/20;
    }

    /* Scrollbar personalizado global */
    ::-webkit-scrollbar {
        width: 8px;
    }
    ::-webkit-scrollbar-track {
        @apply bg-bovi-beige-100;
    }
    ::-webkit-scrollbar-thumb {
        @apply bg-bovi-brown-600/30 rounded-full;
    }
    ::-webkit-scrollbar-thumb:hover {
        @apply bg-bovi-brown-600/50;
    }
}
```

### 7.4. `resources/css/base/_typography.css`

```css
/* ================================================================
   Base Layer — Typography
   ================================================================ */

@layer base {
    h1, h2, h3, h4, h5, h6 {
        @apply font-sans text-bovi-dark;
    }

    h1 { @apply text-3xl font-bold; }
    h2 { @apply text-2xl font-bold; }
    h3 { @apply text-xl font-semibold; }
    h4 { @apply text-lg font-semibold; }

    a {
        @apply transition-colors duration-200;
    }
}
```

### 7.5. `resources/css/components/_buttons.css`

```css
/* ================================================================
   Component Layer — Buttons
   Reemplaza TODOS los style="background-color: #1F4D2B;" en botones
   ================================================================ */

@layer components {
    /* ── Botón primario (verde BoviTrack) ─────────────────────────── */
    .btn-bovi-primary {
        @apply inline-flex items-center justify-center gap-2
               px-6 py-2.5 rounded-lg
               bg-bovi-green-800 text-white font-semibold text-sm
               shadow-bovi
               transition-all duration-200 ease-in-out
               hover:bg-bovi-green-600 hover:shadow-bovi-lg
               focus:outline-none focus:ring-2 focus:ring-bovi-green-600 focus:ring-offset-2
               active:bg-bovi-green-900 active:scale-[0.98]
               disabled:opacity-50 disabled:cursor-not-allowed;
    }

    /* ── Botón con gradiente verde ────────────────────────────────── */
    .btn-bovi-gradient {
        @apply inline-flex items-center justify-center gap-2
               px-6 py-2.5 rounded-lg
               bg-gradient-bovi-green text-white font-semibold text-sm
               shadow-bovi
               transition-all duration-200 ease-in-out
               hover:shadow-bovi-lg hover:brightness-110
               focus:outline-none focus:ring-2 focus:ring-bovi-green-600 focus:ring-offset-2
               active:brightness-90 active:scale-[0.98]
               disabled:opacity-50 disabled:cursor-not-allowed;
    }

    /* ── Botón secundario (marrón) ────────────────────────────────── */
    .btn-bovi-secondary {
        @apply inline-flex items-center justify-center gap-2
               px-6 py-2.5 rounded-lg
               bg-bovi-brown-600 text-white font-semibold text-sm
               shadow-sm
               transition-all duration-200 ease-in-out
               hover:bg-bovi-brown-800 hover:shadow-md
               focus:outline-none focus:ring-2 focus:ring-bovi-brown-600 focus:ring-offset-2
               active:bg-bovi-brown-900 active:scale-[0.98]
               disabled:opacity-50 disabled:cursor-not-allowed;
    }

    /* ── Botón con gradiente marrón ───────────────────────────────── */
    .btn-bovi-brown-gradient {
        @apply inline-flex items-center justify-center gap-2
               px-6 py-2.5 rounded-lg
               bg-gradient-bovi-brown text-white font-semibold text-sm
               shadow-sm
               transition-all duration-200 ease-in-out
               hover:shadow-md hover:brightness-110
               focus:outline-none focus:ring-2 focus:ring-bovi-brown-600 focus:ring-offset-2
               active:brightness-90 active:scale-[0.98]
               disabled:opacity-50 disabled:cursor-not-allowed;
    }

    /* ── Botón ámbar (sección imágenes) ───────────────────────────── */
    .btn-bovi-amber {
        @apply inline-flex items-center justify-center gap-2
               px-6 py-2.5 rounded-lg
               bg-gradient-bovi-amber text-white font-semibold text-sm
               shadow-sm
               transition-all duration-200 ease-in-out
               hover:shadow-md hover:brightness-110
               focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2
               active:brightness-90 active:scale-[0.98]
               disabled:opacity-50 disabled:cursor-not-allowed;
    }

    /* ── Botón outline verde ──────────────────────────────────────── */
    .btn-bovi-outline {
        @apply inline-flex items-center justify-center gap-2
               px-6 py-2.5 rounded-lg
               border-2 border-bovi-green-800 text-bovi-green-800
               bg-transparent font-semibold text-sm
               transition-all duration-200 ease-in-out
               hover:bg-bovi-green-800 hover:text-white
               focus:outline-none focus:ring-2 focus:ring-bovi-green-600 focus:ring-offset-2
               active:scale-[0.98]
               disabled:opacity-50 disabled:cursor-not-allowed;
    }

    /* ── Botón danger (eliminar) ──────────────────────────────────── */
    .btn-bovi-danger {
        @apply inline-flex items-center justify-center gap-2
               px-6 py-2.5 rounded-lg
               bg-red-600 text-white font-semibold text-sm
               shadow-sm
               transition-all duration-200 ease-in-out
               hover:bg-red-700 hover:shadow-md
               focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2
               active:bg-red-800 active:scale-[0.98]
               disabled:opacity-50 disabled:cursor-not-allowed;
    }

    /* ── Botón ghost (sin fondo) ──────────────────────────────────── */
    .btn-bovi-ghost {
        @apply inline-flex items-center justify-center gap-2
               px-4 py-2 rounded-lg
               text-bovi-green-800 font-medium text-sm
               transition-all duration-200 ease-in-out
               hover:bg-bovi-green-50 hover:text-bovi-green-600
               focus:outline-none focus:ring-2 focus:ring-bovi-green-600/20
               active:bg-bovi-green-100;
    }

    /* ── Tamaños ──────────────────────────────────────────────────── */
    .btn-sm {
        @apply px-3 py-1.5 text-xs;
    }
    .btn-lg {
        @apply px-8 py-3 text-base;
    }

    /* ── Scroll to top button ─────────────────────────────────────── */
    .btn-scroll-top {
        @apply fixed bottom-6 right-6 z-50
               w-12 h-12 rounded-full
               bg-bovi-green-800 text-white
               flex items-center justify-center
               shadow-bovi-lg
               transition-all duration-300
               hover:bg-bovi-green-600 hover:shadow-bovi-xl hover:-translate-y-1
               focus:outline-none focus:ring-2 focus:ring-bovi-green-600 focus:ring-offset-2;
    }
}
```

### 7.6. `resources/css/components/_cards.css`

```css
/* ================================================================
   Component Layer — Cards
   Reemplaza inline styles en cards, info boxes, section containers
   ================================================================ */

@layer components {
    /* ── Card base ────────────────────────────────────────────────── */
    .card-bovi {
        @apply bg-white rounded-xl shadow-sm border border-bovi-beige-300/50
               overflow-hidden
               transition-shadow duration-200
               hover:shadow-md;
    }

    /* ── Card con fondo beige (estilo del proyecto) ───────────────── */
    .card-bovi-beige {
        @apply bg-bovi-beige-100 rounded-xl
               border border-bovi-beige-300
               overflow-hidden;
    }

    /* ── Sección header con gradiente verde ────────────────────────── */
    .card-header-green {
        @apply bg-gradient-bovi-green text-white
               px-6 py-4 rounded-t-xl;
    }

    /* ── Sección header con gradiente marrón ───────────────────────── */
    .card-header-brown {
        @apply bg-gradient-bovi-brown text-white
               px-6 py-4 rounded-t-xl;
    }

    /* ── Sección header con gradiente ámbar ────────────────────────── */
    .card-header-amber {
        @apply bg-gradient-bovi-amber text-white
               px-6 py-4 rounded-t-xl;
    }

    /* ── Info box verde (NFC, datos verificados) ───────────────────── */
    .info-box-green {
        @apply bg-bovi-green-50 border-l-4 border-bovi-green-800
               rounded-r-lg p-4;
    }

    /* ── Info box marrón ───────────────────────────────────────────── */
    .info-box-brown {
        @apply bg-bovi-brown-50 border-l-4 border-bovi-brown-600
               rounded-r-lg p-4;
    }

    /* ── Info box ámbar (observaciones) ────────────────────────────── */
    .info-box-amber {
        @apply bg-amber-50 border-l-4 border-amber-600
               rounded-r-lg p-4;
    }

    /* ── Card pública info item ────────────────────────────────────── */
    .card-info-item {
        @apply bg-bovi-beige-100 border border-bovi-beige-300
               rounded-xl p-4
               transition-all duration-200
               hover:shadow-sm hover:border-bovi-beige-400;
    }

    /* ── Card stat (dashboard) ────────────────────────────────────── */
    .card-stat {
        @apply bg-white rounded-xl p-6
               border-t-4 border-bovi-green-800
               shadow-sm
               transition-all duration-200
               hover:shadow-md hover:-translate-y-0.5;
    }

    /* ── Card foto con borde coloreado ────────────────────────────── */
    .card-photo-amber {
        @apply rounded-xl overflow-hidden
               bg-gradient-to-br from-amber-50 to-orange-50
               border-2 border-amber-600
               shadow-sm;
    }

    .card-photo-green {
        @apply rounded-xl overflow-hidden
               bg-gradient-to-br from-bovi-green-100 to-bovi-green-200
               border-2 border-bovi-green-600
               shadow-sm;
    }

    /* ── Hero card (show animal) ───────────────────────────────────── */
    .card-hero {
        @apply bg-gradient-bovi-green-v text-white
               rounded-2xl p-8
               shadow-bovi-lg;
    }
}
```

### 7.7. `resources/css/components/_forms.css`

```css
/* ================================================================
   Component Layer — Forms
   Reemplaza style="outline: none;" + onfocus/onblur en inputs
   ================================================================ */

@layer components {
    /* ── Input estándar BoviTrack ──────────────────────────────────── */
    .input-bovi {
        @apply w-full rounded-lg border border-gray-300
               bg-white px-4 py-2.5
               text-sm text-bovi-dark
               placeholder:text-gray-400
               transition-all duration-200
               focus:border-bovi-green-600 focus:ring-2 focus:ring-bovi-green-600/20
               focus:outline-none;
    }

    /* ── Select estándar ──────────────────────────────────────────── */
    .select-bovi {
        @apply w-full rounded-lg border border-gray-300
               bg-white px-4 py-2.5
               text-sm text-bovi-dark
               transition-all duration-200
               focus:border-bovi-green-600 focus:ring-2 focus:ring-bovi-green-600/20
               focus:outline-none;
    }

    /* ── Textarea ─────────────────────────────────────────────────── */
    .textarea-bovi {
        @apply w-full rounded-lg border border-gray-300
               bg-white px-4 py-3
               text-sm text-bovi-dark
               placeholder:text-gray-400
               resize-y min-h-[100px]
               transition-all duration-200
               focus:border-bovi-green-600 focus:ring-2 focus:ring-bovi-green-600/20
               focus:outline-none;
    }

    /* ── File input personalizado ─────────────────────────────────── */
    .file-input-bovi {
        @apply w-full text-sm text-gray-500
               file:mr-4 file:py-2 file:px-4
               file:rounded-lg file:border-0 file:cursor-pointer
               file:text-sm file:font-medium
               file:bg-gradient-bovi-amber file:text-white
               hover:file:brightness-110
               focus:outline-none;
    }

    /* ── Label ────────────────────────────────────────────────────── */
    .label-bovi {
        @apply block text-sm font-semibold text-bovi-brown-600 mb-1.5;
    }

    /* ── Input con variante danger (delete account) ───────────────── */
    .input-bovi-danger {
        @apply w-full rounded-lg border border-gray-300
               bg-white px-4 py-2.5
               text-sm text-bovi-dark
               transition-all duration-200
               focus:border-red-500 focus:ring-2 focus:ring-red-500/20
               focus:outline-none;
    }

    /* ── Form group (label + input + error) ───────────────────────── */
    .form-group {
        @apply space-y-1.5;
    }

    /* ── Checkbox personalizado ────────────────────────────────────── */
    .checkbox-bovi {
        @apply rounded border-gray-300
               text-bovi-green-800
               shadow-sm
               focus:ring-bovi-green-600/20 focus:ring-offset-0
               checked:animate-check-bounce;
    }

    /* ── Legend/Fieldset info box ──────────────────────────────────── */
    .fieldset-legend {
        @apply bg-bovi-green-50 border-l-4 border-bovi-green-800
               rounded-r-lg px-4 py-2
               text-sm font-medium text-bovi-green-800;
    }
}
```

### 7.8. `resources/css/components/_badges.css`

```css
/* ================================================================
   Component Layer — Badges
   ================================================================ */

@layer components {
    .badge-base {
        @apply inline-flex items-center gap-1.5
               px-3 py-1 rounded-full
               text-xs font-semibold
               transition-colors duration-200;
    }

    .badge-green {
        @apply badge-base bg-bovi-green-600 text-white;
    }

    .badge-brown {
        @apply badge-base bg-bovi-brown-600 text-white;
    }

    .badge-amber {
        @apply badge-base bg-amber-600 text-white;
    }

    .badge-light-green {
        @apply badge-base bg-bovi-green-100 text-bovi-green-800
               border border-bovi-green-600;
    }

    .badge-outline {
        @apply badge-base bg-white/20 text-white backdrop-blur-sm;
    }

    /* ── Badge de sexo (macho/hembra) ─────────────────────────────── */
    .badge-macho {
        @apply badge-base bg-bovi-green-600 text-white;
    }

    .badge-hembra {
        @apply badge-base bg-bovi-brown-300 text-bovi-brown-800;
    }

    /* ── Badge de estado NFC ──────────────────────────────────────── */
    .badge-nfc {
        @apply inline-flex items-center gap-2
               bg-bovi-green-50 border border-bovi-green-600
               rounded-full px-4 py-1.5
               text-sm font-medium text-bovi-green-800;
    }

    /* ── Badge de stats (navigation) ──────────────────────────────── */
    .badge-stats {
        @apply inline-flex items-center gap-1.5
               bg-gradient-to-r from-bovi-green-50 to-bovi-green-25
               border border-bovi-green-600
               rounded-full px-3 py-1
               text-xs font-bold text-bovi-green-800;
    }
}
```

### 7.9. `resources/css/components/_navigation.css`

```css
/* ================================================================
   Component Layer — Navigation
   Reemplaza inline styles en navigation.blade.php
   ================================================================ */

@layer components {
    /* ── Brand logo glow effect ───────────────────────────────────── */
    .nav-logo-glow {
        @apply absolute inset-0 rounded-full opacity-0
               bg-bovi-green-600
               transition-opacity duration-300
               group-hover:opacity-20;
    }

    /* ── Brand title gradient ─────────────────────────────────────── */
    .nav-brand-text {
        background: linear-gradient(to right, #1F4D2B, #3E7C47);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        @apply text-xl font-extrabold tracking-tight;
    }

    /* ── Nav link activo ──────────────────────────────────────────── */
    .nav-link-active {
        @apply border-b-2 border-bovi-green-800
               text-bovi-green-800 font-semibold;
    }

    /* ── Nav link inactivo ────────────────────────────────────────── */
    .nav-link-inactive {
        @apply border-b-2 border-transparent
               text-gray-500
               hover:text-bovi-green-700 hover:border-bovi-green-200
               transition-colors duration-200;
    }

    /* ── Nav mobile link activo ──────────────────────────────────── */
    .nav-mobile-active {
        @apply block w-full pl-3 pr-4 py-2 text-left text-base font-medium
               bg-bovi-green-800 text-white
               border-l-4 border-bovi-green-600
               rounded-r-lg;
    }

    /* ── Avatar circle ────────────────────────────────────────────── */
    .avatar-bovi {
        @apply w-9 h-9 rounded-full
               bg-gradient-bovi-green-v
               flex items-center justify-center
               text-white text-sm font-bold;
    }

    .avatar-bovi-lg {
        @apply w-12 h-12 rounded-full
               bg-gradient-bovi-green-v
               flex items-center justify-center
               text-white text-base font-bold;
    }

    /* ── Dropdown button focus ────────────────────────────────────── */
    .nav-dropdown-trigger {
        @apply inline-flex items-center gap-2
               px-3 py-2 rounded-lg
               text-sm text-gray-600
               transition-all duration-200
               hover:text-bovi-green-800
               focus:outline-none focus:ring-2 focus:ring-bovi-green-600/30;
    }
}
```

### 7.10. `resources/css/components/_alerts.css`

```css
/* ================================================================
   Component Layer — Alerts
   ================================================================ */

@layer components {
    .alert-success {
        @apply bg-bovi-green-100 border border-bovi-green-600
               text-bovi-green-800 rounded-xl p-4
               flex items-center gap-3;
    }

    .alert-danger {
        @apply bg-red-50 border border-red-500
               text-red-700 rounded-xl p-4
               flex items-center gap-3;
    }

    .alert-warning {
        @apply bg-amber-50 border border-amber-400
               text-amber-800 rounded-xl p-4
               flex items-center gap-3;
    }

    .alert-info {
        @apply bg-blue-50 border border-blue-400
               text-blue-700 rounded-xl p-4
               flex items-center gap-3;
    }
}
```

### 7.11. `resources/css/layouts/_header.css`

```css
/* ================================================================
   Layout — Header / Navbar
   ================================================================ */

@layer components {
    .header-bovi {
        @apply bg-white border-b border-bovi-beige-300/80
               shadow-sm sticky top-0 z-40;
    }
}
```

### 7.12. `resources/css/layouts/_footer.css`

```css
/* ================================================================
   Layout — Footer
   ================================================================ */

@layer components {
    .footer-bovi {
        @apply bg-bovi-green-950 text-bovi-green-200;
    }

    .footer-link {
        @apply text-bovi-green-200/80
               hover:text-white
               transition-colors duration-200;
    }

    .footer-badge {
        @apply inline-flex items-center gap-2
               bg-white/20 backdrop-blur-sm
               rounded-full px-4 py-1.5
               text-sm;
    }
}
```

### 7.13. `resources/css/utilities/_animations.css`

```css
/* ================================================================
   Utilities — Animations & Keyframes
   (Las animaciones de tailwind.config.js cubren la mayoría,
    aquí van las más complejas como el checkmark de éxito)
   ================================================================ */

@layer utilities {
    /* ── Auth container animation ─────────────────────────────────── */
    .auth-container {
        @apply animate-fade-in-up;
    }
}

/* ── Success Checkmark Animation (dashboard) ──────────────────────── */
/* Estas animaciones son demasiado complejas para @apply,
   se mantienen como CSS puro */

.success-checkmark {
    width: 80px;
    height: 80px;
    margin: 0 auto;
}

.success-checkmark .check-icon {
    width: 80px;
    height: 80px;
    position: relative;
    border-radius: 50%;
    box-sizing: content-box;
    border: 4px solid #10b981;
}

.success-checkmark .check-icon::before {
    top: 3px;
    left: -2px;
    width: 30px;
    transform-origin: 100% 50%;
    border-radius: 100px 0 0 100px;
}

.success-checkmark .check-icon::after {
    top: 0;
    left: 30px;
    width: 60px;
    transform-origin: 0 50%;
    border-radius: 0 100px 100px 0;
    animation: rotate-circle 4.25s ease-in;
}

.success-checkmark .check-icon::before,
.success-checkmark .check-icon::after {
    content: '';
    height: 100px;
    position: absolute;
    background: #ffffff;
    transform: rotate(-45deg);
}

.success-checkmark .check-icon .icon-line {
    height: 5px;
    position: absolute;
    border-radius: 2px;
    display: block;
    @apply bg-emerald-500;
}

.success-checkmark .check-icon .icon-line.line-tip {
    top: 46px;
    left: 14px;
    width: 25px;
    transform: rotate(45deg);
    animation: icon-line-tip 0.75s;
}

.success-checkmark .check-icon .icon-line.line-long {
    top: 38px;
    left: 28px;
    width: 47px;
    transform: rotate(-45deg);
    animation: icon-line-long 0.75s;
}

@keyframes rotate-circle {
    0%   { transform: rotate(-45deg); }
    5%   { transform: rotate(-45deg); }
    12%  { transform: rotate(-405deg); }
    100% { transform: rotate(-405deg); }
}

@keyframes icon-line-tip {
    0%   { width: 0; left: 1px; top: 19px; }
    54%  { width: 0; left: 1px; top: 19px; }
    70%  { width: 50px; left: -8px; top: 37px; }
    84%  { width: 17px; left: 21px; top: 48px; }
    100% { width: 25px; left: 14px; top: 46px; }
}

@keyframes icon-line-long {
    0%   { width: 0; right: 46px; top: 54px; }
    65%  { width: 0; right: 46px; top: 54px; }
    84%  { width: 55px; right: 0; top: 35px; }
    100% { width: 47px; right: 8px; top: 38px; }
}
```

---

## 8. Paso 6: Integración de Bootstrap Icons vía npm

Ya tienes `bootstrap-icons` instalado en `package.json`. La integración se hace en el CSS:

```css
/* Ya incluido en app.css y public.css */
@import 'bootstrap-icons/font/bootstrap-icons.css';
```

### Uso en Blade:

```html
<!-- Directo -->
<i class="bi bi-info-circle text-bovi-green-800"></i>

<!-- Via componente (recomendado) -->
<x-ui.icon name="info-circle" class="text-bovi-green-800" />
```

### Verificar la copia de fuentes

Vite maneja automáticamente los archivos de fuentes referenciados en el CSS de Bootstrap Icons. En producción, ejecutar `npm run build` los copiará al directorio `public/build/assets/`.

> ⚠️ Si las fuentes no cargan en dev, verificar que `npm run dev` esté corriendo.

---

## 9. Paso 7: Layouts Blade

### 9.1. Nuevo layout público — `resources/views/layouts/public.blade.php`

```blade
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'BoviTrack' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700" rel="stylesheet" />

    <!-- Styles & Scripts via Vite (public.css, NO Bootstrap CSS) -->
    @vite(['resources/css/public.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-bovi-body font-sans antialiased">

    {{ $slot }}

</body>
</html>
```

### 9.2. Actualización de `layouts/app.blade.php`

Asegurar que use `@vite` correctamente (ya lo hace) y eliminar `<style>` blocks:

```blade
{{-- En el <head> --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])

{{-- Eliminar el bloque <style> con animaciones slideDown/fadeIn --}}
{{-- Ahora usan clases: animate-slide-down, animate-fade-in --}}
```

### 9.3. Actualización de `layouts/guest.blade.php`

Mismo patrón — asegurar `@vite` y eliminar estilos inline.

---

## 10. Paso 8: Componentes Blade Reutilizables

### 10.1. `resources/views/components/ui/button.blade.php`

```blade
@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'icon' => null,
])

@php
    $variants = [
        'primary'        => 'btn-bovi-primary',
        'gradient'       => 'btn-bovi-gradient',
        'secondary'      => 'btn-bovi-secondary',
        'brown-gradient' => 'btn-bovi-brown-gradient',
        'amber'          => 'btn-bovi-amber',
        'outline'        => 'btn-bovi-outline',
        'danger'         => 'btn-bovi-danger',
        'ghost'          => 'btn-bovi-ghost',
    ];

    $sizes = [
        'sm' => 'btn-sm',
        'md' => '',
        'lg' => 'btn-lg',
    ];

    $classes = ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? '');
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)<i class="bi bi-{{ $icon }}"></i>@endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)<i class="bi bi-{{ $icon }}"></i>@endif
        {{ $slot }}
    </button>
@endif
```

**Uso:**
```blade
<x-ui.button variant="primary" icon="plus-lg">Registrar Animal</x-ui.button>
<x-ui.button variant="secondary" href="/animals">Ver Todos</x-ui.button>
<x-ui.button variant="danger" icon="trash">Eliminar</x-ui.button>
<x-ui.button variant="gradient" type="submit">Guardar</x-ui.button>
```

### 10.2. `resources/views/components/ui/card.blade.php`

```blade
@props([
    'variant' => 'default',
    'padding' => true,
])

@php
    $variants = [
        'default' => 'card-bovi',
        'beige'   => 'card-bovi-beige',
        'stat'    => 'card-stat',
        'hero'    => 'card-hero',
    ];
    $classes = $variants[$variant] ?? $variants['default'];
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @isset($header)
        {{ $header }}
    @endisset

    @if($padding)
        <div class="p-6">
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif

    @isset($footer)
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $footer }}
        </div>
    @endisset
</div>
```

**Uso:**
```blade
<x-ui.card>
    <x-slot:header>
        <div class="card-header-green">
            <h3 class="text-lg font-bold">Información Básica</h3>
        </div>
    </x-slot:header>

    <p>Contenido de la card...</p>
</x-ui.card>

<x-ui.card variant="hero">
    <h1 class="text-3xl font-bold">{{ $animal->nombre }}</h1>
</x-ui.card>
```

### 10.3. `resources/views/components/ui/badge.blade.php`

```blade
@props([
    'variant' => 'green',
    'icon' => null,
])

@php
    $variants = [
        'green'       => 'badge-green',
        'brown'       => 'badge-brown',
        'amber'       => 'badge-amber',
        'light-green' => 'badge-light-green',
        'outline'     => 'badge-outline',
        'nfc'         => 'badge-nfc',
        'stats'       => 'badge-stats',
        'macho'       => 'badge-macho',
        'hembra'      => 'badge-hembra',
    ];
    $classes = $variants[$variant] ?? $variants['green'];
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)<i class="bi bi-{{ $icon }}"></i>@endif
    {{ $slot }}
</span>
```

**Uso:**
```blade
<x-ui.badge variant="macho" icon="gender-male">Macho</x-ui.badge>
<x-ui.badge variant="nfc" icon="upc-scan">{{ $animal->codigo_nfc }}</x-ui.badge>
<x-ui.badge variant="stats">{{ $totalAnimals }} animales</x-ui.badge>
```

### 10.4. `resources/views/components/ui/input.blade.php`

```blade
@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'variant' => 'default',
])

@php
    $inputClass = match($variant) {
        'danger' => 'input-bovi-danger',
        default  => 'input-bovi',
    };
@endphp

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="label-bovi">{{ $label }}</label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->merge(['class' => $inputClass]) }}
    />

    @if($name)
        <x-input-error :messages="$errors->get($name)" class="mt-1" />
    @endif
</div>
```

**Uso:**
```blade
<x-ui.input label="Nombre del Animal" name="nombre" placeholder="Ej: Luna" />
<x-ui.input label="Código NFC" name="codigo_nfc" type="text" />
<x-ui.input name="password_confirmation" type="password" variant="danger" />
```

### 10.5. `resources/views/components/ui/select.blade.php`

```blade
@props([
    'label' => null,
    'name' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Seleccionar...',
])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="label-bovi">{{ $label }}</label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->merge(['class' => 'select-bovi']) }}
    >
        <option value="">{{ $placeholder }}</option>
        @foreach($options as $value => $text)
            <option value="{{ $value }}" @selected(old($name, $selected) == $value)>
                {{ $text }}
            </option>
        @endforeach
    </select>

    @if($name)
        <x-input-error :messages="$errors->get($name)" class="mt-1" />
    @endif
</div>
```

### 10.6. `resources/views/components/ui/icon.blade.php`

```blade
@props([
    'name',
    'size' => 'base',
])

@php
    $sizes = [
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'base' => 'text-base',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        '2xl' => 'text-2xl',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['base'];
@endphp

<i {{ $attributes->merge(['class' => "bi bi-{$name} {$sizeClass}"]) }}></i>
```

**Uso:**
```blade
<x-ui.icon name="info-circle" class="text-bovi-green-800" />
<x-ui.icon name="camera" size="xl" class="text-amber-600" />
```

### 10.7. `resources/views/components/ui/section-header.blade.php`

```blade
@props([
    'variant' => 'green',
    'icon' => null,
])

@php
    $variants = [
        'green' => 'card-header-green',
        'brown' => 'card-header-brown',
        'amber' => 'card-header-amber',
    ];
    $classes = $variants[$variant] ?? $variants['green'];
@endphp

<div {{ $attributes->merge(['class' => $classes . ' flex items-center gap-3']) }}>
    @if($icon)<i class="bi bi-{{ $icon }} text-lg"></i>@endif
    <h3 class="text-lg font-bold">{{ $slot }}</h3>
</div>
```

**Uso:**
```blade
<x-ui.section-header icon="info-circle">Información Básica</x-ui.section-header>
<x-ui.section-header variant="brown" icon="journal-text">Observaciones</x-ui.section-header>
<x-ui.section-header variant="amber" icon="camera">Galería</x-ui.section-header>
```

### 10.8. `resources/views/components/animal/info-card.blade.php`

```blade
@props([
    'icon',
    'label',
    'value',
    'color' => 'green',
])

@php
    $iconColors = [
        'green' => 'text-bovi-green-800',
        'brown' => 'text-bovi-brown-600',
        'amber' => 'text-amber-600',
    ];
    $iconColor = $iconColors[$color] ?? $iconColors['green'];
@endphp

<div class="card-info-item">
    <div class="flex items-start gap-3">
        <div class="flex-shrink-0 mt-0.5">
            <i class="bi bi-{{ $icon }} {{ $iconColor }} text-lg"></i>
        </div>
        <div class="min-w-0 flex-1">
            <p class="text-xs font-medium text-bovi-brown-600 uppercase tracking-wider">
                {{ $label }}
            </p>
            <p class="text-sm font-semibold text-bovi-dark mt-0.5">
                {{ $value ?? $slot }}
            </p>
        </div>
    </div>
</div>
```

**Uso:**
```blade
<x-animal.info-card icon="tag" label="Nombre" :value="$animal->nombre" />
<x-animal.info-card icon="clipboard-data" label="Raza" :value="$animal->raza" />
<x-animal.info-card icon="gender-ambiguous" label="Sexo" :value="$animal->sexo" />
```

---

## 11. Paso 9: Migración de Estilos Inline

### Tabla de conversión rápida

Esta es la referencia para reemplazar cada `style="..."` por clases Tailwind o clases de componentes:

#### Colores de fondo

| Inline | Clase Tailwind |
|--------|---------------|
| `style="background-color: #1F4D2B;"` | `bg-bovi-green-800` |
| `style="background-color: #3E7C47;"` | `bg-bovi-green-600` |
| `style="background-color: #0F2A17;"` | `bg-bovi-green-950` |
| `style="background-color: #8B6B4E;"` | `bg-bovi-brown-600` |
| `style="background-color: #F4EFE6;"` | `bg-bovi-beige-100` |
| `style="background-color: #f0f7f0;"` | `bg-bovi-green-50` |
| `style="background-color: #e8f5e9;"` | `bg-bovi-green-100` |
| `style="background-color: #f5f0eb;"` | `bg-bovi-beige-50` |
| `style="background-color: #d97706;"` | `bg-amber-600` |

#### Colores de texto

| Inline | Clase Tailwind |
|--------|---------------|
| `style="color: #1F4D2B;"` | `text-bovi-green-800` |
| `style="color: #3E7C47;"` | `text-bovi-green-600` |
| `style="color: #2F6038;"` | `text-bovi-green-700` |
| `style="color: #8B6B4E;"` | `text-bovi-brown-600` |
| `style="color: #6B5440;"` | `text-bovi-brown-800` |
| `style="color: #2B2B2B;"` | `text-bovi-dark` |
| `style="color: #e8f5e9;"` | `text-bovi-green-100` |
| `style="color: #d4edda;"` | `text-bovi-green-200` |
| `style="color: #92400e;"` | `text-amber-800` |

#### Gradientes

| Inline | Clase Tailwind |
|--------|---------------|
| `style="background: linear-gradient(to right, #1F4D2B, #3E7C47);"` | `bg-gradient-bovi-green` |
| `style="background: linear-gradient(to right, #8B6B4E, #6B5440);"` | `bg-gradient-bovi-brown` |
| `style="background: linear-gradient(to right, #d97706, #b45309);"` | `bg-gradient-bovi-amber` |
| `style="background: linear-gradient(to bottom right, #1F4D2B, #3E7C47);"` | `bg-gradient-bovi-green-v` |
| `style="background: linear-gradient(to bottom right, #F4EFE6, #E8DED0, #F4EFE6);"` | `bg-gradient-bovi-body` |
| `style="background: linear-gradient(to right, #f0f7f0, #f9fdf9);"` | `bg-gradient-to-r from-bovi-green-50 to-bovi-green-25` |
| `style="background: linear-gradient(to right, #3E7C47, #2F6038);"` | `bg-gradient-to-r from-bovi-green-600 to-bovi-green-700` |

#### Bordes

| Inline | Clase Tailwind |
|--------|---------------|
| `style="border-left-color: #1F4D2B;"` | `border-l-bovi-green-800` |
| `style="border-left-color: #8B6B4E;"` | `border-l-bovi-brown-600` |
| `style="border-top-color: #1F4D2B;"` | `border-t-bovi-green-800` |
| `style="border-color: #D4C5B0;"` | `border-bovi-beige-300` |
| `style="border-color: #3E7C47;"` | `border-bovi-green-600` |

#### Focus/Hover (eliminar JS inline)

| Inline JS | Clase Tailwind |
|-----------|---------------|
| `onfocus="this.style.boxShadow='0 0 0 2px #3E7C47'"` | `focus:ring-2 focus:ring-bovi-green-600` |
| `onblur="this.style.boxShadow='none'"` | (automático con focus:ring) |
| `onmouseover="this.style.backgroundColor='#3E7C47'"` | `hover:bg-bovi-green-600` |
| `onmouseout="this.style.backgroundColor='#1F4D2B'"` | (restore automático con hover:) |
| `onmouseover="this.style.color='#3E7C47'"` | `hover:text-bovi-green-600` |
| `style="outline: none;"` | `focus:outline-none` (ya manejado en `.input-bovi`) |

#### Otros

| Inline | Clase Tailwind |
|--------|---------------|
| `style="background-color: rgba(255,255,255,0.2); backdrop-filter: blur(8px);"` | `bg-white/20 backdrop-blur-sm` |
| `style="background-color: rgba(255, 255, 255, 0.2);"` | `bg-white/20` |
| `style="height: 64px !important; width: 64px !important;"` | `!h-16 !w-16` |

### Estrategia de migración por archivo

1. **Empieza por `animal-show.blade.php`** — es standalone, máximo impacto
2. **Sigue con `layouts/navigation.blade.php`** — componente global
3. **Luego `layouts/app.blade.php`** — layout global
4. **Después vistas admin** (`create`, `edit`, `show`) — mayor cantidad de inline styles
5. **Auth views** — relativamente simples
6. **Dashboard** — el más complejo por las animaciones
7. **Profile views** — similar a admin

---

## 12. Paso 10: Migrar animal-show.blade.php al sistema Vite

### Antes (standalone con CDN):

```html
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script>tailwind.config = { ... }</script>
```

### Después (usando layout público):

```blade
<x-layouts.public title="{{ $animal->nombre ?? $animal->codigo_nfc }} - BoviTrack">

    <div class="max-w-2xl mx-auto py-6 px-4 sm:py-10 sm:px-6">

        {{-- Header --}}
        <div class="mb-8 text-center">
            ...logo y título usando clases Tailwind compiladas...
        </div>

        {{-- Info Cards usando componentes --}}
        <x-ui.card>
            <x-slot:header>
                <x-ui.section-header icon="info-circle">Información Básica</x-ui.section-header>
            </x-slot:header>

            <div class="grid grid-cols-2 gap-4">
                <x-animal.info-card icon="tag" label="Nombre" :value="$animal->nombre" />
                <x-animal.info-card icon="clipboard-data" label="Raza" :value="$animal->raza" />
            </div>
        </x-ui.card>

    </div>

</x-layouts.public>
```

> Esto elimina el CDN de Tailwind (~300KB sin comprimir) y usa el CSS compilado con tree-shaking.

---

## 13. Paso 11: Build para Producción

### Comandos de desarrollo

```bash
# Iniciar servidor de desarrollo con HMR (Hot Module Replacement)
npm run dev

# En otra terminal, iniciar Laravel
php artisan serve
```

### Build para producción

```bash
# Compilar y optimizar TODOS los assets
npm run build
```

### Qué hace `npm run build`:

1. **Tree-shaking de Tailwind** → Solo incluye clases usadas en tus vistas
2. **Minificación CSS** → Comprime el output
3. **Autoprefixer** → Agrega prefijos vendor automáticamente
4. **Hash en filenames** → Cache busting automático (`app-[hash].css`)
5. **Manifiesto** → `public/build/manifest.json` para `@vite()`

### Verificar el output:

```bash
# Ver tamaño de los archivos generados
dir public\build\assets\*.css
dir public\build\assets\*.js
```

### Tamaños esperados (aproximados):

| Archivo | Dev | Producción |
|---------|-----|------------|
| `app.css` (con Bootstrap) | ~300KB | ~40-60KB (gzip ~8-12KB) |
| `public.css` (sin Bootstrap) | ~50KB | ~8-15KB (gzip ~3-5KB) |
| `app.js` | ~200KB | ~40-50KB (gzip ~12-15KB) |

### Script de producción completo:

```bash
# Limpiar cache + build
php artisan cache:clear
php artisan view:clear
php artisan config:clear
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 14. Paso 12: Verificación y Testing

### Checklist visual

```bash
# 1. Ejecutar dev server
npm run dev

# 2. Verificar en el navegador:
#    - No hay peticiones a cdn.tailwindcss.com (Network tab)
#    - No hay peticiones a cdn.jsdelivr.net
#    - Los estilos cargan correctamente
#    - Hover/focus funciona sin JS inline
#    - Bootstrap Icons renderizan correctamente
#    - Animaciones funcionan
```

### Verificar tree-shaking

```bash
# Build de producción
npm run build

# Verificar que NO hay clases no usadas
# El CSS de producción debería ser significativamente menor al de desarrollo
```

### Buscar estilos inline residuales

```bash
# Buscar style= en archivos blade (debería dar 0 resultados al terminar)
findstr /s /i "style=" resources\views\*.blade.php

# Buscar onmouseover/onfocus inline (debería dar 0 resultados)
findstr /s /i "onmouseover\|onfocus\|onmouseout\|onblur" resources\views\*.blade.php
```

---

## 15. Estructura Final del Proyecto

```
resources/
├── css/
│   ├── app.css                    ← Entry point (layouts autenticados)
│   ├── public.css                 ← Entry point (layout público)
│   ├── base/
│   │   ├── _reset.css             ← Body bg, focus overrides, scrollbar
│   │   └── _typography.css        ← Headings, links
│   ├── components/
│   │   ├── _buttons.css           ← 8 variantes de botón
│   │   ├── _cards.css             ← 10 variantes de card
│   │   ├── _forms.css             ← Input, select, textarea, file, checkbox
│   │   ├── _badges.css            ← 9 variantes de badge
│   │   ├── _navigation.css        ← Brand, nav links, avatar, dropdown
│   │   └── _alerts.css            ← 4 variantes de alerta
│   ├── layouts/
│   │   ├── _header.css            ← Sticky header
│   │   └── _footer.css            ← Footer dark, links, badge
│   └── utilities/
│       └── _animations.css        ← Auth anim, success checkmark
├── js/
│   ├── app.js                     ← Bootstrap JS + Alpine
│   └── bootstrap.js               ← Axios config
└── views/
    ├── components/
    │   ├── ui/                    ← 7 componentes genéricos
    │   │   ├── button.blade.php
    │   │   ├── card.blade.php
    │   │   ├── badge.blade.php
    │   │   ├── input.blade.php
    │   │   ├── select.blade.php
    │   │   ├── icon.blade.php
    │   │   └── section-header.blade.php
    │   ├── animal/                ← 1 componente de dominio
    │   │   └── info-card.blade.php
    │   ├── application-logo.blade.php    ← Existente
    │   ├── auth-session-status.blade.php ← Existente
    │   ├── ... (13 componentes Breeze existentes)
    │   └── text-input.blade.php          ← Existente
    ├── layouts/
    │   ├── app.blade.php          ← Existente (sin <style> blocks)
    │   ├── guest.blade.php        ← Existente (sin <style> blocks)
    │   ├── navigation.blade.php   ← Existente (sin inline styles)
    │   └── public.blade.php       ← NUEVO (para animal-show)
    ├── admin/
    │   ├── create.blade.php       ← Sin inline styles
    │   ├── edit.blade.php         ← Sin inline styles
    │   └── show.blade.php         ← Sin inline styles
    ├── public/
    │   └── animal-show.blade.php  ← Usa layout public, sin CDN
    └── ...
```

---

## 16. Checklist de Migración

### Fase 1: Infraestructura (30 min)
- [ ] Actualizar `tailwind.config.js` con paleta BoviTrack
- [ ] Actualizar `vite.config.js` con entry point `public.css`
- [ ] Crear estructura de directorios CSS (`base/`, `components/`, `layouts/`, `utilities/`)
- [ ] Crear todos los archivos CSS parciales (`_buttons.css`, `_cards.css`, etc.)
- [ ] Actualizar `resources/css/app.css` con imports
- [ ] Crear `resources/css/public.css`
- [ ] Verificar `npm run dev` compila sin errores

### Fase 2: Componentes Blade (45 min)
- [ ] Crear directorio `views/components/ui/`
- [ ] Crear directorio `views/components/animal/`
- [ ] Crear `button.blade.php`
- [ ] Crear `card.blade.php`
- [ ] Crear `badge.blade.php`
- [ ] Crear `input.blade.php`
- [ ] Crear `select.blade.php`
- [ ] Crear `icon.blade.php`
- [ ] Crear `section-header.blade.php`
- [ ] Crear `animal/info-card.blade.php`
- [ ] Crear `layouts/public.blade.php`

### Fase 3: Migración de vistas (2-3 horas)
- [ ] Migrar `animal-show.blade.php` (eliminar CDN, usar layout público)
- [ ] Migrar `layouts/navigation.blade.php` (eliminar inline styles)
- [ ] Migrar `layouts/app.blade.php` (eliminar `<style>` block)
- [ ] Migrar `layouts/guest.blade.php`
- [ ] Migrar `admin/create.blade.php`
- [ ] Migrar `admin/edit.blade.php`
- [ ] Migrar `admin/show.blade.php`
- [ ] Migrar `dashboard.blade.php` (mover `<style>` a `_animations.css`)
- [ ] Migrar vistas de auth (`login`, `forgot-password`, etc.)
- [ ] Migrar vistas de profile
- [ ] Actualizar componentes Breeze existentes (cambiar `indigo` → `bovi-green`)

### Fase 4: Verificación (30 min)
- [ ] `npm run dev` — verificar todas las páginas visualmente
- [ ] Verificar Bootstrap Icons cargan correctamente
- [ ] Verificar hover/focus funciona sin JS inline
- [ ] `npm run build` — verificar build de producción
- [ ] Buscar `style=` residual con `findstr`
- [ ] Verificar Network tab: 0 peticiones CDN
- [ ] Verificar tamaños de output
- [ ] Test con `php artisan test`

---

## Notas Importantes

### ⚠️ Sobre Bootstrap CSS + Tailwind

Tu proyecto usa ambos frameworks. Esto genera ~170KB extra y posibles conflictos. La recomendación a futuro es:

1. **Corto plazo**: Mantener ambos (como está ahora) pero solo en `app.css`
2. **Medio plazo**: Identificar qué componentes Bootstrap se usan y reemplazarlos con Tailwind
3. **Largo plazo**: Eliminar Bootstrap CSS completamente, mantener solo Bootstrap Icons

### ⚠️ Sobre `@tailwindcss/vite` en package.json

Tu `package.json` incluye `@tailwindcss/vite: ^4.0.0` que es para **Tailwind v4**. Como usas **Tailwind v3**, este paquete no es necesario y no debe importarse en `vite.config.js`. La compilación se maneja vía PostCSS (que ya tienes configurado).

Si quieres limpiar:

```bash
npm uninstall @tailwindcss/vite
```

### ⚠️ Sobre los componentes Breeze existentes

Los 13 componentes en `views/components/` (de Laravel Breeze) usan `indigo` como color de focus. Deberías actualizarlos para usar `bovi-green`:

```blade
{{-- Antes (primary-button.blade.php) --}}
focus:ring-indigo-500

{{-- Después --}}
focus:ring-bovi-green-600
```

Archivos a actualizar:
- `nav-link.blade.php` → `border-indigo-400` → `border-bovi-green-600`
- `primary-button.blade.php` → `bg-gray-800` → `bg-bovi-green-800`
- `secondary-button.blade.php` → `focus:ring-indigo-500` → `focus:ring-bovi-green-600`
- `text-input.blade.php` → `focus:border-indigo-500 focus:ring-indigo-500` → `focus:border-bovi-green-600 focus:ring-bovi-green-600`
- `responsive-nav-link.blade.php` → `border-indigo-400 bg-indigo-50` → `border-bovi-green-600 bg-bovi-green-50`
