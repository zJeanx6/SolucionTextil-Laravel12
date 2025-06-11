<x-layouts.app :title="__('Dashboard Maintenance')">
    {{-- Migaka de pan --}}
        <div class="breadcrumbs mb-4">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('dashboard')"> Inicio </flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('admin.dashboard-maintenance')"> Resumen General Mantenimientos</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            @livewire('recent-maintenance-table')
        </div>
    </div>
</x-layouts.app>


