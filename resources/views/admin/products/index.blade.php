<x-layouts.app :title="'Productos'">
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.products.index')">Productos</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
</x-layouts.app>