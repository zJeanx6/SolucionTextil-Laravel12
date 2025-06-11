<x-layouts.app :title="__('Dashboard Inventory')">
    {{-- Migaja de pan --}}
    <div class="breadcrumbs mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('admin.dashboard-inventory')"> Inicio </flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('admin.dashboard-inventory')"> Resumen General Inventarios </flux:breadcrumbs.item>
        </flux:breadcrumbs>
        
        <flux:dropdown>
            <flux:button size="sm" variant="filled" icon:trailing="chevron-down"> Acciones </flux:button>
            <flux:menu>
                <flux:menu.group heading="Generar Reportes">
                    <flux:modal.trigger name="exportar-movimientos">
                        <flux:menu.item>Reporte Excel</flux:menu.item>
                    </flux:modal.trigger>
                </flux:menu.group>
                <flux:menu.group heading="Ingresar a">
                    <flux:menu.item :href="route('admin.elements.index')" wire:navigate> Inventario Elementos </flux:menu.item>
                    <flux:menu.item :href="route('admin.products.index')" wire:navigate> Inventario Productos </flux:menu.item>
                </flux:menu.group>
            </flux:menu>
        </flux:dropdown>
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
        <div class="flex flex-col flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 mb-4">
            @livewire('recent-element-movements-table')
        </div>
    </div>
</x-layouts.app>
