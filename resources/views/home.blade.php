@extends('layouts.app')

@section('title', 'Kinetic Sports // Catálogo Oficial 2025')

@section('content')
<div class="flex flex-col w-full">
    <!-- Hero Banner Cinematográfico de Alto Rendimiento -->
    <section class="relative w-full overflow-hidden bg-primary-container text-white py-16 lg:py-24">
        <!-- Imagen de fondo con mix-blend y gradiente -->
        <div class="absolute inset-0 bg-cover bg-center opacity-40 mix-blend-screen scale-105 transition-transform duration-1000 ease-out" 
             style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAvf6d9qI4DyMIjiAxPJrJ9VMKPXqHbaqqIoToT36kesfAslcoAhdE99LS6-lhKTj62kuQ6FG7uNm3Gr9LvQhRnBo7eqrTGLl_KRHYhnlQ2ff-m0aV-jc5diMx1RHqBDRs1O73qtTfpL66CyMYJD3w-LO_zGt8kF8-vUpU6TWejoHpqhtY7pbWxQFIuOBon7kRHAOcBQaNucSug_nyrQUu3PQSLdibu1NMnbzsTGcQad7eVVimuClm45Q')">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-primary-container via-primary-container/85 to-transparent"></div>
        
        <div class="relative max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-12 flex flex-col items-start z-10">
            <!-- Badge Envío Gratis -->
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full shadow-sm mb-4">
                <span class="w-2 h-2 rounded-full bg-secondary-container animate-pulse"></span>
                <span class="text-xs uppercase tracking-widest text-secondary-fixed font-bold">Envío Gratis en pedidos +$240</span>
                <span class="material-symbols-outlined text-sm text-secondary-fixed">local_shipping</span>
            </div>

            <!-- Headline Block -->
            <div class="max-w-3xl mb-6">
                <span class="text-xs uppercase tracking-widest text-on-primary-container font-extrabold block mb-2">Edición Técnica de Alto Rendimiento</span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tighter uppercase text-white mb-4 leading-none">
                    SUPERÁ TUS <span class="text-transparent bg-clip-text bg-gradient-to-r from-secondary-container via-secondary-fixed to-white">LÍMITES</span>
                </h1>
                <p class="text-base sm:text-lg text-outline-variant max-w-xl leading-relaxed">
                    Nueva colección de rendimiento Pro-Series 2025. Materiales ultraligeros, termorregulación por zonas y amortiguación reactiva desarrollada con atletas de élite.
                </p>
            </div>

            <!-- Hero Actions & Highlights -->
            <div class="flex flex-wrap items-center gap-4">
                <a href="#catalogo" class="inline-flex items-center gap-2 bg-secondary-container text-white px-8 py-3.5 rounded-lg text-sm font-black uppercase tracking-wider shadow-lg hover:bg-secondary transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                    <span>Explorar Colección</span>
                    <span class="material-symbols-outlined text-xl">arrow_forward</span>
                </a>
                <div class="flex items-center gap-3 px-4 py-2.5 bg-tertiary-container/80 backdrop-blur-sm rounded-lg border border-white/10">
                    <div class="flex -space-x-2">
                        <span class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center text-[10px] font-bold text-white">42k</span>
                        <span class="w-7 h-7 rounded-full bg-secondary-container flex items-center justify-center text-[10px] font-bold text-white">ISO</span>
                    </div>
                    <span class="text-xs text-outline-variant uppercase tracking-wider font-semibold">Homologación Olímpica 2025</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Centro de Control: Filtros y Ordenamiento -->
    <section class="sticky top-20 z-30 w-full bg-surface-container-lowest/95 backdrop-blur-md shadow-sm border-b border-surface-container" id="catalogo">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-12 py-3 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Pills de Categorías -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
                <a href="{{ route('home', ['category' => 'all', 'sort' => request('sort')]) }}" 
                   class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all whitespace-nowrap {{ $activeCategory === 'all' ? 'bg-primary text-white shadow-sm' : 'bg-surface-container text-on-surface hover:bg-surface-container-high' }}">
                    Todos ({{ \App\Models\Product::count() }})
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('home', ['category' => $category->slug, 'sort' => request('sort')]) }}" 
                       class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all whitespace-nowrap {{ $activeCategory === $category->slug ? 'bg-primary text-white shadow-sm' : 'bg-surface-container text-on-surface hover:bg-surface-container-high' }}">
                        {{ $category->name }} ({{ $category->products_count }})
                    </a>
                @endforeach
            </div>

            <!-- Selector de Ordenamiento -->
            <form action="{{ route('home') }}" method="GET" class="flex items-center justify-between md:justify-end gap-3 shrink-0">
                <input type="hidden" name="category" value="{{ $activeCategory }}">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <span class="text-xs uppercase tracking-wider text-on-surface-variant hidden lg:inline font-bold">Ordenar por:</span>
                <div class="relative inline-flex items-center">
                    <select name="sort" onchange="this.form.submit()" class="appearance-none bg-surface-container text-on-surface text-xs font-bold uppercase tracking-wider rounded-lg pl-4 pr-9 py-2 focus:outline-none focus:bg-surface-container-high cursor-pointer shadow-sm border border-transparent">
                        <option value="populares" {{ $activeSort === 'populares' ? 'selected' : '' }}>Más populares</option>
                        <option value="menor-precio" {{ $activeSort === 'menor-precio' ? 'selected' : '' }}>Menor precio</option>
                        <option value="mayor-precio" {{ $activeSort === 'mayor-precio' ? 'selected' : '' }}>Mayor precio</option>
                    </select>
                    <span class="material-symbols-outlined text-lg absolute right-2 pointer-events-none text-on-surface-variant">expand_more</span>
                </div>
            </form>
        </div>
    </section>

    <!-- Resultados y Búsqueda Activa (si aplica) -->
    @if(request('search'))
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-12 pt-6">
            <div class="inline-flex items-center gap-2 bg-surface-container px-3 py-1.5 rounded-lg text-xs font-semibold">
                <span>Resultados para: <strong>"{{ request('search') }}"</strong></span>
                <a href="{{ route('home') }}" class="text-secondary hover:underline flex items-center">
                    <span class="material-symbols-outlined text-sm">close</span>
                </a>
            </div>
        </div>
    @endif

    <!-- Cuadrícula de Productos Oficiales -->
    <section class="w-full max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-12 py-10">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-baseline gap-3">
                <h2 class="text-2xl lg:text-3xl uppercase text-primary font-black tracking-tight">Catálogo de Equipamiento</h2>
                <span class="text-xs uppercase tracking-widest text-on-surface-variant font-bold hidden sm:inline">Sesión Oficial 2025</span>
            </div>
            <span class="text-xs uppercase tracking-widest text-on-surface-variant bg-surface-container-low px-3 py-1 rounded font-bold">
                {{ $products->count() }} Modelos Disponibles
            </span>
        </div>

        @if($products->isEmpty())
            <div class="bg-surface-container-lowest rounded-xl p-12 text-center my-8 shadow-sm">
                <span class="material-symbols-outlined text-5xl text-outline-variant mb-3">search_off</span>
                <h3 class="text-lg font-bold text-primary mb-2">No se encontraron productos</h3>
                <p class="text-sm text-on-surface-variant mb-6">Prueba cambiando los filtros o el término de búsqueda.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider">
                    Ver todos los productos
                </a>
            </div>
        @else
            <!-- Responsive CSS Grid: 1 col (mobile), 2 cols (sm), 3 cols (lg), 4 cols (xl) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="product-grid">
                @foreach($products as $product)
                    <article class="group flex flex-col bg-surface-container-lowest rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-surface-container">
                        <!-- Imagen con Badges -->
                        <div class="relative w-full aspect-[4/3] bg-surface-container-low overflow-hidden rounded-t-xl">
                            <a href="{{ route('product.show', $product->slug) }}" class="block w-full h-full">
                                <img src="{{ $product->image_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" 
                                />
                            </a>

                            @if($product->badge)
                                <span class="absolute top-3 left-3 bg-primary text-white text-[11px] font-black uppercase px-2.5 py-1 rounded shadow-sm">
                                    {{ $product->badge }}
                                </span>
                            @endif

                            <button type="button" aria-label="Añadir a lista de deseos" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center text-on-surface hover:text-secondary-container transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-base">favorite</span>
                            </button>
                        </div>

                        <!-- Información y Conversión -->
                        <div class="p-5 flex flex-col flex-1 justify-between gap-4">
                            <div>
                                <!-- Rating y Categoría -->
                                <div class="flex items-center justify-between gap-2 mb-1.5">
                                    <div class="flex items-center gap-0.5 text-secondary-container text-xs">
                                        <span class="material-symbols-outlined filled text-sm">star</span>
                                        <span class="font-extrabold text-on-surface ml-0.5">{{ number_format($product->rating, 1) }}</span>
                                        <span class="text-on-surface-variant text-[11px]">({{ $product->reviews_count }})</span>
                                    </div>
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">
                                        {{ $product->category->name }}
                                    </span>
                                </div>

                                <a href="{{ route('product.show', $product->slug) }}" class="group-hover:text-secondary-container transition-colors">
                                    <h3 class="text-base font-extrabold text-primary tracking-tight line-clamp-1">
                                        {{ $product->name }}
                                    </h3>
                                </a>

                                <p class="text-xs text-on-surface-variant line-clamp-2 mt-1 leading-relaxed">
                                    {{ $product->description }}
                                </p>
                            </div>

                            <!-- Precio y Añadir al Carrito -->
                            <div class="pt-3 border-t border-surface-container flex items-center justify-between gap-3">
                                <div>
                                    @if($product->original_price)
                                        <span class="text-[11px] text-outline line-through block leading-none mb-0.5 font-bold">
                                            ${{ number_format($product->original_price, 2) }}
                                        </span>
                                    @endif
                                    <span class="text-lg font-black {{ $product->original_price ? 'text-secondary' : 'text-primary' }}">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                </div>

                                <form action="{{ route('cart.store') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="size" value="{{ $product->variants->first()?->size ?? 'Única' }}">
                                    <input type="hidden" name="color" value="{{ $product->variants->first()?->color_name ?? 'Estándar' }}">

                                    <button type="submit" class="bg-secondary-container text-white px-3.5 py-2 rounded-lg text-xs font-black uppercase tracking-wider hover:bg-secondary transition-colors shadow-sm flex items-center gap-1.5 transform active:scale-95">
                                        <span class="material-symbols-outlined text-base">shopping_cart</span>
                                        <span>Añadir</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Pilares de Valor (4 Columnas) -->
    <section class="w-full bg-surface-container-low py-14 border-y border-surface-container">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm flex items-start gap-4">
                    <span class="material-symbols-outlined text-3xl text-secondary-container shrink-0">local_shipping</span>
                    <div>
                        <h4 class="text-sm font-black uppercase tracking-wider text-primary mb-1">Envío Express Gratis</h4>
                        <p class="text-xs text-on-surface-variant leading-relaxed">Entregas en 24/48h en pedidos superiores a $240 con seguimiento en vivo.</p>
                    </div>
                </div>

                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm flex items-start gap-4">
                    <span class="material-symbols-outlined text-3xl text-secondary-container shrink-0">verified</span>
                    <div>
                        <h4 class="text-sm font-black uppercase tracking-wider text-primary mb-1">Tecnología Certificada</h4>
                        <p class="text-xs text-on-surface-variant leading-relaxed">Placas de carbono aeroespacial y polímeros testeados en túnel de viento.</p>
                    </div>
                </div>

                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm flex items-start gap-4">
                    <span class="material-symbols-outlined text-3xl text-secondary-container shrink-0">cached</span>
                    <div>
                        <h4 class="text-sm font-black uppercase tracking-wider text-primary mb-1">30 Días de Prueba Pro</h4>
                        <p class="text-xs text-on-surface-variant leading-relaxed">Prueba tu equipamiento en tus entrenamientos sin compromiso con cambio gratis.</p>
                    </div>
                </div>

                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm flex items-start gap-4">
                    <span class="material-symbols-outlined text-3xl text-secondary-container shrink-0">support_agent</span>
                    <div>
                        <h4 class="text-sm font-black uppercase tracking-wider text-primary mb-1">Asesoría Biomecánica</h4>
                        <p class="text-xs text-on-surface-variant leading-relaxed">Especialistas en running y entrenamiento disponibles para resolver tus dudas técnicas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Atletas -->
    <section class="w-full bg-primary text-white py-14">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-12 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-xl">
                <span class="text-xs font-black uppercase tracking-widest text-secondary-container block mb-1">Comunidad Kinetic // Drops Exclusivos</span>
                <h3 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-white mb-2">Recibe 15% OFF en tu primer pedido</h3>
                <p class="text-xs sm:text-sm text-outline-variant">Accede antes que nadie a lanzamientos limitados de calzado de competición y descuentos para atletas registrados.</p>
            </div>
            <form onsubmit="event.preventDefault(); alert('¡Gracias por unirte a Kinetic Sports! Usa el cupón KINETIC15 en tu carrito.');" class="w-full md:w-auto flex flex-col sm:flex-row gap-2">
                <input type="email" required placeholder="Ingresa tu correo electrónico..." class="bg-primary-container text-white px-4 py-3 rounded-lg text-xs placeholder:text-outline-variant focus:outline-none focus:ring-2 focus:ring-secondary-container border border-white/10 sm:w-80" />
                <button type="submit" class="bg-secondary-container text-white px-6 py-3 rounded-lg text-xs font-black uppercase tracking-wider hover:bg-secondary transition-colors whitespace-nowrap shadow-md">
                    Unirme Ahora
                </button>
            </form>
        </div>
    </section>
</div>
@endsection
