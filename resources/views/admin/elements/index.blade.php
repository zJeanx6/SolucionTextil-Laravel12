<x-layouts.app :title="'Elementos'">
    <div class="breadcrumbs-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.elements.index')">Elementos</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
</x-layouts.app>