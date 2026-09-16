<!DOCTYPE html>
<html lang="es" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kinetic Sports // High-Performance Athletic Gear')</title>
    <meta name="description" content="Tienda deportiva oficial Kinetic Sports. Calzado de alto rendimiento con placas de fibra de carbono, ropa técnica termorregulada y accesorios deportivos de élite.">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .material-symbols-outlined.filled {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-background text-on-surface flex flex-col min-h-full font-sans antialiased selection:bg-secondary-container selection:text-on-secondary">
    @php
        $currentSessionId = session()->getId();
        $cartCount = \App\Models\CartItem::where(function($q) use ($currentSessionId) {
            if (\Illuminate\Support\Facades\Auth::check()) {
                $q->where('user_id', \Illuminate\Support\Facades\Auth::id());
            } else {
                $q->where('session_id', $currentSessionId);
            }
        })->sum('quantity');
    @endphp

    <!-- Header Fijo de Alto Rendimiento -->
    <header class="fixed top-0 left-0 w-full z-50 bg-surface-container-lowest/95 backdrop-blur-md border-b border-surface-container shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
        <div class="h-20 max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-12 flex items-center justify-between gap-4">
            
            <!-- Logo Kinetic Sports -->
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="/images/logo.svg" alt="Kinetic Sports" class="h-8 w-auto object-contain transform group-hover:scale-105 transition-transform" />
                </a>
            </div>

            <!-- Buscador Interactivo -->
            <div class="flex-1 max-w-lg mx-4 hidden md:block">
                <form action="{{ route('catalog.index') }}" method="GET" class="relative w-full flex items-center">
                    <input 
                        type="search" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Buscar zapatillas, ropa técnica, accesorios..." 
                        class="w-full bg-surface-container-low text-on-surface text-sm rounded-lg pl-4 pr-11 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary placeholder:text-on-surface-variant transition-all border border-transparent focus:border-primary"
                    />
                    <button type="submit" aria-label="Buscar" class="absolute right-3 flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-xl">search</span>
                    </button>
                </form>
            </div>

            <!-- Navegación por Categorías -->
            <nav class="hidden xl:flex items-center gap-2">
                <a href="{{ route('catalog.index', ['category' => 'all']) }}" 
                   class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider rounded-lg transition-colors {{ request('category') === 'all' || !request('category') ? 'bg-surface-container-high text-on-surface' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}">
                   Todos
                </a>
                <a href="{{ route('catalog.index', ['category' => 'running']) }}" 
                   class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider rounded-lg transition-colors {{ request('category') === 'running' ? 'bg-surface-container-high text-on-surface' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}">
                   Running
                </a>
                <a href="{{ route('catalog.index', ['category' => 'training']) }}" 
                   class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider rounded-lg transition-colors {{ request('category') === 'training' ? 'bg-surface-container-high text-on-surface' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}">
                   Training & Gym
                </a>
                <a href="{{ route('catalog.index', ['category' => 'trail']) }}" 
                   class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider rounded-lg transition-colors {{ request('category') === 'trail' ? 'bg-surface-container-high text-on-surface' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}">
                   Trail
                </a>
                <a href="{{ route('catalog.index', ['category' => 'accesorios']) }}" 
                   class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider rounded-lg transition-colors {{ request('category') === 'accesorios' ? 'bg-surface-container-high text-on-surface' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}">
                   Accesorios
                </a>
            </nav>

            <!-- Acciones de Usuario & Carrito -->
            <div class="flex items-center gap-4 shrink-0">
                <!-- Bolsa / Carrito -->
                <a href="{{ route('cart.index') }}" aria-label="Carrito de compras" class="relative p-2 text-on-surface-variant hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-2xl">shopping_bag</span>
                    @if($cartCount > 0)
                        <span class="absolute 0 top-0.5 right-0.5 bg-secondary-container text-on-secondary text-[11px] font-extrabold w-5 h-5 rounded-full flex items-center justify-center shadow-md animate-pulse">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- Autenticación / Perfil -->
                @auth
                    <div class="flex items-center gap-3">
                        <span class="hidden md:inline-block text-xs font-bold uppercase text-on-surface-variant">
                            {{ Auth::user()->name }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" title="Cerrar sesión" class="p-2 text-on-surface-variant hover:text-secondary-container transition-colors">
                                <span class="material-symbols-outlined text-xl">logout</span>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-wider text-primary hover:text-secondary-container bg-surface-container px-3.5 py-2 rounded-lg transition-all border border-outline-variant/30 hover:border-secondary-container">
                        <span class="material-symbols-outlined text-base">person</span>
                        <span>Acceso</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Notificaciones Flash -->
    <div class="pt-20">
        @if(session('success'))
            <div class="bg-emerald-600 text-white px-4 py-3 text-center text-sm font-semibold flex items-center justify-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-lg">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-600 text-white px-4 py-3 text-center text-sm font-semibold flex items-center justify-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-lg">error</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('info'))
            <div class="bg-primary text-white px-4 py-3 text-center text-sm font-semibold flex items-center justify-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-lg">info</span>
                <span>{{ session('info') }}</span>
            </div>
        @endif
    </div>

    <!-- Contenido Principal -->
    <main class="flex-1 w-full">
        @yield('content')
    </main>

    <!-- Footer Oficial Kinetic Performance -->
    <footer class="bg-primary text-white pt-16 pb-12 border-t border-primary-container">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-surface-container-high/10">
                <!-- Brand Info -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-secondary-container text-white font-black text-lg">K</span>
                        <span class="text-xl font-black uppercase tracking-wider text-white">KINETIC <span class="text-secondary-fixed-dim">SPORTS</span></span>
                    </div>
                    <p class="text-outline-variant text-sm max-w-sm leading-relaxed">
                        Ingeniería biomecánica y equipamiento deportivo de alta intensidad diseñado con atletas de nivel mundial.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                        <span class="text-xs uppercase tracking-widest text-outline-variant font-bold">Laboratorio Lab-Series 2025</span>
                    </div>
                </div>

                <!-- Column 1 -->
                <div>
                    <h4 class="text-xs font-black uppercase tracking-widest text-secondary-fixed-dim mb-4">Colecciones</h4>
                    <ul class="space-y-2.5 text-sm text-outline-variant">
                        <li><a href="{{ route('catalog.index', ['category' => 'running']) }}" class="hover:text-white transition-colors">Running Pro</a></li>
                        <li><a href="{{ route('catalog.index', ['category' => 'training']) }}" class="hover:text-white transition-colors">Training & Crossfit</a></li>
                        <li><a href="{{ route('catalog.index', ['category' => 'trail']) }}" class="hover:text-white transition-colors">Trail GORE-TEX</a></li>
                        <li><a href="{{ route('catalog.index', ['category' => 'accesorios']) }}" class="hover:text-white transition-colors">Smart Devices & GPS</a></li>
                    </ul>
                </div>

                <!-- Column 2 -->
                <div>
                    <h4 class="text-xs font-black uppercase tracking-widest text-secondary-fixed-dim mb-4">Soporte Atleta</h4>
                    <ul class="space-y-2.5 text-sm text-outline-variant">
                        <li><a href="#" class="hover:text-white transition-colors">Guía de Tallas y Drop</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Envíos y Seguimiento</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Garantía 30 Días</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Devoluciones Sin Costo</a></li>
                    </ul>
                </div>

                <!-- Column 3 -->
                <div>
                    <h4 class="text-xs font-black uppercase tracking-widest text-secondary-fixed-dim mb-4">Tecnología</h4>
                    <ul class="space-y-2.5 text-sm text-outline-variant">
                        <li><a href="#" class="hover:text-white transition-colors">Placas K-Wave 3K</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Espuma NitroFoam</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Microventilación Aeroready</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Certificación ISO-42k</a></li>
                    </ul>
                </div>
            </div>

            <!-- Subfooter -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-outline-variant">
                <p>&copy; {{ date('Y') }} Kinetic Sports Technologies Inc. Todos los derechos reservados.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-white transition-colors">Privacidad</a>
                    <a href="#" class="hover:text-white transition-colors">Términos de Servicio</a>
                    <a href="#" class="hover:text-white transition-colors">Seguridad de Pago SSL</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
