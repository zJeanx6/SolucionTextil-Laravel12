<x-layouts.app :title="'Crear Talla'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')"> Dashboard </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.sizes.index')"> Tallas </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.sizes.create')"> Crear </flux:breadcrumbs.item>
        </flux:breadcrumbs>
        
        <flux:button size="xs" variant="primary" :href="route('admin.sizes.index')"> Volver </flux:button>
    </div>

    {{-- Formulario/Tarjeta para crear talla. --}}
    <div class="card">
        <form action="{{ route('admin.sizes.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <flux:input class="hover-input" label="Nombre" name="name"
                    placeholder="Escribe el nombre de una nueva talla">Nuevo</flux:input>
            </div>

            <div class="mb-4">
                <flux:textarea class="dark:hover:bg-zinc-800" label="abbreviation" name="abbreviation"
                    placeholder="Ingresa una abreviacion para esta nueva talla" />
            </div>
            @error('description')
                *{{ $message }}
            @enderror

            <div class="flex justify-end">
                <flux:button size="sm" variant="primary" type="submit">
                    Crear
                </flux:button>
            </div>
        </form>
    </div>

</x-layouts.app>
