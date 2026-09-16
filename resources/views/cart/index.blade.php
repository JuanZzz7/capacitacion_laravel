@extends('layouts.app')

@section('title', 'Bolsa de Rendimiento // Kinetic Sports')

@section('content')
<div class="w-full max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-12 py-8">
    
    <!-- Top Micro Progress & Breadcrumbs -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <nav class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Tienda</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary font-black">Bolsa de Rendimiento</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-outline-variant">Paso Seguro</span>
        </nav>
        <div class="flex items-center gap-2 text-xs font-bold uppercase bg-surface-container-high text-on-surface px-3 py-1 rounded-full border border-surface-container">
            <span class="w-2 h-2 rounded-full bg-secondary-container animate-pulse"></span>
            <span>Sesión Reservada: 14:28 min</span>
        </div>
    </div>

    <!-- Title & Free Shipping Threshold Banner -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
        <div>
            <span class="text-xs font-black uppercase tracking-widest text-secondary-container">
                Fase 01 // Verificación de Artículos
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-primary tracking-tight mt-1">
                Tu Carrito de Compras 
                <span class="text-on-surface-variant font-medium text-lg">({{ $cartItems->sum('quantity') }} artículos)</span>
            </h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-xs font-black uppercase tracking-wider text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                <span>Continuar Comprando</span>
            </a>
        </div>
    </div>

    <!-- Medidor de Progreso: Envío Gratis Express ($240 Meta) -->
    <div class="w-full bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-surface-container mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3 text-xs sm:text-sm">
            <div class="flex items-center gap-2 font-black text-on-surface">
                <span class="material-symbols-outlined text-secondary-container filled text-xl">local_shipping</span>
                @if($remainingForFreeShipping > 0)
                    <span>¡Te faltan <span class="text-secondary-container font-extrabold">${{ number_format($remainingForFreeShipping, 2) }}</span> para conseguir Envío Gratis Express!</span>
                @else
                    <span class="text-emerald-600 font-extrabold">¡Felicidades! Has desbloqueado Envío Express 100% Gratis.</span>
                @endif
            </div>
            <span class="text-xs uppercase tracking-wider text-on-surface-variant font-bold">
                Meta ${{ number_format($freeShippingThreshold, 2) }} | Actual ${{ number_format($subtotal, 2) }}
            </span>
        </div>
        <div class="w-full bg-surface-container-high h-2.5 rounded-full overflow-hidden relative">
            <div class="bg-secondary-container h-full rounded-full transition-all duration-700 ease-out" 
                 style="width: {{ $shippingProgress }}%;">
            </div>
        </div>
    </div>

    @if($cartItems->isEmpty())
        <!-- Carrito Vacío -->
        <div class="bg-surface-container-lowest rounded-2xl p-16 text-center border border-surface-container shadow-sm my-8">
            <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">shopping_bag</span>
            <h2 class="text-xl font-black text-primary mb-2">Tu bolsa de rendimiento está vacía</h2>
            <p class="text-sm text-on-surface-variant max-w-md mx-auto mb-6">
                Aún no has agregado equipamiento técnico a tu carrito. Explora nuestra colección Pro-Series 2025.
            </p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-secondary-container text-white px-8 py-3.5 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-secondary transition-colors shadow-md">
                <span>Ver Catálogo Deportivo</span>
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </a>
        </div>
    @else
        <!-- Layout Master 2 Columnas -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Columna Izquierda: Lista de Productos (8 cols) -->
            <div class="lg:col-span-8 space-y-4">
                <!-- Encabezado de Tabla -->
                <div class="hidden sm:grid grid-cols-12 gap-4 px-5 py-2.5 text-xs font-black uppercase tracking-wider text-on-surface-variant bg-surface-container-low rounded-xl border border-surface-container">
                    <span class="col-span-6">Producto y Especificación</span>
                    <span class="col-span-2 text-center">Precio</span>
                    <span class="col-span-2 text-center">Cantidad</span>
                    <span class="col-span-2 text-right">Subtotal</span>
                </div>

                <!-- Items del Carrito -->
                @foreach($cartItems as $item)
                    <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-surface-container hover:border-outline-variant transition-all">
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-center">
                            
                            <!-- Miniatura y Detalles -->
                            <div class="sm:col-span-6 flex items-center gap-4">
                                <a href="{{ route('product.show', $item->product->slug) }}" class="relative w-20 h-20 sm:w-24 sm:h-24 bg-surface-container-low rounded-xl overflow-hidden shrink-0 block border border-surface-container">
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover" />
                                    @if($item->product->badge)
                                        <span class="absolute top-1 left-1 bg-primary text-white text-[9px] font-black uppercase px-1 py-0.5 rounded">
                                            {{ $item->product->badge }}
                                        </span>
                                    @endif
                                </a>
                                <div class="min-w-0 flex-1">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-secondary-container block">
                                        {{ $item->product->category->name }}
                                    </span>
                                    <a href="{{ route('product.show', $item->product->slug) }}" class="text-sm font-black text-primary hover:text-secondary-container transition-colors truncate block">
                                        {{ $item->product->name }}
                                    </a>
                                    <div class="flex flex-wrap gap-x-3 text-xs text-on-surface-variant mt-1">
                                        <span>Talla: <strong class="text-on-surface font-bold">{{ $item->size }}</strong></span>
                                        <span>Color: <strong class="text-on-surface font-bold">{{ $item->color }}</strong></span>
                                    </div>
                                    <div class="flex items-center gap-1.5 mt-2 text-[11px] text-emerald-600 font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>En Stock Inmediato</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Precio Unitario -->
                            <div class="sm:col-span-2 text-left sm:text-center">
                                <span class="sm:hidden text-xs text-on-surface-variant uppercase font-bold mr-2">Precio:</span>
                                <span class="text-sm font-black text-primary">${{ number_format($item->price, 2) }}</span>
                            </div>

                            <!-- Selector de Cantidad (+/-) -->
                            <div class="sm:col-span-2 flex items-center justify-start sm:justify-center gap-1">
                                <div class="flex items-center bg-surface-container-low rounded-xl p-1 border border-surface-container">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="decrease">
                                        <button type="submit" aria-label="Disminuir" class="w-7 h-7 rounded-lg bg-surface-container-lowest text-on-surface flex items-center justify-center hover:bg-surface-container transition-colors shadow-xs">
                                            <span class="material-symbols-outlined text-sm">remove</span>
                                        </button>
                                    </form>

                                    <span class="w-8 text-center text-xs font-black text-on-surface">
                                        {{ $item->quantity }}
                                    </span>

                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="increase">
                                        <button type="submit" aria-label="Aumentar" class="w-7 h-7 rounded-lg bg-surface-container-lowest text-on-surface flex items-center justify-center hover:bg-surface-container transition-colors shadow-xs">
                                            <span class="material-symbols-outlined text-sm">add</span>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Subtotal y Eliminar -->
                            <div class="sm:col-span-2 flex items-center justify-between sm:justify-end gap-3">
                                <div>
                                    <span class="sm:hidden text-xs text-on-surface-variant uppercase font-bold mr-2">Subtotal:</span>
                                    <span class="text-sm font-black text-primary">${{ number_format($item->subtotal, 2) }}</span>
                                </div>
                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Eliminar del carrito" class="p-1.5 text-outline hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Columna Derecha: Resumen del Pedido y Checkout (4 cols) -->
            <div class="lg:col-span-4 flex flex-col gap-6 sticky top-28">
                
                <!-- Cupón de Descuento -->
                <div class="bg-surface-container-lowest p-5 rounded-2xl border border-surface-container shadow-sm">
                    <span class="text-xs font-black uppercase tracking-wider text-primary block mb-2">
                        Código Promocional / Cupón
                    </span>
                    <form action="{{ route('cart.coupon') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" 
                               name="coupon_code" 
                               value="{{ $couponCode ?? '' }}"
                               placeholder="Ej. KINETIC15" 
                               class="flex-1 bg-surface-container-low text-on-surface text-xs font-bold uppercase rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary border border-surface-container" 
                        />
                        <button type="submit" class="bg-primary text-white px-4 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-primary-container transition-colors shadow-xs">
                            Aplicar
                        </button>
                    </form>
                    @if($couponCode)
                        <div class="flex items-center justify-between text-xs text-emerald-600 font-bold mt-2">
                            <span>Cupón {{ $couponCode }} activo (15% OFF)</span>
                            <span class="material-symbols-outlined text-sm">check_circle</span>
                        </div>
                    @else
                        <p class="text-[11px] text-on-surface-variant mt-1">Usa <strong>KINETIC15</strong> para un 15% de descuento.</p>
                    @endif
                </div>

                <!-- Resumen de Costos -->
                <div class="bg-surface-container-lowest p-6 rounded-2xl border border-surface-container shadow-sm flex flex-col gap-4">
                    <h3 class="text-sm font-black uppercase tracking-wider text-primary border-b border-surface-container pb-3">
                        Resumen de Compra
                    </h3>

                    <div class="space-y-2.5 text-xs">
                        <div class="flex justify-between text-on-surface-variant">
                            <span>Subtotal Artículos</span>
                            <span class="font-bold text-on-surface">${{ number_format($subtotal, 2) }}</span>
                        </div>

                        @if($discount > 0)
                            <div class="flex justify-between text-emerald-600 font-bold">
                                <span>Descuento Promocional (15%)</span>
                                <span>-${{ number_format($discount, 2) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between text-on-surface-variant">
                            <span>Envío Express</span>
                            @if($shippingCost == 0)
                                <span class="text-emerald-600 font-bold uppercase text-[11px]">Gratis</span>
                            @else
                                <span class="font-bold text-on-surface">${{ number_format($shippingCost, 2) }}</span>
                            @endif
                        </div>

                        <div class="border-t border-surface-container pt-3 flex justify-between items-baseline">
                            <span class="text-sm font-black uppercase text-primary">Total Estimado</span>
                            <span class="text-2xl font-black text-primary">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Botón Checkout / Pago Seguro -->
                    <form action="{{ route('cart.checkout') }}" method="POST" class="pt-2">
                        @csrf
                        <button type="submit" class="w-full bg-secondary-container text-white py-4 px-6 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-secondary transition-all shadow-lg flex items-center justify-center gap-2 transform active:scale-98">
                            <span class="material-symbols-outlined text-xl">lock</span>
                            <span>Proceder al Pago Seguro</span>
                        </button>
                    </form>

                    <!-- Sellos de Seguridad -->
                    <div class="pt-4 border-t border-surface-container text-center space-y-2">
                        <div class="flex items-center justify-center gap-4 text-outline">
                            <span class="material-symbols-outlined text-2xl" title="Pago Seguro SSL">security</span>
                            <span class="material-symbols-outlined text-2xl" title="Tarjetas de Crédito">credit_card</span>
                            <span class="material-symbols-outlined text-2xl" title="Garantía de Devolución">verified_user</span>
                        </div>
                        <span class="text-[10px] uppercase font-bold text-outline tracking-wider block">
                            Transacción Encriptada SSL de 256 Bits
                        </span>
                    </div>
                </div>

            </div>
        </div>
    @endif
</div>
@endsection
