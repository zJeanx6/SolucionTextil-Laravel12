@php
    $groups = [
        'Platform' => [
            [
                'name' => 'Dashboard',
                'icon' => 'home',
                'url' => route('dashboard'),
                'current' => request()->routeIs('dashboard'),
            ],

        ],
        'Users' => [
            [
                'name' => 'Usuarios',
                'icon' => 'users',
                'url' => route('admin.users.index'),
                'current' => request()->routeIs('admin.users.*'),
            ],
        ],
        'Complementos' => [
            [
                'name' => 'Tallas',
                'icon' => 'swatch',
                'url' => route('admin.sizes.index'),
                'current' => request()->routeIs('admin.sizes.*'),
            ],
            [
                'name' => 'Colores',
                'icon' => 'swatch',
                'url' => route('admin.colors.index'),
                'current' => request()->routeIs('admin.colors.*'),
            ],
            [
                'name' => 'Estados',
                'icon' => 'cpu-chip',
                'url' => route('admin.states.index'),
                'current' => request()->routeIs('admin.states.*'),
            ],
            [
                'name' => 'Roles',
                'icon' => 'user-plus',
                'url' => route('admin.roles.index'),
                'current' => request()->routeIs('admin.roles.*'),
            ],
            [
                'name' => 'Marcas',
                'icon' => 'globe-americas',
                'url' => route('admin.brands.index'),
                'current' => request()->routeIs('admin.brands.*'),
            ],
            [
                'name' => 'Tipos',
                'icon' => 'swatch',
                'url' => route('admin.types.index'),
                'current' => request()->routeIs('admin.types.index'),
            ],
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="'Platform'" class="grid">
                @foreach ($groups['Platform'] as $link)
                    <flux:navlist.item :icon="$link['icon']" :href="$link['url']" :current="$link['current']"
                        wire:navigate>{{ $link['name'] }}</flux:navlist.item>
                @endforeach
            </flux:navlist.group>
            <flux:navlist.group :heading="'Users'" class="grid">
                @foreach ($groups['Users'] as $link)
                    <flux:navlist.item :icon="$link['icon']" :href="$link['url']" :current="$link['current']"
                        wire:navigate>{{ $link['name'] }}</flux:navlist.item>
                @endforeach
            </flux:navlist.group>
            <flux:navlist.group expandable :heading="'Complementos'" :expanded="collect($groups['Complementos'])->contains(fn($link)=>$link['current'])" class="grid">
                @foreach ($groups['Complementos'] as $link2)
                    <flux:navlist.item :icon="$link2['icon']" :href="$link2['url']" :current="$link2['current']"
                        wire:navigate>{{ $link2['name'] }}</flux:navlist.item>
                @endforeach
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit"
                target="_blank">
                {{ __('Repository') }}
            </flux:navlist.item>

            <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits" target="_blank">
                {{ __('Documentation') }}
            </flux:navlist.item>
        </flux:navlist>

        <!-- Desktop User Menu -->
        <flux:dropdown position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
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

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
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
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
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

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
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

    {{ $slot }}

    @fluxScripts
</body>

</html>
