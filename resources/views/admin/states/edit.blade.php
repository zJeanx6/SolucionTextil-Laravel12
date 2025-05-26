<x-layouts.app :title="'Editar Estado'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')"> Dashboard </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.states.index')"> Estados </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.states.edit', $state)"> Editar </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:button size="xs" variant="primary" :href="route('admin.states.index')"> Volver </flux:button>
    </div>

    {{-- Formulario/Tarjeta para actualizar estado. --}}
    <div class="card">
        <form action="{{ route('admin.states.update', $state) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-4">
                <flux:input class="hover-input" label="Nombre" name="name" value="{{ old('name', $state->name) }}"
                    placeholder="Escribe el nombre del nuevo estado">Nuevo</flux:input>
            </div>

            <div class="mb-4">
                <flux:textarea class="dark:hover:bg-zinc-800" label="Descripción" name="description"
                    placeholder="Ingresa una descripción sobre este nuevo rol">
                    {{ old('description', $state->description) }}</flux:textarea>
            </div>
            @error('description')
                *{{ $message }}
            @enderror

            <div class="flex justify-end">
                <flux:button variant="primary" type="submit">
                    Guardar
                </flux:button>
            </div>
        </form>
    </div>

</x-layouts.app>
