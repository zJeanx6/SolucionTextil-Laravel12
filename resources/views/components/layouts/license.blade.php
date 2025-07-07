<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
       <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>{{ $title ?? 'Laravel' }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        
        <!-- Estilo para notificaciones -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="mt-4 lg:hidden" icon="bars-2" inset="left" />

            <a href="{{ route('admin.sa.dashboard-sa') }}" class="ml-2 mr-5 flex items-center space-x-2 lg:ml-0" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="layout-grid" :href="route('admin.sa.dashboard-sa')" :current="request()->routeIs('admin.sa.dashboard-sa')" wire:navigate>
                    {{ __('Dashboard') }}
                </flux:navbar.item>
                <flux:navbar.item icon="layout-grid" :href="route('admin.sa.company-sa')" :current="request()->routeIs('admin.sa.company-sa')" wire:navigate>
                    {{ __('Empresas') }}
                </flux:navbar.item>
                <flux:navbar.item icon="layout-grid" :href="route('admin.sa.license-sa')" :current="request()->routeIs('admin.sa.license-sa')" wire:navigate>
                    {{ __('Licencias') }}
                </flux:navbar.item>
                <flux:navbar.item icon="layout-grid" :href="route('admin.sa.type-sa')" :current="request()->routeIs('admin.sa.type-sa')" wire:navigate>
                    {{ __('Tipos de licencia') }}
                </flux:navbar.item>
                <flux:navbar.item icon="layout-grid" :href="route('admin.sa.user-sa')" :current="request()->routeIs('admin.sa.user-sa')" wire:navigate>
                    {{ __('Administradores') }}
                </flux:navbar.item>
            </flux:navbar>

            <flux:spacer />

            <flux:navbar class="mr-1.5 space-x-0.5 py-0!">
            </flux:navbar>

            <!-- Desktop User Menu -->
            <flux:dropdown position="top" align="end">
                <flux:profile
                    class="cursor-pointer"
                    :initials="auth()->user()->initials()"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
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

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar stashable sticky class="lg:hidden border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('admin.sa.dashboard-sa') }}" class="ml-1 flex items-center space-x-2" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')">
                    <flux:navlist.item icon="layout-grid" :href="route('admin.sa.dashboard-sa')" :current="request()->routeIs('admin.sa.dashboard-sa')" wire:navigate>
                    {{ __('Dashboard') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>
        </flux:sidebar>

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
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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
