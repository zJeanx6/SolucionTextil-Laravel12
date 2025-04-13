<x-layouts.app>
    <div class="h-4 flex justify-between items-center top-8 z-10 px-4 mb-6">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.brands.index')">Marcas</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.brands.create')">Crear</flux:breadcrumbs.item>
    </flux:breadcrumbs>
</div>

    <div class="card">
        <form action="{{route('admin.brands.store')}}" method="POST">
            @csrf
            <div class="mb-4">
                <flux:input class="hover-input" label="Nombre" name="name" placeholder="Escribe el nombre de una nueva marca">Nuevo</flux:input>
            </div>
            <div class="flex justify-end"><flux:button variant="primary" type="submit">Guardar</flux:button></div>
        </form>
    </div>
</x-layouts.app>
