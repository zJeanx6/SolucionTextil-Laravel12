@php 
    $roleId = auth()->check() ? auth()->user()->role_id : null;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>{{ $title ?? 'Laravel' }}</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
    </head>

    <body class="min-h-screen bg-white dark:bg-zinc-800 overflow-x-hidden">
        
        <!-- Sección 1: Vistiendo al Mundo con Inspiración -->
        <section class="relative w-screen h-screen flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 w-full h-full">
                <img src="{{ asset('img/fondoPrincipal.jpg') }}" alt="Fashion Runway" class="w-full h-full object-cover parallax-img">
                <div class="absolute inset-0 bg-gradient-to-br from-black/30 via-black/40 to-black/50 dark:from-black/50 dark:via-black/60 dark:to-black/70"></div>
            </div>

            <div class="relative z-10 text-center text-white px-4 md:px-8 max-w-4xl">
                <div class="backdrop-blur-sm bg-black/20 dark:bg-black/30 rounded-3xl py-12 px-8 md:py-16 md:px-12 border border-white/10 flex flex-col items-center justify-center">
                    
                    <!-- Logo integrado de manera más sutil -->
                    <div class="mb-4">
                        <a class="hero-title relative z-20 flex items-center text-xl transform transition-all duration-1000 font-medium">
                            <span class="flex h-10 w-10 items-center justify-center rounded-md">
                                <x-app-logo-icon class="mr-2 h-7 fill-current text-white" />
                            </span> Solución Textil
                        </a>
                    </div>

                    <h1 class="hero-title text-4xl md:text-7xl font-bold leading-tight transform transition-all duration-1000 text-center">
                        Gestión Inteligente de Textiles<br>
                    </h1>
                    <p class="hero-subtitle text-lg md:text-2xl text-gray-300 dark:text-gray-200 font-light transform translate-y-8 transition-all duration-1000 delay-300 text-center mb-12">
                        Sistema web para optimizar el control de inventarios, maquinaria y mantenimiento en la industria textil.
                    </p>
                    
                    <!-- Botones integrados en el liquid glass -->
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        @auth
                            <!-- Usuario autenticado -->
                            <div class="flex flex-col sm:flex-row items-center gap-4">
                                <!-- Botón Dashboard -->
                                @if($roleId === 1)
                                    <a href="{{ route('dashboard') }}" wire:navigate class="group relative overflow-hidden backdrop-blur-sm bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/30 rounded-full px-6 py-3 text-white font-medium transition-all duration-300 flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                        <span>Dashboard</span>
                                    </a>
                                @elseif($roleId === 2)
                                    <a href="{{ route('admin.dashboard-inventory') }}" wire:navigate class="group relative overflow-hidden backdrop-blur-sm bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/30 rounded-full px-6 py-3 text-white font-medium transition-all duration-300 flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                        <span>Dashboard</span>
                                    </a>
                                @elseif($roleId === 3)
                                    <a href="{{ route('admin.dashboard-maintenance') }}" wire:navigate class="group relative overflow-hidden backdrop-blur-sm bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/30 rounded-full px-6 py-3 text-white font-medium transition-all duration-300 flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                        <span>Dashboard</span>
                                    </a>
                                @else
                                    <a href="{{ route('home') }}" wire:navigate class="group relative overflow-hidden backdrop-blur-sm bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/30 rounded-full px-6 py-3 text-white font-medium transition-all duration-300 flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                        <span>Inicio</span>
                                    </a>
                                @endif

                                <!-- Botón Perfil -->
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" class="group relative overflow-hidden backdrop-blur-sm bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/30 rounded-full px-6 py-3 text-white font-medium transition-all duration-300 flex items-center space-x-2">
                                        <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center text-xs font-semibold">
                                            {{ auth()->user()->initials() }}
                                        </div>
                                        <span>{{ auth()->user()->name }}</span>
                                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    
                                    <!-- Dropdown Menu -->
                                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute top-full mt-2 right-0 w-64 backdrop-blur-sm bg-black/40 border border-white/20 rounded-2xl shadow-xl z-50">
                                        <div class="p-4">
                                            <div class="flex items-center gap-3 mb-4 pb-4 border-b border-white/10">
                                                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-sm font-semibold text-white">
                                                    {{ auth()->user()->initials() }}
                                                </div>
                                                <div>
                                                    <p class="text-white font-medium">{{ auth()->user()->name }}</p>
                                                    <p class="text-gray-300 text-sm">{{ auth()->user()->email }}</p>
                                                    <p class="text-gray-400 text-xs">Rol: {{ auth()->user()->role->name }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="space-y-2">
                                                <a href="{{ route('settings.profile') }}" wire:navigate class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-white/10 text-white transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <span>Configuración</span>
                                                </a>
                                                
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="w-full flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-white/10 text-white transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                        </svg>
                                                        <span>Cerrar Sesión</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Usuario no autenticado -->
                            <a href="{{ route('login') }}" wire:navigate class="group relative overflow-hidden backdrop-blur-sm bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/30 rounded-full px-6 py-3 text-white font-medium transition-all duration-300 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Iniciar Sesión</span>
                            </a>
                        @endauth

                        <!-- Botón cambio de tema -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="group relative overflow-hidden backdrop-blur-sm bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/30 rounded-full px-6 py-3 text-white font-medium transition-all duration-300 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span>Tema</span>
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Theme Dropdown -->
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute top-full mt-2 right-0 w-48 backdrop-blur-sm bg-black/40 border border-white/20 rounded-2xl shadow-xl z-50">
                                <div class="p-4">
                                    <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" size="sm" class="w-full">
                                        <flux:radio value="light" icon="sun" class="flex-1 text-white border-white/20 hover:bg-white/10" />
                                        <flux:radio value="dark" icon="moon" class="flex-1 text-white border-white/20 hover:bg-white/10" />
                                        <flux:radio value="system" icon="computer-desktop" class="flex-1 text-white border-white/20 hover:bg-white/10" />
                                    </flux:radio.group>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Scroll indicator -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <div class="bg-white/20 backdrop-blur-sm rounded-full p-3">
                    <svg class="w-6 h-6 text-white dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
            </div>
        </section>

        <!-- Sección 2: Revolucionando la Industria Textil (Izquierda) -->
        <section class="relative w-screen h-screen flex items-center overflow-hidden bg-white dark:bg-neutral-800">
            <div class="absolute inset-0 w-full h-full">
                <img src="{{ asset('img/fondosection0.jpg') }}" alt="Textile Factory" class="w-full h-full object-cover parallax-img">
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/50 to-black/40 dark:from-black/70 dark:via-black/60 dark:to-black/50"></div>
            </div>
            <div class="relative z-10 text-white px-4 md:px-16 max-w-4xl ml-4 md:ml-16">
                <div class="backdrop-blur-sm bg-black/20 dark:bg-black/30 rounded-3xl py-12 px-8 md:py-16 md:px-12 border border-white/10 flex flex-col justify-center min-h-[400px]">
                    <h1 class="section-title text-3xl md:text-6xl font-bold mb-8 leading-tight transform transition-all duration-1000 text-center">
                        Revolucionando la Industria Textil<br>
                    </h1>
                    <div class="section-title space-y-6 text-base md:text-2xl text-gray-300 dark:text-gray-200 transform transition-all duration-1000 text-center">
                        <p class="slide-up-1">Eliminamos los registros manuales y optimizamos la gestión de recursos con tecnología Laravel y metodologías ágiles.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección 3: Control Inteligente de Maquinaria (Derecha) -->
        <section class="relative w-screen h-screen flex items-center justify-end overflow-hidden bg-gray-50 dark:bg-neutral-800">
            <div class="absolute inset-0 w-full h-full">
                <img src="{{ asset('img/fondosection1.jpg') }}" alt="Textile Threads" class="w-full h-full object-cover parallax-img">
                <div class="absolute inset-0 bg-gradient-to-l from-black/60 via-black/50 to-black/40 dark:from-black/70 dark:via-black/60 dark:to-black/50"></div>
            </div>
            <div class="relative z-10 text-white px-4 md:px-16 max-w-5xl mr-4 md:mr-16">
                <div class="backdrop-blur-sm bg-black/20 dark:bg-black/30 rounded-3xl py-12 px-8 md:py-16 md:px-12 border border-white/10 flex flex-col justify-center min-h-[500px]">
                    <h1 class="section-title text-3xl md:text-6xl font-bold mb-8 leading-tight transform transition-all duration-1000 text-center">
                        Sistema de Gestión<br>
                        <span class="text-gray-200 dark:text-gray-300">Integral</span>
                    </h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 text-right">
                        <!-- Gestión de Elementos -->
                        <div class="feature-card flex items-start space-x-4 transform translate-y-8 transition-all duration-1000 delay-200">
                            <div class="flex-shrink-0 w-12 h-12 bg-white/20 dark:bg-white/30 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg md:text-xl font-semibold mb-2 text-white">Gestión de Elementos</h3>
                                <p class="text-sm md:text-base text-gray-300 dark:text-gray-200">Control de compras y prestamos de materias primas y herramientas con trazabilidad total.</p>
                            </div>
                        </div>
                        
                        <!-- Gestión de Productos -->
                        <div class="feature-card flex items-start space-x-4 transform translate-y-8 transition-all duration-1000 delay-200">
                            <div class="flex-shrink-0 w-12 h-12 bg-white/20 dark:bg-white/30 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg md:text-xl font-semibold mb-2 text-white">Gestión de Productos</h3>
                                <p class="text-sm md:text-base text-gray-300 dark:text-gray-200">Controla la entrada y salida de productos con historial completo.</p>
                            </div>
                        </div>

                         <!-- Mantenimiento Programado -->
                        <div class="feature-card flex items-start space-x-4 transform translate-y-8 transition-all duration-1000 delay-400">
                            <div class="flex-shrink-0 w-12 h-12 bg-white/20 dark:bg-white/30 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg md:text-xl font-semibold mb-2 text-white">Mantenimiento Programado</h3>
                                <p class="text-sm md:text-base text-gray-300 dark:text-gray-200">Sistema de mantenimiento preventivo y correctivo con notificaciones automáticas.</p>
                            </div>
                        </div>

                        <!-- Gestión de Maquinaria -->
                        <div class="feature-card flex items-start space-x-4 transform translate-y-8 transition-all duration-1000 delay-400">
                            <div class="flex-shrink-0 w-12 h-12 bg-white/20 dark:bg-white/30 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg md:text-xl font-semibold mb-2 text-white">Gestión de Maquinaria</h3>
                                <p class="text-sm md:text-base text-gray-300 dark:text-gray-200">Control del estado y ubicación de equipos textiles con historial completo.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección 4: Preservamos la Esencia Creativa -->
        {{-- <section class="relative w-screen min-h-screen flex flex-col items-center justify-center overflow-hidden bg-gray-100 dark:bg-neutral-800">
            <div class="absolute inset-0 w-full h-full">
                <img src="{{ asset('img/captura.jpg') }}" alt="Textile Factory" class="w-full h-full object-cover parallax-img">
                <div class="absolute inset-0 bg-gradient-to-l from-black/60 via-black/50 to-black/40 dark:from-black/70 dark:via-black/60 dark:to-black/50"></div>
            </div>

            <!-- Contenido -->
            <div class="relative z-10 flex flex-col items-center justify-center px-4 md:px-8 py-16 w-full">
                <!-- Título con "liquid glass" -->
                <div class="backdrop-blur-sm bg-black/20 dark:bg-black/30 rounded-3xl py-8 px-8 md:py-10 md:px-12 border border-white/10 mb-16 flex items-center justify-center min-h-[120px]">
                    <h1 class="section-title text-3xl md:text-6xl font-bold text-gray-100 text-center transform scale-95 transition-all duration-1000">
                        Tecnología y Metodología
                    </h1>
                </div>

                <!-- Grid de imágenes -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 mb-16 max-w-6xl w-full px-4">
                    <div class="image-card relative group transition-all duration-1000 delay-200">
                        <div class="relative overflow-hidden rounded-2xl shadow-2xl dark:shadow-gray-900/50 border border-white/10">
                            <img src="{{ asset('img/pequeña1.jpg') }}" alt="Luxury Fabric" class="w-full h-48 md:h-64 object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 text-white">
                                <div class="backdrop-blur-sm bg-black/30 rounded-lg px-3 py-2 border border-white/20">
                                    <h4 class="font-semibold text-sm md:text-base">Telas de Lujo</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="image-card relative group transition-all duration-1000 delay-400">
                        <div class="relative overflow-hidden rounded-2xl shadow-2xl dark:shadow-gray-900/50 border border-white/10">
                            <img src="{{ asset('img/pequeña2.jpg') }}" alt="Thread Spools" class="w-full h-48 md:h-64 object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 text-white">
                                <div class="backdrop-blur-sm bg-black/30 rounded-lg px-3 py-2 border border-white/20">
                                    <h4 class="font-semibold text-sm md:text-base">Hilos Premium</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="image-card relative group transition-all duration-1000 delay-600">
                        <div class="relative overflow-hidden rounded-2xl shadow-2xl dark:shadow-gray-900/50 border border-white/10">
                            <img src="{{ asset('img/pequeña3.jpg') }}" alt="Textile Fibers" class="w-full h-48 md:h-64 object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 text-white">
                                <div class="backdrop-blur-sm bg-black/30 rounded-lg px-3 py-2 border border-white/20">
                                    <h4 class="font-semibold text-sm md:text-base">Fibras Naturales</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Texto final con el mismo efecto translúcido -->
                <div class="backdrop-blur-sm bg-black/20 dark:bg-black/30 rounded-2xl py-8 px-6 md:py-10 md:px-8 border border-white/10 max-w-4xl mx-4 flex items-center justify-center min-h-[120px]">
                    <p class="final-text text-base md:text-xl text-gray-100 text-center leading-relaxed transform transition-all duration-1000 delay-800">
                        Manejamos tus materias primas con el máximo cuidado, asegurando la calidad y la autenticidad de cada hilo. Tus creaciones nacen de la excelencia.
                    </p>
                </div>
            </div>
        </section> --}}

        <!-- Footer con color original -->
        <footer class="relative w-screen bg-black dark:bg-black overflow-hidden">
            <div class="relative z-10 px-4 md:px-8 py-16 md:py-20">
                <div class="max-w-7xl mx-auto">
                    <!-- Logo y descripción principal -->
                    <div class="text-center mb-16">
                        <div class="backdrop-blur-sm bg-white/10 dark:bg-white/5 rounded-3xl py-8 px-6 md:py-12 md:px-12 border border-white/10 inline-block">
                            <h2 class="text-3xl md:text-5xl font-bold text-white mb-4">Solución Textil</h2>
                            <p class="text-lg md:text-xl text-gray-300 dark:text-gray-400 max-w-2xl">
                                Innovación y tradición unidos para crear el futuro de la industria textil
                            </p>
                        </div>
                    </div>

                    <!-- Grid de información -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-12 mb-16">
                        <!-- Servicios -->
                        <div class="backdrop-blur-sm bg-white/5 dark:bg-white/5 rounded-2xl p-6 border border-white/10">
                            <h3 class="text-xl font-semibold text-white mb-4">Servicios</h3>
                            <ul class="space-y-2 text-gray-300 dark:text-gray-400">
                                <li class="hover:text-white transition-colors cursor-pointer">Reportes Diarios</li>
                                <li class="hover:text-white transition-colors cursor-pointer">Gestión de Productos</li>
                                <li class="hover:text-white transition-colors cursor-pointer">Gestión de Materiales</li>
                                <li class="hover:text-white transition-colors cursor-pointer">Gestinón de Mantenimiento</li>
                            </ul>
                        </div>

                        <!-- Tecnología -->
                        <div class="backdrop-blur-sm bg-white/5 dark:bg-white/5 rounded-2xl p-6 border border-white/10">
                            <h3 class="text-xl font-semibold text-white mb-4">Tecnología</h3>
                            <ul class="space-y-2 text-gray-300 dark:text-gray-400">
                                <li class="hover:text-white transition-colors cursor-pointer">Monitoreo en Tiempo Real</li>
                                <li class="hover:text-white transition-colors cursor-pointer">Automatización</li>
                                <li class="hover:text-white transition-colors cursor-pointer">Mantenimiento Predictivo</li>
                            </ul>
                        </div>

                        <!-- Contacto -->
                        <div class="backdrop-blur-sm bg-white/5 dark:bg-white/5 rounded-2xl p-6 border border-white/10">
                            <h3 class="text-xl font-semibold text-white mb-4">Contacto</h3>
                            <ul class="space-y-2 text-gray-300 dark:text-gray-400">
                                <li class="hover:text-white transition-colors cursor-pointer">info@soluciontextil.com.co</li>
                                <li class="hover:text-white transition-colors cursor-pointer"></li>
                                <li class="hover:text-white transition-colors cursor-pointer">Soporte 24/7</li>
                                <li class="hover:text-white transition-colors cursor-pointer">Chat en Vivo</li>
                            </ul>
                        </div>

                        <!-- Redes Sociales -->
                        <div class="backdrop-blur-sm bg-white/5 dark:bg-white/5 rounded-2xl p-6 border border-white/10">
                            <h3 class="text-xl font-semibold text-white mb-4">Síguenos</h3>
                            <div class="flex space-x-4">
                                <ul class="space-y-2 text-gray-300 dark:text-gray-400">
                                    <li class="hover:text-white transition-colors cursor-pointer">No disponible</li>
                                </ul>
                                {{-- <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center hover:bg-white/20 transition-colors cursor-pointer">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                    </svg>
                                </div>
                                <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center hover:bg-white/20 transition-colors cursor-pointer">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                    </svg>
                                </div>
                                <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center hover:bg-white/20 transition-colors cursor-pointer">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    <!-- Línea divisoria -->
                    <div class="border-t border-white/10 pt-8">
                        <div class="flex flex-col md:flex-row justify-between items-center">
                            <p class="text-gray-400 dark:text-gray-500 text-sm md:text-base mb-4 md:mb-0">
                                © 2025 Solución Textil. Todos los derechos reservados.
                            </p>
                            <div class="flex space-x-6 gap-6 text-sm text-gray-400 dark:text-gray-500">
                                <flux:modal.trigger name="privacy-policy">
                                    <span class="cursor-pointer hover:text-white transition-colors">
                                        Política de Privacidad
                                    </span>
                                </flux:modal.trigger>

                                <flux:modal.trigger name="terms-of-service">
                                    <span class="cursor-pointer hover:text-white transition-colors">
                                        Términos de Servicio
                                    </span>
                                </flux:modal.trigger>
                                <a class="hover:text-white transition-colors">V1.0.1</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Modal: Política de Privacidad -->
        <flux:modal name="privacy-policy" class="md:w-7xl">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Política de Privacidad</flux:heading>
                </div>
                <div class="flex">
                    <flux:spacer />
                    <flux:text class="space-y-5 leading-relaxed">
                        <h4 class="font-semibold">1. Introducción</h4>
                        <p>
                            Esta Política describe cómo <strong>Solución Textil</strong> (el “Software”)
                            recopila, usa, almacena y protege los datos personales de sus usuarios,
                            conforme a la Ley 1581 de 2012, el Decreto 1377 de 2013 y las mejores
                            prácticas internacionales.
                        </p>

                        <h4 class="font-semibold">2. Responsable del Tratamiento</h4>
                        <p>
                            El responsable es la persona natural que comercializa y opera el
                            Software. Para asuntos de datos personales: 
                            <em>info@soluciontextil.com.co</em>.
                        </p>

                        <h4 class="font-semibold">3. Datos que Recopilamos</h4>
                        <ul class="list-disc pl-5 space-y-1">
                            <li><strong>Identidad:</strong> nombre, documento.</li>
                            <li><strong>Contacto:</strong> correo electrónico, teléfono.</li>
                            <li><strong>Credenciales y rol:</strong> usuario, contraseñas cifradas.</li>
                            <li><strong>Uso:</strong> registros de actividad e inventario.</li>
                            <li><strong>Técnicos:</strong> IP, navegador, dispositivo.</li>
                        </ul>

                        <h4 class="font-semibold">4. Finalidades</h4>
                        <ol class="list-decimal pl-5 space-y-1">
                            <li>Prestación y mejora del servicio.</li>
                            <li>Autenticación y control de acceso.</li>
                            <li>Soporte y comunicaciones operativas.</li>
                            <li>Cumplimiento legal y contractual.</li>
                        </ol>

                        <h4 class="font-semibold">5. Base Legal</h4>
                        <p>Consentimiento, ejecución de contrato e interés legítimo.</p>

                        <h4 class="font-semibold">6. Cookies</h4>
                        <p>
                            Usamos cookies funcionales y de análisis. El usuario puede
                            deshabilitarlas, aunque ello puede afectar la experiencia.
                        </p>

                        <h4 class="font-semibold">7. Compartición y Transferencia</h4>
                        <p>
                            Compartimos datos solo con proveedores de infraestructura
                            y autoridades competentes. No vendemos ni alquilamos información.
                            Las transferencias internacionales cumplen salvaguardas legales.
                        </p>

                        <h4 class="font-semibold">8. Seguridad</h4>
                        <p>
                            Aplicamos cifrado, controles de acceso, copias de seguridad y
                            monitoreo continuo para prevenir accesos no autorizados.
                        </p>

                        <h4 class="font-semibold">9. Derechos del Titular</h4>
                        <p>
                            Acceso, rectificación, actualización, supresión y revocatoria,
                            solicitándolos a través de <em>info@soluciontextil.com.co</em>.
                        </p>

                        <h4 class="font-semibold">10. Conservación</h4>
                        <p>
                            Conservamos los datos mientras exista la relación contractual y
                            el tiempo necesario para obligaciones legales.
                        </p>

                        <h4 class="font-semibold">11. Cambios</h4>
                        <p>
                            Notificaremos modificaciones significativas mediante correo o avisos en el Software.
                        </p>
                    </flux:text>
                </div>
            </div>
        </flux:modal>

        <!-- Modal: Términos de Servicio -->
        <flux:modal name="terms-of-service" class="md:w-7x1">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Términos de Servicio</flux:heading>
                </div>
                <div class="flex">
                    <flux:spacer />
                    <flux:text class="space-y-5 leading-relaxed">
                        <h4 class="font-semibold">1. Aceptación</h4>
                        <p>
                            Al acceder o usar el Software, usted acepta estos Términos.
                            Si no está de acuerdo, absténgase de utilizarlo.
                        </p>

                        <h4 class="font-semibold">2. Definiciones</h4>
                        <p>
                            <strong>Software:</strong> aplicación web Solución Textil.  
                            <strong>Proveedor:</strong> titular y operador del Software.  
                            <strong>Licencia:</strong> derecho limitado, no exclusivo y revocable de uso.
                        </p>

                        <h4 class="font-semibold">3. Concesión de Licencia</h4>
                        <p>
                            El Proveedor otorga al Usuario una Licencia para uso interno,
                            sujeta al plan de suscripción vigente.
                        </p>

                        <h4 class="font-semibold">4. Propiedad Intelectual</h4>
                        <p>
                            Todo el contenido es propiedad del Proveedor y está protegido por
                            leyes de derechos de autor. El Usuario no adquiere ningún derecho
                            de propiedad intelectual.
                        </p>

                        <h4 class="font-semibold">5. Obligaciones del Usuario</h4>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Proporcionar información veraz y mantenerla actualizada.</li>
                            <li>Custodiar credenciales y reportar accesos no autorizados.</li>
                            <li>Usar el Software conforme a la ley y a estos Términos.</li>
                        </ul>

                        <h4 class="font-semibold">6. Restricciones</h4>
                        <ol class="list-decimal pl-5 space-y-1">
                            <li>No descompilar ni realizar ingeniería inversa.</li>
                            <li>No ceder ni sublicenciar la Licencia sin autorización.</li>
                            <li>No introducir código malicioso.</li>
                        </ol>

                        <h4 class="font-semibold">7. Pagos y Renovación</h4>
                        <p>
                            Los precios y períodos de facturación se detallan en el acuerdo
                            comercial. El impago puede suspender o cancelar la Licencia.
                        </p>

                        <h4 class="font-semibold">8. Soporte y Actualizaciones</h4>
                        <p>
                            Las actualizaciones forman parte de la Licencia y pueden
                            instalarse automáticamente.
                        </p>

                        <h4 class="font-semibold">9. Disponibilidad</h4>
                        <p>
                            El Proveedor emplea esfuerzos razonables para garantizar la
                            continuidad, pero pueden ocurrir interrupciones programadas o
                            imprevistas.
                        </p>

                        <h4 class="font-semibold">10. Exoneración de Garantías</h4>
                        <p>
                            El Software se suministra “tal cual” y “según disponibilidad”,
                            sin garantías explícitas o implícitas.
                        </p>

                        <h4 class="font-semibold">11. Limitación de Responsabilidad</h4>
                        <p>
                            La responsabilidad total del Proveedor no excederá el valor
                            pagado por el Usuario en los 12 meses anteriores al evento
                            que origine la reclamación.
                        </p>

                        <h4 class="font-semibold">12. Indemnización</h4>
                        <p>
                            El Usuario indemnizará al Proveedor por reclamaciones
                            derivadas del uso del Software en contravención de estos Términos.
                        </p>

                        <h4 class="font-semibold">13. Terminación</h4>
                        <p>
                            El Proveedor puede suspender o terminar la Licencia ante
                            incumplimientos. Tras la terminación, el Usuario debe cesar todo uso.
                        </p>

                        <h4 class="font-semibold">14. Ley Aplicable y Jurisdicción</h4>
                        <p>
                            Estos Términos se rigen por las leyes de Colombia; las disputas
                            se someterán a los tribunales competentes de Ibagué.
                        </p>

                        <h4 class="font-semibold">15. Modificaciones</h4>
                        <p>
                            El Proveedor puede modificar estos Términos y notificará los
                            cambios mediante el Software o por correo electrónico.
                        </p>
                    </flux:text>
                </div>
            </div>
        </flux:modal>


        <!-- JavaScript para animaciones de scroll -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Configuración del Intersection Observer
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -100px 0px'
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const element = entry.target;
                            
                            // Aplicar animaciones basadas en clases
                            if (element.classList.contains('hero-title')) {
                                element.style.transform = 'translateY(0)';
                                element.style.opacity = '1';
                                
                                setTimeout(() => {
                                    const subtitle = document.querySelector('.hero-subtitle');
                                    if (subtitle) {
                                        subtitle.style.transform = 'translateY(0)';
                                        subtitle.style.opacity = '1';
                                    }
                                }, 300);
                            }
                            
                            if (element.classList.contains('section-title')) {
                                element.style.transform = 'translateX(0) translateY(0) scale(1)';
                                element.style.opacity = '1';
                                
                                // Animar contenido relacionado
                                const content = element.closest('section').querySelector('.section-content');
                                if (content) {
                                    setTimeout(() => {
                                        content.style.transform = 'translateX(0)';
                                        content.style.opacity = '1';
                                    }, 400);
                                }
                                
                                // Animar feature cards
                                const cards = element.closest('section').querySelectorAll('.feature-card');
                                cards.forEach((card, index) => {
                                    setTimeout(() => {
                                        card.style.transform = 'translateY(0)';
                                        card.style.opacity = '1';
                                    }, 200 + (index * 200));
                                });
                            }
                            
                            if (element.classList.contains('image-card')) {
                                const cards = element.closest('section').querySelectorAll('.image-card');
                                cards.forEach((card, index) => {
                                    setTimeout(() => {
                                        card.style.transform = 'translateY(0)';
                                        card.style.opacity = '1';
                                    }, index * 200);
                                });
                                
                                setTimeout(() => {
                                    const finalText = document.querySelector('.final-text');
                                    if (finalText) {
                                        finalText.style.transform = 'translateY(0)';
                                        finalText.style.opacity = '1';
                                    }
                                }, 800);
                            }
                            
                            // Desconectar el observer después de la animación
                            observer.unobserve(element);
                        }
                    });
                }, observerOptions);

                // Observar elementos para animación
                const animatedElements = document.querySelectorAll('.hero-title, .section-title, .image-card');
                animatedElements.forEach(el => observer.observe(el));

                // Efecto parallax sutil SOLO en imágenes con la clase .parallax-img
                window.addEventListener('scroll', () => {
                    const scrolled = window.pageYOffset;
                    document.querySelectorAll('.parallax-img').forEach(img => {
                        const rate = scrolled * -0.2;
                        img.style.transform = `translateY(${rate}px)`;
                    });
                });

                // Animación inicial inmediata
                setTimeout(() => {
                    const heroTitle = document.querySelector('.hero-title');
                    if (heroTitle) {
                        heroTitle.style.transform = 'translateY(0)';
                        heroTitle.style.opacity = '1';
                        
                        setTimeout(() => {
                            const heroSubtitle = document.querySelector('.hero-subtitle');
                            if (heroSubtitle) {
                                heroSubtitle.style.transform = 'translateY(0)';
                                heroSubtitle.style.opacity = '1';
                            }
                        }, 300);
                    }
                }, 100);
            });
        </script>

        <style>
            /* Transiciones suaves SOLO para el cambio de tema */
            body {
                transition: background-color 0.3s ease;
            }
            
            section {
                transition: background-color 0.3s ease;
            }
            
            footer {
                transition: background-color 0.3s ease;
            }
            
            /* Transiciones para elementos con clases dark: */
            .bg-white,
            .dark\:bg-zinc-800,
            .dark\:bg-gray-900,
            .dark\:bg-gray-800,
            .dark\:bg-black {
                transition: background-color 0.3s ease;
            }
            
            .text-gray-200,
            .dark\:text-gray-300,
            .text-gray-300,
            .dark\:text-gray-200,
            .text-gray-700,
            .dark\:text-gray-300,
            .text-gray-900,
            .dark\:text-white,
            .text-gray-400,
            .dark\:text-gray-500 {
                transition: color 0.3s ease;
            }
            
            .backdrop-blur-sm {
                transition: background-color 0.3s ease, border-color 0.3s ease;
            }

            /* Inicializar elementos como invisibles para las animaciones */
            .hero-title,
            .hero-subtitle,
            .section-title,
            .section-content,
            .feature-card,
            .image-card,
            .final-text {
                opacity: 0;
            }

            /* Smooth scrolling */
            html {
                scroll-behavior: smooth;
            }

            /* Efectos adicionales para suavizar bordes */
            .backdrop-blur-sm {
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
            }

            /* Asegurar que las secciones ocupen toda la pantalla */
            section, footer {
                width: 100vw;
                position: relative;
            }

            /* Estilos para los botones con efecto liquid glass */
            .group:hover .absolute {
                transform: scale(1.1);
            }
            
            /* Animaciones para dropdowns */
            [x-cloak] { 
                display: none !important; 
            }
        </style>

        @fluxScripts
        @livewireScripts
    </body>
</html>
