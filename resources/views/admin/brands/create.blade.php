<x-layouts.app :title="'Crear Marca'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')"> Dashboard </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.brands.index')"> Marcas </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.brands.create')"> Crear </flux:breadcrumbs.item>

            <flux:button size="sm" variant="primary" :href="route('admin.brands.index')"> Volver </flux:button>
        </flux:breadcrumbs>
    </div>

    {{-- Formulario/Tarjeta para crear marcas. --}}
    <div class="card">
        <form action="{{ route('admin.brands.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <flux:input class="hover-input" label="Nombre" name="name"
                    placeholder="Escribe el nombre de una nueva marca">Nuevo</flux:input>
            </div>

            <div class="flex justify-end">
                <flux:button size="sm" variant="primary" type="submit"> Guardar </flux:button>
            </div>
        </form>
    </div>
    
</x-layouts.app>
