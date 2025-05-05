<x-layouts.app :title="'Maquinas'">
    <div class="breadcrumbs-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.machines.index')">Maquinas</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
</x-layouts.app>