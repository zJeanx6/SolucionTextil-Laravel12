<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div
        class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
        <div
            class="bg-muted relative hidden h-full flex-col p-10 text-white lg:flex dark:border-r dark:border-neutral-800">
            <div class="absolute inset-0 bg-neutral-900"
                style="background-image: url('{{ asset('img/index/fondoPrincipal.jpg') }}'); background-size: cover; background-position: center;">
            </div>
            <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium" wire:navigate>
                <span class="flex h-10 w-10 items-center justify-center rounded-md">
                    <x-app-logo-icon class="mr-2 h-7 fill-current text-white" />
                </span>
                {{ config('app.name', 'Laravel') }}
            </a>
            @php
                [($message = 'Desarrollado por Aprendices SENA'), ($author = 'Jean Roa & Daniela Manrique')];
                $author_url_1 = 'https://github.com/zJeanx6'; // URL del primer autor
                $author_url_2 = 'https://github.com/DaielaM1805'; // URL del segundo autor
            @endphp

            <div class="relative z-20 mt-auto">
                <blockquote class="space-y-2">
                    <flux:heading size="lg" class="text-white">&ldquo;{{ trim($message) }}&rdquo;</flux:heading>
                    <footer>
                        <flux:heading class="text-white"> <a href="{{ $author_url_1 }}" target="_blank"
                                class="underline">{{ trim('Jean Roa') }}</a> &
                            <a href="{{ $author_url_2 }}" target="_blank"
                                class="underline">{{ trim('Daniela Manrique') }}</a>
                        </flux:heading>
                    </footer>
                </blockquote>
            </div>
        </div>
        <div class="w-full lg:p-8">
            <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden"
                    wire:navigate>
                    <span class="flex h-9 w-9 items-center justify-center rounded-md">
                        <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
                    </span>

                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                {{ $slot }}
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>
