@extends('layouts.app')

@section('title', $product->name . ' // Kinetic Sports')

@section('content')
<div class="flex flex-col w-full pb-16">
    <!-- Breadcrumbs -->
    <div class="max-w-[1440px] mx-auto w-full px-4 sm:px-6 lg:px-12 py-4">
        <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2 text-xs text-on-surface-variant uppercase tracking-wider font-bold">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Inicio</a>
            <span class="material-symbols-outlined text-sm text-outline">chevron_right</span>
            <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="hover:text-primary transition-colors">
                {{ $product->category->name }}
            </a>
            <span class="material-symbols-outlined text-sm text-outline">chevron_right</span>
            <span class="text-primary">{{ $product->name }}</span>
        </nav>
    </div>

    <!-- Main PDP 2-Column Section -->
    <section class="max-w-[1440px] mx-auto w-full px-4 sm:px-6 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Columna Izquierda: Galería e Imágenes Interactivas (7 cols) -->
            <div class="lg:col-span-7 flex flex-col gap-4">
                <!-- Contenedor Imagen Principal -->
                <div class="relative w-full aspect-[4/3] sm:aspect-[16/11] bg-surface-container-low rounded-2xl overflow-hidden shadow-sm border border-surface-container group">
                    <!-- Badges Flotantes -->
                    <div class="absolute top-4 left-4 z-10 flex flex-wrap gap-2">
                        @if($product->badge)
                            <span class="bg-secondary-container text-white text-[11px] font-black uppercase tracking-wider px-3 py-1 rounded-full shadow-sm flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">bolt</span>
                                {{ $product->badge }}
                            </span>
                        @endif
                        <span class="bg-primary-container text-white text-[11px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">local_shipping</span>
                            Envío Gratis
                        </span>
                    </div>

                    <!-- Botón Zoom Icon -->
                    <div class="absolute top-4 right-4 z-10 bg-white/80 backdrop-blur-md text-on-surface rounded-full p-2 shadow-sm flex items-center justify-center opacity-80 group-hover:opacity-100 transition-opacity">
                        <span class="material-symbols-outlined text-base">zoom_in</span>
                    </div>

                    <!-- Imagen Principal Interactiva -->
                    <div class="w-full h-full flex items-center justify-center p-6 bg-surface-container-low">
                        <img id="mainProductImage" 
                             src="{{ $product->image_url }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-contain transition-all duration-300 group-hover:scale-105" />
                    </div>
                </div>

                <!-- Miniaturas de Galería (si existen imágenes adicionales) -->
                @php
                    $allImages = collect([
                        ['url' => $product->image_url, 'label' => 'Vista Principal']
                    ])->concat($product->images->map(fn($img) => ['url' => $img->image_url, 'label' => $img->label ?? 'Ángulo Detalle']));
                @endphp

                <div class="grid grid-cols-4 gap-3" id="galleryThumbnails">
                    @foreach($allImages->take(4) as $idx => $img)
                        <button type="button" 
                                onclick="changeMainImage('{{ $img['url'] }}', this)" 
                                class="thumb-btn relative aspect-square bg-surface-container-lowest rounded-xl p-2 border transition-all flex flex-col items-center justify-between {{ $idx === 0 ? 'border-primary ring-2 ring-primary/20' : 'border-surface-container hover:border-outline' }}">
                            <div class="w-full h-full flex items-center justify-center overflow-hidden rounded-lg">
                                <img src="{{ $img['url'] }}" alt="{{ $img['label'] }}" class="w-full h-full object-contain pointer-events-none" />
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-tight text-on-surface-variant line-clamp-1 mt-1">
                                {{ $img['label'] }}
                            </span>
                        </button>
                    @endforeach
                </div>

                <!-- Telemetría Técnica Deportiva (4 Métricas Clave) -->
                <div class="bg-surface-container-low rounded-2xl p-4 grid grid-cols-2 sm:grid-cols-4 gap-3 text-center border border-surface-container">
                    <div class="bg-surface-container-lowest rounded-xl p-3 shadow-xs">
                        <span class="text-[10px] uppercase font-bold text-on-surface-variant block">Peso Neto</span>
                        <span class="text-base font-black text-primary">{{ $product->weight ?? '198 g' }}</span>
                        <span class="text-[10px] text-secondary font-bold block">Ultra Light</span>
                    </div>

                    <div class="bg-surface-container-lowest rounded-xl p-3 shadow-xs">
                        <span class="text-[10px] uppercase font-bold text-on-surface-variant block">Drop Talón-Punta</span>
                        <span class="text-base font-black text-primary">{{ $product->drop ?? '8 mm' }}</span>
                        <span class="text-[10px] text-on-surface-variant font-bold block">Pro Dynamic</span>
                    </div>

                    <div class="bg-surface-container-lowest rounded-xl p-3 shadow-xs">
                        <span class="text-[10px] uppercase font-bold text-on-surface-variant block">Placa Propulsión</span>
                        <span class="text-base font-black text-primary">{{ $product->plate ?? 'Full Carbon' }}</span>
                        <span class="text-[10px] text-secondary font-bold block">Reactiva</span>
                    </div>

                    <div class="bg-surface-container-lowest rounded-xl p-3 shadow-xs">
                        <span class="text-[10px] uppercase font-bold text-on-surface-variant block">Uso Óptimo</span>
                        <span class="text-base font-black text-primary">{{ $product->optimal_use ?? 'Competición' }}</span>
                        <span class="text-[10px] text-on-surface-variant font-bold block">Lab-Series</span>
                    </div>
                </div>

                <!-- Pestañas de Especificaciones Detalladas -->
                <div class="bg-surface-container-lowest rounded-2xl p-6 border border-surface-container mt-2">
                    <h3 class="text-sm font-black uppercase tracking-wider text-primary mb-3">Descripción e Ingeniería Técnica</h3>
                    <div class="text-xs sm:text-sm text-on-surface-variant leading-relaxed space-y-3 whitespace-pre-line">
                        {{ $product->details ?? $product->description }}
                    </div>

                    <div class="mt-6 pt-4 border-t border-surface-container grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary-container text-base">verified</span>
                            <span>Garantía de fábrica Kinetic de 2 años</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary-container text-base">local_shipping</span>
                            <span>Envío protegido con seguimiento GPS</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Configuración, Precio y Conversión (5 cols) -->
            <div class="lg:col-span-5 flex flex-col gap-6 sticky top-28">
                
                <!-- Encabezado de Producto -->
                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-black uppercase tracking-widest text-secondary">
                            KINETIC PERFORMANCE // LAB SERIES
                        </span>
                        <span class="bg-surface-container-high text-on-surface text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-wider">
                            Ref: {{ $product->reference ?? 'KP-REF-2025' }}
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-black text-primary tracking-tight leading-tight">
                        {{ $product->name }}
                    </h1>

                    <!-- Social Proof / Reviews -->
                    <div class="flex items-center gap-2 mt-1">
                        <div class="flex items-center text-secondary-container">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="material-symbols-outlined filled text-base">star</span>
                            @endfor
                        </div>
                        <span class="text-xs font-black text-on-surface ml-1">{{ number_format($product->rating, 1) }}</span>
                        <span class="text-outline text-xs">•</span>
                        <span class="text-xs text-secondary font-bold">{{ $product->reviews_count }} opiniones verificadas</span>
                    </div>
                </div>

                <!-- Tarjeta de Precio y Facilidades -->
                <div class="bg-surface-container-low rounded-2xl p-5 flex flex-col gap-2 border border-surface-container">
                    <div class="flex items-baseline gap-3">
                        <span class="text-3xl font-black text-primary">${{ number_format($product->price, 2) }}</span>
                        @if($product->original_price)
                            <span class="text-base text-outline line-through font-bold">${{ number_format($product->original_price, 2) }}</span>
                            <span class="bg-secondary-container text-white text-[11px] font-black uppercase px-2 py-0.5 rounded">
                                -{{ $product->discount_percentage }}% OFF
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 text-xs text-on-surface-variant mt-1">
                        <span class="material-symbols-outlined text-base text-secondary">credit_card</span>
                        <span>o <strong>3 cuotas sin interés de ${{ number_format($product->price / 3, 2) }}</strong> con tarjetas de crédito</span>
                    </div>

                    <div class="flex items-center gap-2 text-[11px] text-on-surface-variant font-bold pt-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Stock disponible para despacho inmediato desde el almacén central</span>
                    </div>
                </div>

                <!-- Formulario de Conversión: Color, Talla, Cantidad -->
                <form action="{{ route('cart.store') }}" method="POST" id="addToCartForm" class="flex flex-col gap-5">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <!-- Selector de Color Interactivo -->
                    @php
                        $uniqueColors = $product->variants->unique('color_name');
                        $firstColor = $uniqueColors->first()?->color_name ?? 'Negro / Naranja Lava';
                    @endphp

                    <div class="flex flex-col gap-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-black uppercase tracking-wider text-on-surface">
                                Color: <span id="colorLabel" class="text-secondary font-extrabold normal-case">{{ $firstColor }}</span>
                            </span>
                            <span class="text-on-surface-variant">{{ $uniqueColors->count() }} opciones</span>
                        </div>

                        <input type="hidden" name="color" id="selectedColorInput" value="{{ $firstColor }}">
                        <div class="flex items-center gap-3">
                            @foreach($uniqueColors as $idx => $v)
                                <button type="button" 
                                        onclick="selectProductColor('{{ $v->color_name }}', this)" 
                                        title="{{ $v->color_name }}"
                                        class="color-btn relative w-9 h-9 rounded-full flex items-center justify-center p-0.5 shadow-sm transition-transform hover:scale-110 {{ $idx === 0 ? 'ring-2 ring-primary ring-offset-2' : '' }}">
                                    <span class="w-full h-full rounded-full border border-black/10" style="background-color: {{ $v->color_hex ?? '#0A192F' }}"></span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Selector de Tallas Grid -->
                    @php
                        $sizes = $product->variants->pluck('size')->unique()->filter()->values();
                        $firstSize = $sizes->first() ?? '42 EU';
                    @endphp

                    <div class="flex flex-col gap-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-black uppercase tracking-wider text-on-surface">
                                Talla Seleccionada: <span id="sizeLabel" class="text-primary font-black">{{ $firstSize }}</span>
                            </span>
                            <a href="#" class="text-secondary underline hover:text-primary transition-colors font-bold">Guía de Tallas</a>
                        </div>

                        <input type="hidden" name="size" id="selectedSizeInput" value="{{ $firstSize }}">
                        <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                            @foreach($sizes as $idx => $size)
                                <button type="button" 
                                        onclick="selectProductSize('{{ $size }}', this)" 
                                        class="size-btn py-2.5 px-2 rounded-lg text-xs font-black uppercase text-center transition-all border {{ $idx === 0 ? 'bg-primary text-white border-primary shadow-sm' : 'bg-surface-container-lowest text-on-surface border-surface-container hover:border-primary' }}">
                                    {{ $size }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Selector de Cantidad y Botón Añadir -->
                    <div class="flex items-center gap-3 pt-2">
                        <!-- Contador +/- -->
                        <div class="flex items-center bg-surface-container-low rounded-xl p-1 border border-surface-container">
                            <button type="button" onclick="adjustQty(-1)" class="w-9 h-9 rounded-lg bg-surface-container-lowest text-on-surface flex items-center justify-center hover:bg-surface-container transition-colors shadow-xs">
                                <span class="material-symbols-outlined text-base">remove</span>
                            </button>
                            <input type="number" id="quantityInput" name="quantity" value="1" min="1" max="10" readonly class="w-10 text-center bg-transparent text-sm font-black text-on-surface focus:outline-none" />
                            <button type="button" onclick="adjustQty(1)" class="w-9 h-9 rounded-lg bg-surface-container-lowest text-on-surface flex items-center justify-center hover:bg-surface-container transition-colors shadow-xs">
                                <span class="material-symbols-outlined text-base">add</span>
                            </button>
                        </div>

                        <!-- Botón Añadir a la Bolsa -->
                        <button type="submit" class="flex-1 bg-secondary-container text-white py-3.5 px-6 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-secondary transition-all shadow-md flex items-center justify-center gap-2 transform active:scale-98">
                            <span class="material-symbols-outlined text-xl">shopping_bag</span>
                            <span>Añadir a la Bolsa</span>
                        </button>
                    </div>
                </form>

                <!-- Estimación de Entrega -->
                <div class="bg-surface-container-lowest rounded-xl p-4 border border-surface-container flex items-center gap-3 text-xs">
                    <span class="material-symbols-outlined text-2xl text-secondary-container shrink-0">local_shipping</span>
                    <div>
                        <span class="font-bold text-on-surface block">Entrega estimada: 24 a 48 horas</span>
                        <span class="text-on-surface-variant">Envío gratuito a domicilio en pedidos mayores a $240.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Productos Relacionados -->
    @if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
        <section class="max-w-[1440px] mx-auto w-full px-4 sm:px-6 lg:px-12 pt-16">
            <div class="border-t border-surface-container pt-10">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-black uppercase text-primary tracking-tight">Equipamiento Relacionado</h3>
                    <a href="{{ route('home') }}" class="text-xs font-bold uppercase tracking-wider text-secondary hover:underline">Ver todo</a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $rel)
                        <article class="bg-surface-container-lowest rounded-xl p-4 border border-surface-container hover:shadow-lg transition-all group">
                            <a href="{{ route('product.show', $rel->slug) }}" class="block aspect-[4/3] rounded-lg overflow-hidden bg-surface-container-low mb-3">
                                <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            </a>
                            <span class="text-[10px] font-bold uppercase text-on-surface-variant block mb-1">{{ $rel->category->name }}</span>
                            <a href="{{ route('product.show', $rel->slug) }}" class="text-sm font-black text-primary group-hover:text-secondary-container transition-colors line-clamp-1">
                                {{ $rel->name }}
                            </a>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="text-sm font-black text-primary">${{ number_format($rel->price, 2) }}</span>
                                <a href="{{ route('product.show', $rel->slug) }}" class="text-xs font-bold text-secondary hover:underline">Ver ficha</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>

<script>
    function changeMainImage(url, btn) {
        document.getElementById('mainProductImage').src = url;
        document.querySelectorAll('.thumb-btn').forEach(el => {
            el.classList.remove('border-primary', 'ring-2', 'ring-primary/20');
            el.classList.add('border-surface-container');
        });
        btn.classList.add('border-primary', 'ring-2', 'ring-primary/20');
        btn.classList.remove('border-surface-container');
    }

    function selectProductColor(colorName, btn) {
        document.getElementById('selectedColorInput').value = colorName;
        document.getElementById('colorLabel').textContent = colorName;
        document.querySelectorAll('.color-btn').forEach(el => {
            el.classList.remove('ring-2', 'ring-primary', 'ring-offset-2');
        });
        btn.classList.add('ring-2', 'ring-primary', 'ring-offset-2');
    }

    function selectProductSize(size, btn) {
        document.getElementById('selectedSizeInput').value = size;
        document.getElementById('sizeLabel').textContent = size;
        document.querySelectorAll('.size-btn').forEach(el => {
            el.classList.remove('bg-primary', 'text-white', 'border-primary', 'shadow-sm');
            el.classList.add('bg-surface-container-lowest', 'text-on-surface', 'border-surface-container');
        });
        btn.classList.add('bg-primary', 'text-white', 'border-primary', 'shadow-sm');
        btn.classList.remove('bg-surface-container-lowest', 'text-on-surface', 'border-surface-container');
    }

    function adjustQty(amount) {
        const input = document.getElementById('quantityInput');
        let current = parseInt(input.value) || 1;
        current = Math.max(1, Math.min(10, current + amount));
        input.value = current;
    }
</script>
@endsection
