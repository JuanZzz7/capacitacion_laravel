@extends('layouts.app')

@section('title', 'Acceso Atleta // Kinetic Sports')

@section('content')
<div class="w-full min-h-[calc(100vh-160px)] flex flex-col justify-center items-center px-4 sm:px-6 py-10 bg-background">
    <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-12 rounded-2xl overflow-hidden shadow-2xl bg-surface-container-lowest border border-surface-container">
        
        <!-- Motivational Context Panel (Left: 5 cols) -->
        <div class="lg:col-span-5 relative flex flex-col justify-between p-8 sm:p-10 text-white bg-primary-container overflow-hidden min-h-[380px] lg:min-h-[600px]">
            <!-- Background Image with mix blend -->
            <div class="absolute inset-0 z-0 opacity-35 mix-blend-luminosity">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuAlkeiAyXR8sUK8e0HhiEC76XOFu80avZtywnr__d8pbP9XuJnLk-cz-dDDlOvfMRbUHkSgkqz9Gh5fFVSSGo_ojzVlXE0S2WydffqTmXpWkpMkF7UC5IRkLVp8zHk19ssuGxSXf7pDvgpjKFLb2WWP-sZ-ANPTyGY6hM9lWQIm-cmnSQG54hLYe4BIVZ5fWe8dWWgxp8he3fwVOoE2SgiqCsG7hFTCE-Q1V0BOMiJ0cqiqndOVheC_4Q" 
                     alt="Atleta en carrera" 
                     class="w-full h-full object-cover" />
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-primary-container via-primary-container/80 to-transparent z-0"></div>

            <!-- Header Branding -->
            <div class="relative z-10 flex flex-col gap-1">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-secondary-container text-white text-base font-black">
                        K
                    </span>
                    <span class="text-lg tracking-tight font-black uppercase text-white">
                        KINETIC<span class="text-secondary-fixed-dim">LAB</span>
                    </span>
                </div>
                <p class="text-[11px] uppercase tracking-wider text-on-primary-container font-bold">High-Performance Division</p>
            </div>

            <!-- Mid-Tier Offer Highlight -->
            <div class="relative z-10 my-auto py-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary-container/20 text-secondary-fixed-dim text-xs font-black uppercase mb-3 border border-secondary-container/30">
                    <span class="w-2 h-2 rounded-full bg-secondary-container animate-pulse"></span>
                    <span>Oferta de Bienvenida</span>
                </div>
                <h2 class="text-4xl sm:text-5xl font-black text-white leading-none mb-3">
                    15% OFF
                </h2>
                <p class="text-xs sm:text-sm text-surface-container-highest max-w-xs leading-relaxed">
                    Únete a la comunidad Kinetic y desata tu verdadero potencial atlético hoy mismo con el código <strong>KINETIC15</strong>.
                </p>
            </div>

            <!-- Footer Stats -->
            <div class="relative z-10 grid grid-cols-2 gap-4 bg-white/10 p-4 rounded-xl backdrop-blur-md border border-white/10">
                <div>
                    <div class="text-[10px] uppercase text-on-primary-container tracking-wider font-bold">Comunidad Pro</div>
                    <div class="text-base font-black text-white">120K+</div>
                </div>
                <div>
                    <div class="text-[10px] uppercase text-on-primary-container tracking-wider font-bold">Garantía Tech</div>
                    <div class="text-base font-black text-secondary-fixed-dim">100% Lab</div>
                </div>
            </div>
        </div>

        <!-- Main Authentication Form Container (Right: 7 cols) -->
        <div class="lg:col-span-7 flex flex-col p-6 sm:p-10 md:p-12 justify-center bg-surface-container-lowest">
            
            <!-- Segmented Navigation Control Tabs -->
            <div class="flex items-center p-1 rounded-xl bg-surface-container-low mb-6 max-w-md w-full mx-auto border border-surface-container" role="tablist">
                <button type="button" 
                        id="tab-login" 
                        onclick="switchTab('login')" 
                        class="flex-1 py-2 px-4 text-center rounded-lg text-xs font-black uppercase tracking-wider transition-all duration-200 {{ ($initialTab ?? 'login') === 'login' ? 'bg-surface-container-lowest text-primary shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}">
                    Iniciar Sesión
                </button>
                <button type="button" 
                        id="tab-register" 
                        onclick="switchTab('register')" 
                        class="flex-1 py-2 px-4 text-center rounded-lg text-xs font-black uppercase tracking-wider transition-all duration-200 {{ ($initialTab ?? 'login') === 'register' ? 'bg-surface-container-lowest text-primary shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}">
                    Crear Cuenta
                </button>
            </div>

            <!-- FORMULARIO LOGIN -->
            <div id="panel-login" class="w-full max-w-md mx-auto flex flex-col {{ ($initialTab ?? 'login') === 'register' ? 'hidden' : '' }}">
                <div class="mb-6 text-center sm:text-left">
                    <h2 class="text-2xl font-black text-primary tracking-tight">Bienvenido de vuelta</h2>
                    <p class="text-xs text-on-surface-variant mt-1">Ingresa tus credenciales para acceder a tu historial y pedidos.</p>
                </div>

                @if($errors->any() && old('_form') !== 'register')
                    <div class="bg-red-50 text-red-700 p-3 rounded-xl text-xs mb-4 border border-red-200">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ url('/login') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <input type="hidden" name="_form" value="login">

                    <div class="flex flex-col gap-1">
                        <label for="login-email" class="text-xs font-bold uppercase tracking-wider text-on-surface">Correo Electrónico</label>
                        <input type="email" 
                               id="login-email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               placeholder="tu@correo.com" 
                               class="bg-surface-container-low text-on-surface text-xs rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary border border-surface-container" 
                        />
                    </div>

                    <div class="flex flex-col gap-1">
                        <div class="flex justify-between items-center">
                            <label for="login-password" class="text-xs font-bold uppercase tracking-wider text-on-surface">Contraseña</label>
                            <a href="#" class="text-[11px] text-secondary hover:underline font-bold">¿Olvidaste tu contraseña?</a>
                        </div>
                        <input type="password" 
                               id="login-password" 
                               name="password" 
                               required 
                               placeholder="••••••••" 
                               class="bg-surface-container-low text-on-surface text-xs rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary border border-surface-container" 
                        />
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                        <label for="remember" class="text-xs text-on-surface-variant font-medium">Recordar mis datos en este dispositivo</label>
                    </div>

                    <button type="submit" class="w-full bg-secondary-container text-white py-3.5 px-6 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-secondary transition-all shadow-md mt-2 flex items-center justify-center gap-2">
                        <span>Acceder a Kinetic</span>
                        <span class="material-symbols-outlined text-base">login</span>
                    </button>
                </form>

                <!-- Demostración / Datos de Acceso Rápido -->
                <div class="mt-6 p-3 bg-surface-container-low rounded-xl border border-surface-container text-xs text-on-surface-variant flex items-center justify-between">
                    <span>Usuario de prueba: <strong>atleta@kineticsports.com</strong></span>
                    <button type="button" onclick="fillDemo()" class="text-secondary font-black hover:underline uppercase text-[10px]">
                        Rellenar
                    </button>
                </div>
            </div>

            <!-- FORMULARIO REGISTRO -->
            <div id="panel-register" class="w-full max-w-md mx-auto flex flex-col {{ ($initialTab ?? 'login') === 'register' ? '' : 'hidden' }}">
                <div class="mb-6 text-center sm:text-left">
                    <h2 class="text-2xl font-black text-primary tracking-tight">Crea tu Cuenta Pro</h2>
                    <p class="text-xs text-on-surface-variant mt-1">Únete a la división de alto rendimiento y recibe 15% OFF de bienvenida.</p>
                </div>

                @if($errors->any() && old('_form') === 'register')
                    <div class="bg-red-50 text-red-700 p-3 rounded-xl text-xs mb-4 border border-red-200">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ url('/registro') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <input type="hidden" name="_form" value="register">

                    <div class="flex flex-col gap-1">
                        <label for="reg-name" class="text-xs font-bold uppercase tracking-wider text-on-surface">Nombre Completo</label>
                        <input type="text" 
                               id="reg-name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               placeholder="Ej. Carlos Mendoza" 
                               class="bg-surface-container-low text-on-surface text-xs rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary border border-surface-container" 
                        />
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="reg-email" class="text-xs font-bold uppercase tracking-wider text-on-surface">Correo Electrónico</label>
                        <input type="email" 
                               id="reg-email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               placeholder="tu@correo.com" 
                               class="bg-surface-container-low text-on-surface text-xs rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary border border-surface-container" 
                        />
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="reg-password" class="text-xs font-bold uppercase tracking-wider text-on-surface">Contraseña (Mínimo 8 caracteres)</label>
                        <input type="password" 
                               id="reg-password" 
                               name="password" 
                               required 
                               placeholder="••••••••" 
                               class="bg-surface-container-low text-on-surface text-xs rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary border border-surface-container" 
                        />
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="reg-password-confirm" class="text-xs font-bold uppercase tracking-wider text-on-surface">Confirmar Contraseña</label>
                        <input type="password" 
                               id="reg-password-confirm" 
                               name="password_confirmation" 
                               required 
                               placeholder="••••••••" 
                               class="bg-surface-container-low text-on-surface text-xs rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary border border-surface-container" 
                        />
                    </div>

                    <button type="submit" class="w-full bg-secondary-container text-white py-3.5 px-6 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-secondary transition-all shadow-md mt-2 flex items-center justify-center gap-2">
                        <span>Registrarme y Obtener 15% OFF</span>
                        <span class="material-symbols-outlined text-base">person_add</span>
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    function switchTab(tab) {
        const loginTab = document.getElementById('tab-login');
        const registerTab = document.getElementById('tab-register');
        const loginPanel = document.getElementById('panel-login');
        const registerPanel = document.getElementById('panel-register');

        if (tab === 'login') {
            loginTab.classList.add('bg-surface-container-lowest', 'text-primary', 'shadow-sm');
            loginTab.classList.remove('text-on-surface-variant');
            registerTab.classList.remove('bg-surface-container-lowest', 'text-primary', 'shadow-sm');
            registerTab.classList.add('text-on-surface-variant');
            loginPanel.classList.remove('hidden');
            registerPanel.classList.add('hidden');
        } else {
            registerTab.classList.add('bg-surface-container-lowest', 'text-primary', 'shadow-sm');
            registerTab.classList.remove('text-on-surface-variant');
            loginTab.classList.remove('bg-surface-container-lowest', 'text-primary', 'shadow-sm');
            loginTab.classList.add('text-on-surface-variant');
            registerPanel.classList.remove('hidden');
            loginPanel.classList.add('hidden');
        }
    }

    function fillDemo() {
        document.getElementById('login-email').value = 'atleta@kineticsports.com';
        document.getElementById('login-password').value = 'password';
    }
</script>
@endsection
