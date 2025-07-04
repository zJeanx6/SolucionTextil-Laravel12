<x-layouts.app :title="'Crear Talla'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.sizes.index')"> Tallas </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.sizes.create')"> Crear </flux:breadcrumbs.item>
        </flux:breadcrumbs>
        
        <flux:button size="sm" variant="primary" :href="route('admin.sizes.index')"> Volver </flux:button>
    </div>

    {{-- Formulario/Tarjeta para crear talla. --}}
    <div class="card">
        <form action="{{ route('admin.sizes.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <flux:input class="hover-input" label="Nombre" name="name"
                    placeholder="Ingrese el nombre de la talla (p. ej. Extra Grande, Pequeño)">Nuevo</flux:input>
            </div>

            <div class="mb-4">
                <flux:input class="hover-input" label="abbreviation" name="abbreviation"
                    placeholder="Ingrese la abreviatura de la talla (p. ej. S, M, L)" />
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
