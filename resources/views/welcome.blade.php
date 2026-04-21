<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoviTrack — Control total de tu ganado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        verde:     { DEFAULT: '#2E7D32', dark: '#1B5E20', light: '#4CAF50' },
                        cafe:      { DEFAULT: '#6D4C41', dark: '#4E342E', light: '#8D6E63' },
                        acento:    { DEFAULT: '#A5D6A7', dark: '#81C784', light: '#C8E6C9' },
                        tierra:    '#F9F6F1',
                    },
                    fontFamily: {
                        display: ['"Playfair Display"', 'Georgia', 'serif'],
                        body:    ['"DM Sans"', 'sans-serif'],
                    },
                    animation: {
                        'fade-up':    'fadeUp 0.8s ease forwards',
                        'fade-in':    'fadeIn 1.2s ease forwards',
                        'float':      'float 6s ease-in-out infinite',
                        'line-grow':  'lineGrow 1s ease forwards',
                    },
                    keyframes: {
                        fadeUp:   { '0%': { opacity: 0, transform: 'translateY(40px)' }, '100%': { opacity: 1, transform: 'translateY(0)' } },
                        fadeIn:   { '0%': { opacity: 0 },  '100%': { opacity: 1 } },
                        float:    { '0%,100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-12px)' } },
                        lineGrow: { '0%': { width: '0%' }, '100%': { width: '100%' } },
                    }
                }
            }
        }
    </script>
    <style>
        /* ── Globals ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-family: 'DM Sans', sans-serif; }
        body { background: #F9F6F1; color: #1a1a1a; overflow-x: hidden; }

        /* ── Scroll reveal ── */
        .reveal { opacity: 0; transform: translateY(48px); transition: opacity 0.75s cubic-bezier(.16,1,.3,1), transform 0.75s cubic-bezier(.16,1,.3,1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-left  { opacity: 0; transform: translateX(-60px); transition: opacity 0.8s cubic-bezier(.16,1,.3,1), transform 0.8s cubic-bezier(.16,1,.3,1); }
        .reveal-right { opacity: 0; transform: translateX(60px);  transition: opacity 0.8s cubic-bezier(.16,1,.3,1), transform 0.8s cubic-bezier(.16,1,.3,1); }
        .reveal-left.visible, .reveal-right.visible { opacity: 1; transform: translateX(0); }
        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
        .delay-4 { transition-delay: 0.45s; }

        /* ── Navbar ── */
        #navbar { transition: background 0.4s, box-shadow 0.4s; }
        #navbar.scrolled { background: rgba(249,246,241,0.96); backdrop-filter: blur(12px); box-shadow: 0 2px 24px rgba(0,0,0,.08); }

        /* Links blancos sobre hero */
        #navbar:not(.scrolled) .nav-link        { color: rgba(255,255,255,0.88); }
        #navbar:not(.scrolled) .nav-link:hover  { color: #fff; }
        #navbar:not(.scrolled) .nav-login       { color: rgba(255,255,255,0.75); }
        #navbar:not(.scrolled) .nav-login:hover { color: #fff; }
        #navbar:not(.scrolled) .nav-logo-text   { color: #fff; }
        #navbar:not(.scrolled) .nav-logo-sub    { color: #A5D6A7; }

        /* Links oscuros al hacer scroll */
        #navbar.scrolled .nav-link        { color: #4b5563; }
        #navbar.scrolled .nav-link:hover  { color: #2E7D32; }
        #navbar.scrolled .nav-login       { color: #4b5563; }
        #navbar.scrolled .nav-login:hover { color: #2E7D32; }
        #navbar.scrolled .nav-logo-text   { color: #1B5E20; }
        #navbar.scrolled .nav-logo-sub    { color: #6D4C41; }

        .nav-link, .nav-login, .nav-logo-text, .nav-logo-sub {
            transition: color 0.35s ease;
        }

        /* ── Hero ── */
        .hero-bg {
            background-image: url('https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?auto=format&fit=crop&w=1920&q=80');
            background-size: cover; background-position: center;
            /* dejar espacio superior para el navbar fijo */
            padding-top: 80px;
            min-height: calc(100vh - 80px);
        }
        .hero-media { position: absolute; inset: 0; }
        #heroVideo { display: none; }
        /* por defecto mostramos el poster hasta que JS cargue el video */
        #heroPoster { display: block; }
       .hero-overlay { 
  background: linear-gradient(
    90deg,
    rgba(0,0,0,0.65) 0%,
    rgba(0,0,0,0.4) 35%,
    rgba(0,0,0,0.15) 65%,
    rgba(0,0,0,0) 100%
  );
}

        /* ── Benefit cards ── */
        .benefit-card { transition: transform 0.35s cubic-bezier(.16,1,.3,1), box-shadow 0.35s; }
        .benefit-card:hover { transform: translateY(-8px); box-shadow: 0 24px 56px rgba(46,125,50,.15), 0 8px 16px rgba(0,0,0,.06); }
        .icon-wrap { transition: background 0.3s, transform 0.3s; }
        .benefit-card:hover .icon-wrap { background: #2E7D32; transform: scale(1.08); }
        .benefit-card:hover .icon-wrap svg { stroke: #fff; }

        /* ── Feature grid ── */
        .feat-item { transition: background 0.3s, transform 0.3s; }
        .feat-item:hover { background: #2E7D32; transform: scale(1.03); }
        .feat-item:hover * { color: #fff !important; }
        .feat-item:hover .feat-dot { background: #A5D6A7; }

        /* ── Dashboard mockup ── */
        .mockup-card { transition: transform 0.4s cubic-bezier(.16,1,.3,1); }
        .mockup-card:hover { transform: perspective(1000px) rotateY(-4deg) scale(1.02); }

        /* ── CTA section ── */
        .cta-bg {
            background-image: url('https://images.unsplash.com/photo-1500595046743-cd271d694d30?auto=format&fit=crop&w=1920&q=80');
            background-size: cover; background-position: center;
        }
        .cta-overlay { background: linear-gradient(160deg, rgba(27,94,32,0.93) 0%, rgba(109,76,65,0.85) 100%); }

        /* ── Diferencial ── */
        .diferencial-bg {
            background-image: url('https://images.unsplash.com/photo-1628352081506-83a9b4ce5e0d?auto=format&fit=crop&w=1920&q=80');
            background-size: cover; background-position: center;
        }
        .diferencial-overlay { background: rgba(27,94,32,0.82); }

        /* ── Buttons ── */
        .btn-primary { background: #2E7D32; color: #fff; border-radius: 9999px; padding: 0.9rem 2.2rem; font-weight: 600; font-size: 0.95rem; letter-spacing: 0.02em; transition: background 0.3s, transform 0.2s, box-shadow 0.3s; box-shadow: 0 4px 20px rgba(46,125,50,.35); }
        .btn-primary:hover { background: #1B5E20; transform: translateY(-2px); box-shadow: 0 8px 32px rgba(46,125,50,.45); }
        .btn-outline { border: 2px solid rgba(255,255,255,0.7); color: #fff; border-radius: 9999px; padding: 0.85rem 2.2rem; font-weight: 500; font-size: 0.95rem; backdrop-filter: blur(4px); transition: background 0.3s, border-color 0.3s, transform 0.2s; }
        .btn-outline:hover { background: rgba(255,255,255,0.15); border-color: #fff; transform: translateY(-2px); }

        /* ── Marquee numbers ── */
        .stat-num { font-family: 'Playfair Display', serif; font-weight: 900; color: #2E7D32; }

        /* ── Noise texture overlay ── */
        body::before { content:''; position:fixed; inset:0; pointer-events:none; opacity:.025; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E"); z-index:0; }

        /* Mobile adjustments */
        @media (max-width: 767px) {
            .hero-bg { padding-top: 64px; min-height: auto; padding-bottom: 48px; }
            .hero-bg .hero-overlay { background: linear-gradient(180deg, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.25) 50%, rgba(0,0,0,0) 100%); }
            .btn-primary, .btn-outline { width: 100%; display: inline-block; }
            .btn-primary, .btn-outline { padding: 0.6rem 1rem; border-radius: 12px; font-size: 0.92rem; }
            .mockup-card .grid, .mockup-card .grid * { max-width: 100%; }
            .cta-bg .absolute.hidden-sm { display: none; }
        }

        /* ── Custom scrollbar ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #F9F6F1; }
        ::-webkit-scrollbar-thumb { background: #A5D6A7; border-radius: 9999px; }
    </style>
</head>
<body>

<!-- ╔══════════════════════════════════════════╗ -->
<!-- ║              NAVBAR                      ║ -->
<!-- ╚══════════════════════════════════════════╝ -->
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 px-6 md:px-12 py-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <!-- Logo -->
        <a href="#" class="flex items-center gap-2.5 group">
            <!-- Reemplaza /public/img/logo.png por la ruta de tu logo -->
            <img src="/img/logon.png" alt="BoviTrack" class="w-9 h-9 rounded-xl object-cover shadow-lg group-hover:scale-105 transition-transform">
            <span class="font-display font-bold text-xl nav-logo-text tracking-tight">Bovi<span class="nav-logo-sub">Track</span></span>
        </a>

        <!-- Links desktop -->
        <div class="hidden md:flex items-center gap-8 text-sm font-medium">
            <a href="#beneficios"      class="nav-link">Beneficios</a>
            <a href="#funcionalidades" class="nav-link">Funcionalidades</a>
            <a href="#sistema"         class="nav-link">Sistema</a>
            <a href="#diferencial"     class="nav-link">Nosotros</a>
        </div>

        <!-- CTA -->
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="hidden md:block text-sm font-medium nav-login">Iniciar sesión</a>
            <a href="#cta" class="hidden md:inline-flex btn-primary text-sm">Comenzar gratis</a>
        </div>
    </div>
</nav>


<!-- ╔══════════════════════════════════════════╗ -->
<!-- ║                HERO                      ║ -->
<!-- ╚══════════════════════════════════════════╝ -->
<section class="hero-bg relative min-h-screen flex items-center overflow-hidden">

    <!-- Media -->
    <div class="hero-media absolute inset-0 z-0 overflow-hidden">
        <!-- Video de fondo para desktop, imagen para mobile -->
        <video id="heroVideo" class="hidden md:block w-full h-full object-cover" autoplay loop muted playsinline poster="/img/vaca.jpg">
            <source data-src="/video/hero.mp4" type="video/mp4">
            Tu navegador no soporta video HTML5.
        </video>
        <img id="heroPoster" src="/img/vaca.jpg" class="block md:hidden w-full h-full object-cover" alt="Ganado inteligente BoviTrack">
    </div>

    <!-- Overlay moderno -->
    <div class="hero-overlay absolute inset-0 z-10"></div>

    <div class="relative z-20 max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">

        <!-- LEFT: CONTENT -->
        <div class="text-white">

            <!-- Social proof -->
            <p class="text-sm text-white/70 mb-4">
                +500 productores ya usan BoviTrack
            </p>

            <!-- Title -->
            <h1 class="font-display font-black text-5xl md:text-6xl leading-tight mb-6">
                Detecta problemas en tu ganado<br>
                <span class="text-acento italic">antes de que te cuesten dinero</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-lg text-white/80 max-w-xl mb-8">
                BoviTrack te muestra qué animales están bajando de peso, cuándo intervenir y cómo mejorar tu producción sin adivinar.
            </p>

            <!-- CTA -->
            <div class="flex flex-col sm:flex-row gap-4 mb-4">
                <a href="{{ route('register') }}" class="btn-primary text-base px-8 py-4 w-full sm:w-auto text-center">
                    Probar gratis con mis animales
                </a>

                <a href="#sistema" class="btn-outline text-base px-6 py-4 w-full sm:w-auto text-center">
                    Ver cómo funciona
                </a>
            </div>

            <!-- Microcopy -->
            <p class="text-xs text-white/60">
                Sin tarjeta de crédito · Configuración en minutos
            </p>
        </div>

        <!-- RIGHT: DASHBOARD -->
       

    </div>
</section>

<!-- ╔══════════════════════════════════════════╗ -->
<!-- ║            BENEFICIOS                    ║ -->
<!-- ╚══════════════════════════════════════════╝ -->
<section id="beneficios" class="py-28 px-6 bg-tierra">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="text-center mb-16 reveal">
            <span class="text-xs font-semibold tracking-widest uppercase text-verde">Beneficios</span>
            <h2 class="font-display font-bold text-4xl md:text-5xl text-gray-900 mt-3 leading-tight">
                Todo lo que necesitas,<br>
                <span class="text-cafe italic">en un solo sistema</span>
            </h2>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Card 1 -->
            <div class="benefit-card bg-white rounded-3xl p-7 shadow-sm border border-gray-100 reveal delay-1">
                <div class="icon-wrap w-13 h-13 w-14 h-14 rounded-2xl bg-verde/10 flex items-center justify-center mb-5">
                    <svg class="w-7 h-7" stroke="#2E7D32" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-lg text-gray-900 mb-2">Control de Peso</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Registra y monitorea el crecimiento de cada animal con histórico detallado y alertas automáticas.</p>
                <div class="mt-5 flex items-center gap-1.5 text-verde text-sm font-medium">
                    <span>Ver más</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="benefit-card bg-white rounded-3xl p-7 shadow-sm border border-gray-100 reveal delay-2">
                <div class="icon-wrap w-14 h-14 rounded-2xl bg-verde/10 flex items-center justify-center mb-5">
                    <svg class="w-7 h-7" stroke="#2E7D32" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-lg text-gray-900 mb-2">Seguimiento Sanitario</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Vacunas, tratamientos y diagnósticos organizados con recordatorios y alertas inteligentes.</p>
                <div class="mt-5 flex items-center gap-1.5 text-verde text-sm font-medium">
                    <span>Ver más</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="benefit-card bg-white rounded-3xl p-7 shadow-sm border border-gray-100 reveal delay-3">
                <div class="icon-wrap w-14 h-14 rounded-2xl bg-verde/10 flex items-center justify-center mb-5">
                    <svg class="w-7 h-7" stroke="#2E7D32" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-lg text-gray-900 mb-2">Reproducción</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Gestiona celos, preñeces y partos con árbol genealógico completo para cada animal.</p>
                <div class="mt-5 flex items-center gap-1.5 text-verde text-sm font-medium">
                    <span>Ver más</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="benefit-card bg-verde rounded-3xl p-7 shadow-lg reveal delay-4">
                <div class="icon-wrap w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center mb-5">
                    <svg class="w-7 h-7" stroke="#fff" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-lg text-white mb-2">Producción de Leche</h3>
                <p class="text-sm text-white/75 leading-relaxed">Controla litros por vaca, detecta anomalías y optimiza la producción con análisis en tiempo real.</p>
                <div class="mt-5 flex items-center gap-1.5 text-acento text-sm font-medium">
                    <span>Ver más</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ╔══════════════════════════════════════════╗ -->
<!-- ║         DASHBOARD / SISTEMA              ║ -->
<!-- ╚══════════════════════════════════════════╝ -->
<section id="sistema" class="py-28 px-6 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-16 items-center">

        <!-- Mockup izquierda -->
        <div class="mockup-card reveal-left">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-gray-100" style="background:#F9F6F1">
                <!-- Bar superior -->
                <div class="bg-verde-dark px-5 py-3 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-400"></span>
                    <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                    <span class="w-3 h-3 rounded-full bg-green-400"></span>
                    <span class="ml-3 text-xs text-white/50 font-mono">bovitrack.app/dashboard</span>
                </div>
                <!-- Dashboard simulado -->
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <div class="text-xs text-gray-400 mb-1">Buenos días, Carlos</div>
                            <div class="font-display font-bold text-gray-900 text-lg">Panel de control</div>
                        </div>
                        <div class="flex gap-2">
                            <div class="w-8 h-8 rounded-xl bg-verde/15 flex items-center justify-center">
                                <div class="w-2 h-2 rounded-full bg-verde"></div>
                            </div>
                            <div class="w-8 h-8 rounded-xl bg-cafe/15 flex items-center justify-center">
                                <div class="w-2 h-2 rounded-full bg-cafe"></div>
                            </div>
                        </div>
                    </div>

                    <!-- KPI cards -->
                    <div class="grid grid-cols-3 gap-3 mb-5">
                        <div class="bg-verde rounded-2xl p-3 text-white text-center">
                            <div class="font-display font-bold text-xl">248</div>
                            <div class="text-xs opacity-70 mt-0.5">Animales</div>
                        </div>
                        <div class="bg-cafe rounded-2xl p-3 text-white text-center">
                            <div class="font-display font-bold text-xl">32</div>
                            <div class="text-xs opacity-70 mt-0.5">Gestaciones</div>
                        </div>
                        <div class="bg-acento-dark rounded-2xl p-3 text-white text-center">
                            <div class="font-display font-bold text-xl">1,240L</div>
                            <div class="text-xs opacity-70 mt-0.5">Leche/día</div>
                        </div>
                    </div>

                    <!-- Gráfico simulado -->
                    <div class="bg-gray-50 rounded-2xl p-4 mb-4">
                        <div class="flex items-end justify-between h-20 gap-2">
                            <div class="flex-1 bg-verde/30 rounded-t-lg" style="height:45%"></div>
                            <div class="flex-1 bg-verde/40 rounded-t-lg" style="height:65%"></div>
                            <div class="flex-1 bg-verde/50 rounded-t-lg" style="height:55%"></div>
                            <div class="flex-1 bg-verde/60 rounded-t-lg" style="height:80%"></div>
                            <div class="flex-1 bg-verde/70 rounded-t-lg" style="height:70%"></div>
                            <div class="flex-1 bg-verde/80 rounded-t-lg" style="height:90%"></div>
                            <div class="flex-1 bg-verde rounded-t-lg"    style="height:100%"></div>
                        </div>
                        <div class="flex justify-between mt-2 text-xs text-gray-400">
                            <span>Ene</span><span>Feb</span><span>Mar</span><span>Abr</span><span>May</span><span>Jun</span><span>Jul</span>
                        </div>
                    </div>

                    <!-- Alertas -->
                    <div class="space-y-2">
                        <div class="flex items-center gap-3 bg-green-50 rounded-xl p-3">
                            <span class="w-2 h-2 rounded-full bg-verde flex-shrink-0"></span>
                            <span class="text-xs text-gray-600">Vaca #124 — Parto programado en 3 días</span>
                        </div>
                        <div class="flex items-center gap-3 bg-amber-50 rounded-xl p-3">
                            <span class="w-2 h-2 rounded-full bg-amber-400 flex-shrink-0"></span>
                            <span class="text-xs text-gray-600">Toro #08 — Vacuna aftosa pendiente</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Texto derecha -->
        <div class="reveal-right">
            <span class="text-xs font-semibold tracking-widest uppercase text-verde">Dashboard en tiempo real</span>
            <h2 class="font-display font-bold text-4xl md:text-5xl text-gray-900 mt-4 mb-6 leading-tight">
                Visualiza tu hato<br>
                <span class="text-cafe italic">como nunca antes</span>
            </h2>
            <p class="text-gray-500 leading-relaxed mb-8 text-lg">
                Toda la información de tu ganado centralizada en un panel intuitivo. 
                Toma decisiones basadas en datos reales, desde cualquier dispositivo, en cualquier lugar de la finca.
            </p>

            <ul class="space-y-4 mb-10">
                <li class="flex items-start gap-3">
                    <span class="w-5 h-5 rounded-full bg-verde/15 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-verde" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <span class="text-gray-600">Métricas clave siempre visibles y actualizadas al instante</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-5 h-5 rounded-full bg-verde/15 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-verde" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <span class="text-gray-600">Alertas automáticas para eventos críticos del hato</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-5 h-5 rounded-full bg-verde/15 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-verde" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <span class="text-gray-600">Reportes exportables en PDF y Excel con un clic</span>
                </li>
            </ul>

            <a href="#cta" class="btn-primary inline-flex">Probar gratis por 14 días →</a>
        </div>
    </div>
</section>


<!-- ╔══════════════════════════════════════════╗ -->
<!-- ║          FUNCIONALIDADES                 ║ -->
<!-- ╚══════════════════════════════════════════╝ -->
<section id="funcionalidades" class="py-28 px-6 bg-tierra">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="text-center mb-16 reveal">
            <span class="text-xs font-semibold tracking-widest uppercase text-verde">Funcionalidades</span>
            <h2 class="font-display font-bold text-4xl md:text-5xl text-gray-900 mt-3">
                Diseñado para el<br>
                <span class="text-cafe italic">ganadero moderno</span>
            </h2>
        </div>

        <!-- Feature grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="feat-item rounded-2xl p-6 bg-white border border-gray-100 cursor-default reveal delay-1">
                <div class="feat-dot w-2.5 h-2.5 rounded-full bg-verde mb-5"></div>
                <h3 class="font-semibold text-gray-900 mb-2">Historial completo</h3>
                <p class="text-sm text-gray-400 leading-relaxed">Cada evento del animal registrado cronológicamente: peso, salud, reproducción.</p>
            </div>

            <div class="feat-item rounded-2xl p-6 bg-white border border-gray-100 cursor-default reveal delay-2">
                <div class="feat-dot w-2.5 h-2.5 rounded-full bg-verde mb-5"></div>
                <h3 class="font-semibold text-gray-900 mb-2">Alertas inteligentes</h3>
                <p class="text-sm text-gray-400 leading-relaxed">Notificaciones automáticas por SMS, email o app para vacunas, partos y tratamientos.</p>
            </div>

            <div class="feat-item rounded-2xl p-6 bg-white border border-gray-100 cursor-default reveal delay-3">
                <div class="feat-dot w-2.5 h-2.5 rounded-full bg-verde mb-5"></div>
                <h3 class="font-semibold text-gray-900 mb-2">Registro de crías</h3>
                <p class="text-sm text-gray-400 leading-relaxed">Árbol genealógico automático al registrar cada parto con datos del padre y la madre.</p>
            </div>

            <div class="feat-item rounded-2xl p-6 bg-white border border-gray-100 cursor-default reveal delay-4">
                <div class="feat-dot w-2.5 h-2.5 rounded-full bg-verde mb-5"></div>
                <h3 class="font-semibold text-gray-900 mb-2">Control sanitario</h3>
                <p class="text-sm text-gray-400 leading-relaxed">Protocolos de vacunación, desparasitación y tratamientos con dosis y fechas.</p>
            </div>

            <div class="feat-item rounded-2xl p-6 bg-verde/8 border border-verde/20 cursor-default reveal delay-1">
                <div class="feat-dot w-2.5 h-2.5 rounded-full bg-cafe mb-5"></div>
                <h3 class="font-semibold text-gray-900 mb-2">Multi-finca</h3>
                <p class="text-sm text-gray-400 leading-relaxed">Gestiona varias fincas desde una sola cuenta con usuarios y roles diferenciados.</p>
            </div>

            <div class="feat-item rounded-2xl p-6 bg-verde/8 border border-verde/20 cursor-default reveal delay-2">
                <div class="feat-dot w-2.5 h-2.5 rounded-full bg-cafe mb-5"></div>
                <h3 class="font-semibold text-gray-900 mb-2">App móvil</h3>
                <p class="text-sm text-gray-400 leading-relaxed">Accede desde el potrero con la app iOS y Android, incluso sin conexión a internet.</p>
            </div>

            <div class="feat-item rounded-2xl p-6 bg-verde/8 border border-verde/20 cursor-default reveal delay-3">
                <div class="feat-dot w-2.5 h-2.5 rounded-full bg-cafe mb-5"></div>
                <h3 class="font-semibold text-gray-900 mb-2">Reportes avanzados</h3>
                <p class="text-sm text-gray-400 leading-relaxed">Exporta análisis de producción, costos y rentabilidad por animal o lote.</p>
            </div>

            <div class="feat-item rounded-2xl p-6 bg-verde/8 border border-verde/20 cursor-default reveal delay-4">
                <div class="feat-dot w-2.5 h-2.5 rounded-full bg-cafe mb-5"></div>
                <h3 class="font-semibold text-gray-900 mb-2">Integración QR</h3>
                <p class="text-sm text-gray-400 leading-relaxed">Identifica cada animal con código QR o arete electrónico para registro rápido.</p>
            </div>
        </div>
    </div>
</section>


<!-- ╔══════════════════════════════════════════╗ -->
<!-- ║           DIFERENCIAL                    ║ -->
<!-- ╚══════════════════════════════════════════╝ -->
<section id="diferencial" class="diferencial-bg relative py-36 px-6 overflow-hidden">
    <div class="diferencial-overlay absolute inset-0"></div>

    <div class="relative z-10 max-w-4xl mx-auto text-center text-white">
        <!-- Quote marks -->
        <div class="font-display text-8xl text-white/15 leading-none mb-2 reveal">"</div>

        <h2 class="font-display font-black text-4xl md:text-6xl leading-tight mb-8 reveal" style="animation-delay:.1s">
            BoviTrack conecta<br>
            la <span class="text-acento italic">tecnología</span> con el campo
        </h2>
        <p class="text-lg md:text-xl text-white/75 max-w-2xl mx-auto leading-relaxed reveal" style="animation-delay:.2s">
            Creamos BoviTrack porque creemos que el ganadero colombiano merece herramientas de clase mundial. 
            No más cuadernos, no más olvidos, no más pérdidas evitables.
        </p>

        <!-- Logos / testimonial -->
        <div class="mt-16 flex flex-col sm:flex-row items-center justify-center gap-8 reveal" style="animation-delay:.3s">
            <div class="text-center">
                <div class="font-display font-black text-4xl text-acento">+3 años</div>
                <div class="text-sm text-white/60 mt-1">Desarrollando para el campo</div>
            </div>
            <div class="w-px h-12 bg-white/20 hidden sm:block"></div>
            <div class="text-center">
                <div class="font-display font-black text-4xl text-acento">15 depts</div>
                <div class="text-sm text-white/60 mt-1">Presencia en Colombia</div>
            </div>
            <div class="w-px h-12 bg-white/20 hidden sm:block"></div>
            <div class="text-center">
                <div class="font-display font-black text-4xl text-acento">24/7</div>
                <div class="text-sm text-white/60 mt-1">Soporte especializado</div>
            </div>
        </div>
    </div>
</section>


<!-- ╔══════════════════════════════════════════╗ -->
<!-- ║               CTA FINAL                  ║ -->
<!-- ╚══════════════════════════════════════════╝ -->
<section id="cta" class="cta-bg relative py-32 px-6">
    <div class="cta-overlay absolute inset-0"></div>

    <!-- Decorative ring (hidden on small screens) -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full border border-white/5 hidden sm:block"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] rounded-full border border-white/8 hidden sm:block"></div>

    <div class="relative z-10 max-w-3xl mx-auto text-center text-white reveal">
        <span class="text-xs font-semibold tracking-widest uppercase text-acento mb-4 block">Sin tarjeta de crédito</span>
        <h2 class="font-display font-black text-5xl md:text-7xl leading-tight mb-6">
            Empieza a optimizar<br>
            <span class="text-acento italic">tu producción hoy</span>
        </h2>
        <p class="text-white/70 text-lg mb-10 max-w-xl mx-auto">
            14 días gratis. Configuración en minutos. Soporte personalizado incluido.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="#" class="btn-primary px-10 py-4 text-base w-full sm:w-auto text-center">Crear cuenta gratis →</a>
            <a href="#" class="btn-outline px-8 py-4 text-base w-full sm:w-auto text-center">Hablar con ventas</a>
        </div>

        <!-- Trust badges -->
        <div class="mt-12 flex items-center justify-center gap-8 text-white/40 text-xs">
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                SSL Seguro
            </div>
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Datos protegidos
            </div>
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Soporte 24/7
            </div>
        </div>
    </div>
</section>


<!-- ╔══════════════════════════════════════════╗ -->
<!-- ║                FOOTER                    ║ -->
<!-- ╚══════════════════════════════════════════╝ -->
<footer class="bg-verde-dark text-white px-6 py-16">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">

            <!-- Brand -->
            <div class="md:col-span-1">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-9 h-9 rounded-xl bg-verde flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <span class="font-display font-bold text-xl">Bovi<span class="text-acento">Track</span></span>
                </div>
                <p class="text-white/50 text-sm leading-relaxed">
                    El sistema ganadero más completo de Colombia. Tecnología pensada para el campo.
                </p>
            </div>

            <!-- Links producto -->
            <div>
                <h4 class="font-semibold text-sm mb-4 text-white/80">Producto</h4>
                <ul class="space-y-2.5 text-sm text-white/50">
                    <li><a href="#" class="hover:text-white transition-colors">Funcionalidades</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Precios</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Demo en vivo</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">App móvil</a></li>
                </ul>
            </div>

            <!-- Links empresa -->
            <div>
                <h4 class="font-semibold text-sm mb-4 text-white/80">Empresa</h4>
                <ul class="space-y-2.5 text-sm text-white/50">
                    <li><a href="#" class="hover:text-white transition-colors">Nosotros</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Contacto</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Trabaja con nosotros</a></li>
                </ul>
            </div>

            <!-- Redes sociales -->
            <div>
                <h4 class="font-semibold text-sm mb-4 text-white/80">Síguenos</h4>
                <div class="flex gap-3">
                    <a href="#" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-verde transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-verde transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/></svg>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-verde transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.76a4.85 4.85 0 01-1.01-.07z"/></svg>
                    </a>
                </div>

                <div class="mt-6">
                    <p class="text-xs text-white/40 mb-2">Newsletter ganadero</p>
                    <div class="flex gap-2">
                        <input type="email" placeholder="tu@email.com" class="flex-1 bg-white/10 border border-white/15 rounded-xl px-3 py-2 text-sm text-white placeholder-white/30 focus:outline-none focus:border-acento transition-colors">
                        <button class="bg-verde px-4 py-2 rounded-xl text-sm font-medium hover:bg-verde-light transition-colors">→</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-white/30">
            <span>© {{ date('Y') }} BoviTrack. Todos los derechos reservados.</span>
            <div class="flex gap-6">
                <a href="#" class="hover:text-white transition-colors">Privacidad</a>
                <a href="#" class="hover:text-white transition-colors">Términos</a>
                <a href="#" class="hover:text-white transition-colors">Cookies</a>
            </div>
        </div>
    </div>
</footer>


<!-- ╔══════════════════════════════════════════╗ -->
<!-- ║              JAVASCRIPT                  ║ -->
<!-- ╚══════════════════════════════════════════╝ -->
<script>
    // ── Navbar scroll ──────────────────────────
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 40);
    });

    // ── Scroll reveal ──────────────────────────
    const revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(el => observer.observe(el));

    // ── Parallax suave en hero ──────────────────
    const heroBg = document.querySelector('.hero-bg');
    window.addEventListener('scroll', () => {
        const y = window.scrollY;
        if (heroBg && y < window.innerHeight) {
            heroBg.style.backgroundPositionY = `calc(50% + ${y * 0.35}px)`;
        }
    }, { passive: true });

    // ── Counter animation ───────────────────────
    function animateCounter(el, target, duration = 1800) {
        let start = 0;
        const step = target / (duration / 16);
        const timer = setInterval(() => {
            start = Math.min(start + step, target);
            el.textContent = Math.floor(start).toLocaleString();
            if (start >= target) clearInterval(timer);
        }, 16);
    }

    // ── Smooth anchor scrolling ─────────────────
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ── Hero video lazy-load with connection check ─────────────────
    (function() {
        const video = document.getElementById('heroVideo');
        const source = video ? video.querySelector('source[data-src]') : null;
        const poster = document.getElementById('heroPoster');

        function isSlowConnection() {
            try {
                const nav = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
                if (!nav) return false;
                if (nav.saveData) return true;
                const slow = ['slow-2g', '2g'];
                if (nav.effectiveType && slow.includes(nav.effectiveType)) return true;
            } catch (e) {}
            return false;
        }

        function isMobileViewport() {
            return window.innerWidth < 768;
        }

        // Decide whether to load video:
        // - allow on desktop
        // - on mobile allow only when connection is good (4g/5g) or when we can't detect connection
        const allowVideo = source && !isSlowConnection() && (
            !isMobileViewport() ||
            (isMobileViewport() && (
                (navigator.connection && ['4g','5g'].includes(navigator.connection.effectiveType)) ||
                !navigator.connection
            ))
        );

        if (allowVideo) {
            // set source and try to play
            source.src = source.dataset.src;
            video.load();
            video.style.display = 'block';
            poster.style.display = 'none';
            video.play().catch(() => {
                // autoplay might be blocked; keep poster visible
                video.style.display = 'none';
                poster.style.display = 'block';
            });
        } else {
            // keep poster visible and remove video source to avoid downloading
            if (source) source.removeAttribute('data-src');
            if (video) video.parentNode && video.remove();
            if (poster) poster.style.display = 'block';
        }
    })();
</script>

</body>
</html>