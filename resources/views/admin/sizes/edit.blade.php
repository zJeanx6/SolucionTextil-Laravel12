<x-layouts.app :title="'Editar Talla'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')"> Dashboard </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.sizes.index')"> Tallas </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.sizes.edit', $size)"> Editar </flux:breadcrumbs.item>
        </flux:breadcrumbs>
        
        <flux:button size="sm" variant="primary" :href="route('admin.sizes.index')"> Volver </flux:button>
    </div>

    {{-- Formulario/Tarjeta para actualizar talla. --}}
    <div class="card">
        <form action="{{ route('admin.sizes.update', $size) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-4">
                <flux:input class="hover-input" label="Nombre" name="name" value="{{ old('name', $size->name) }}"
                    placeholder="Escribe el nombre de una nueva talla">Nuevo</flux:input>
            </div>

            <div class="mb-4">
                <flux:textarea class="dark:hover:bg-zinc-800" label="Descripción" name="abbreviation"
                    placeholder="Ingresa una abreviacion para esta talla">{{ old('description', $size->abbreviation) }}
                </flux:textarea>
            </div>
            @error('description')
                *{{ $message }}
            @enderror

            <div class="flex justify-end">
                <flux:button size="sm" variant="primary" type="submit">
                    Guardar
                </flux:button>
            </div>
        </form>
    </div>

</x-layouts.app>
