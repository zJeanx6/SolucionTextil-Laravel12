<x-layouts.app :title="'Crear Color'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')"> Dashboard </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.colors.index')"> Colores </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.colors.create')"> Crear </flux:breadcrumbs.item>

            <flux:button size="xs" variant="primary" :href="route('admin.colors.index')"> Volver </flux:button>
        </flux:breadcrumbs>
    </div>

    {{-- Formulario/Tarjeta para crear color. --}}
    <div class="card">
        <form action="{{ route('admin.colors.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <flux:input class="hover-input" label="Codigo" name="code"
                    placeholder="Escribe el codigo del color (opcional)"></flux:input>
            </div>

            <div class="mb-4">
                <flux:input class="hover-input" label="Nombre" name="name" placeholder="Escribe el nombre del color">
                </flux:input>
            </div>

            <div class="flex justify-end">
                <flux:button variant="primary" type="submit">Guardar</flux:button>
            </div>
        </form>
    </div>
    
</x-layouts.app>
