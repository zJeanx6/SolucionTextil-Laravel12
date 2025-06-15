@php
    // Obtiene el rol del usuario autenticado
    $userRole = auth()->user()->role->name;

    // Definición de los grupos de enlaces del menú
    $groups = [
        'Menú de Navegación' => [
            // Sección de enlaces para la Menú de Navegación
            [
                'name' => 'Inicio',
                'icon' => 'home',
                'url' => route('dashboard'),
                'current' => request()->routeIs('dashboard'),
                'roles' => ['administrador'],  // Solo visible para administradores
            ],
            [
                'name' => 'Visión General',
                'icon' => 'chart-pie',
                'url' => route('admin.dashboard-inventory'),
                'current' => request()->routeIs('admin.dashboard-inventory'),
                'roles' => ['administrador', 'inventario'],  // Visible para administradores y personal de inventario
            ],
            [
                'name' => 'Mantenimiento',
                'icon' => 'wrench',
                'url' => route('admin.dashboard-maintenance'),
                'current' => request()->routeIs('admin.dashboard-maintenance'),
                'roles' => ['administrador', 'mantenimiento'],  // Visible para administradores y personal de mantenimiento
            ],
        ],
        'Inventario' => [
            // Sección de enlaces relacionada al inventario
            [
                'name' => 'Elementos',
                'icon' => 'archive-box',
                'url' => route('admin.elements.index'),
                'current' => request()->routeIs('admin.elements.index'),
                'roles' => ['administrador', 'inventario'],
            ],
            [
                'name' => 'Mov. de Elementos',
                'icon' => 'arrow-right',
                'url' => route('admin.elements.movements'),
                'current' => request()->routeIs('admin.elements.movements'),
                'roles' => ['administrador', 'inventario'],
            ],
            [
                'name' => 'Productos',
                'icon' => 'shopping-bag',
                'url' => route('admin.products.index'),
                'current' => request()->routeIs('admin.products.index'),
                'roles' => ['administrador', 'inventario'],
            ],
            [
                'name' => 'Mov. de Productos',
                'icon' => 'arrow-right',
                'url' => route('admin.products.movements'),
                'current' => request()->routeIs('admin.products.movements'),
                'roles' => ['administrador', 'inventario'],
            ],
            [
                'name' => 'Máquinas',
                'icon' => 'cpu-chip',
                'url' => route('admin.machines.index'),
                'current' => request()->routeIs('admin.machines.index'),
                'roles' => ['administrador', 'mantenimiento'],
            ],
            [
                'name' => ' Ctrl. Mantenimiento',
                'icon' => 'clipboard-document-list',
                'url' => route('admin.maintenance.makemaintenance'),
                'current' => request()->routeIs('admin.maintenance.makemaintenance'),
                'roles' => ['administrador', 'mantenimiento'],
            ],
        ],
        'Utilidades' => [
            // Sección de enlaces relacionados a utilidades y configuraciones generales
            [
                'name' => 'Gestión de Roles',
                'icon' => 'user-group',
                'url' => route('admin.roles.index'),
                'current' => request()->routeIs('admin.roles.*'),
                'roles' => ['administrador'],  // Solo visible para administradores
            ],
            [
                'name' => 'Tamaño',
                'icon' => 'hashtag',
                'url' => route('admin.sizes.index'),
                'current' => request()->routeIs('admin.sizes.*'),
                'roles' => ['administrador'],
            ],
            [
                'name' => 'Colores',
                'icon' => 'swatch',
                'url' => route('admin.colors.index'),
                'current' => request()->routeIs('admin.colors.*'),
                'roles' => ['administrador'],
            ],
            [
                'name' => 'Estado de Estados',
                'icon' => 'chart-bar-square',
                'url' => route('admin.states.index'),
                'current' => request()->routeIs('admin.states.*'),
                'roles' => ['administrador'],
            ],
            [
                'name' => 'Marcas',
                'icon' => 'tag',
                'url' => route('admin.brands.index'),
                'current' => request()->routeIs('admin.brands.*'),
                'roles' => ['administrador'],
            ],
            [
                'name' => 'Categorías',
                'icon' => 'view-columns',
                'url' => route('admin.types.index'),
                'current' => request()->routeIs('admin.types.index'),
                'roles' => ['administrador'],
            ],
            [
                'name' => 'Mantenimientos',
                'icon' => 'wrench-screwdriver',
                'url' => route('admin.maintenance.index'),
                'current' => request()->routeIs('admin.maintenance.index'),
                'roles' => ['administrador'],
            ],
            [
                'name' => 'Proveedores',
                'icon' => 'users',
                'url' => route('admin.suppliers.index'),
                'current' => request()->routeIs('admin.suppliers.index'),
                'roles' => ['administrador'],
            ],
        ],
    ];

    // Filtra los enlaces de 'Utilidades' según el rol del usuario
    $ComplementoLinks = collect($groups['Utilidades'])->filter(fn($link) => in_array($userRole, $link['roles']));
    // Filtra los enlaces de 'Inventario' según el rol del usuario
    $ComplementoLinks2 = collect($groups['Inventario'])->filter(fn($link) => in_array($userRole, $link['roles']));
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>{{ $title ?? 'Laravel' }}</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

        <!-- Preconexión para la fuente de letras -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Estilo para notificaciones -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
    </head>

    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <!-- Sidebar con los enlaces de navegación -->
        <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            {{-- Validación para el icono del sidebar después de que el usuario se autentique --}}
            @php
                $roleId = auth()->check() ? auth()->user()->role_id : null;
            @endphp

            {{-- Verifica el rol del usuario y muestra el enlace adecuado en el logo --}}
            @if ($roleId === 4)
                <a href="{{ route('home') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                    <x-app-logo />
                </a>
            @elseif ($roleId === 1)
                <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                    <x-app-logo />
                </a>
            @elseif ($roleId === 2)
                <a href="{{ route('admin.dashboard-inventory') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                    <x-app-logo />
                </a>
            @elseif ($roleId === 3)
                <a href="{{ route('admin.dashboard-maintenance') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                    <x-app-logo />
                </a>
            @else
                <a href="{{ route('home') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                    <x-app-logo />
                </a>
            @endif

            <!-- Lista de navegación -->
            <flux:navlist variant="outline">

                <!-- Sección 'Menú de Navegación' -->
                <flux:navlist.group :heading="'Menú de Navegación'" class="grid">
                    @foreach ($groups['Menú de Navegación'] as $link)      
                        @if (in_array($userRole, $link['roles']))              
                            <flux:navlist.item :icon="$link['icon']" :href="$link['url']" :current="$link['current']"
                                wire:navigate>{{ $link['name'] }}</flux:navlist.item>
                        @endif
                    @endforeach
                </flux:navlist.group>

                <!-- Sección 'Utilidades' -->
                @if($ComplementoLinks->isNotEmpty())
                    <flux:navlist.group expandable :heading="'Utilidades'" :expanded="collect($groups['Utilidades'])->contains(fn($link)=>$link['current'])" class="grid">
                        @foreach ($groups['Utilidades'] as $link2)
                            @if (in_array($userRole, $link2['roles']))
                                <flux:navlist.item :icon="$link2['icon']" :href="$link2['url']" :current="$link2['current']"
                                    wire:navigate>{{ $link2['name'] }}</flux:navlist.item>
                            @endif
                        @endforeach
                    </flux:navlist.group>
                @endif

                <!-- Sección 'Inventario' -->
                @if($ComplementoLinks2->isNotEmpty())
                    <flux:navlist.group expandable :heading="'Inventario'" :expanded="collect($groups['Inventario'])->contains(fn($link)=>$link['current'])" class="grid">
                        @foreach ($groups['Inventario'] as $link3)
                            @if (in_array($userRole, $link3['roles']))
                                <flux:navlist.item :icon="$link3['icon']" :href="$link3['url']" :current="$link3['current']"
                                    wire:navigate>{{ $link3['name'] }}</flux:navlist.item>
                            @endif
                        @endforeach
                    </flux:navlist.group>
                @endif  

            </flux:navlist>

            <flux:spacer />

            <!-- Sección para la gestión de usuarios -->
            <flux:navlist variant="outline">                
                @if ($userRole === 'administrador')
                    <flux:navlist.item icon="users" :href="route('admin.users.index')" :current="request()->routeIs('admin.users.*')" wire:navigate>
                        {{ __('Usuarios') }}
                    </flux:navlist.item>
                @endif
            </flux:navlist>

            <!-- Menú de usuario en escritorio -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down" />

                <flux:menu class="w-[220px]">
                    <!-- Información del perfil -->
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <!-- Opciones de configuración y logout -->
                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('home')" icon="layout-grid" wire:navigate>{{ __('Home') }}</flux:menu.item>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <!-- Cerrar sesión -->
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Menú móvil de usuario -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

                <flux:menu>
                    <!-- Información del perfil móvil -->
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <!-- Opciones móviles -->
                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <!-- Cerrar sesión móvil -->
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <!-- Contenido principal -->
        <flux:main>
            {{ $slot }}
        </flux:main>

        @fluxScripts
        @livewireScripts
        @stack('js')

        <!-- Importación de librerías de notificaciones -->
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Notificaciones controladores Laravel -->
        <script data-navigate-once>
            @if (session('success'))
                var isDarkMode = document.documentElement.classList.contains('dark');
                var toastBackgroundColor = isDarkMode ?
                    'linear-gradient(to right, #444444, #666666)' :
                    'linear-gradient(to right, #333333, #666666)';
                Toastify({
                    text:"{{ session('success') }}",
                    duration: 1500,
                    gravity: "top",
                    position: "center",
                    className: "toast-notification",
                    style: {
                        borderRadius: "10px",
                        background: toastBackgroundColor
                    }
                }).showToast();
            @endif

            function confirmDelete(button) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esta acción!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#27272a',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.closest('form').submit();
                    }
                });
            }
        </script>

        <!-- Notificaciones componentes Livewire -->
        <script data-navigate-once>
            Livewire.on('event-confirm', (id) => {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esta acción!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#27272a',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteConfirmed', id);
                    }
                });
            });

            Livewire.on('event-notify', function(event) {
                var isDarkMode = document.documentElement.classList.contains('dark');
                var toastBackgroundColor = isDarkMode ?
                    'linear-gradient(to right, #444444, #666666)' :
                    'linear-gradient(to right, #333333, #666666)';
                Toastify({
                    text: event[0],
                    duration: 1500,
                    gravity: "top",
                    position: "center",
                    className: "toast-notification",
                    style: {
                        borderRadius: "10px",
                        background: toastBackgroundColor
                    }
                }).showToast();
            });
        </script>

    </body>
</html>
