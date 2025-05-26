<x-layouts.app :title="'Editar Color'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')"> Dashboard </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.colors.index')"> Colores </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.colors.edit', $color)"> Editar </flux:breadcrumbs.item>

            <flux:button size="xs" variant="primary" :href="route('admin.colors.index')"> Volver </flux:button>
        </flux:breadcrumbs>
    </div>

    {{-- Formulario/Tarjeta para actualizar color. --}}
    <div class="card">
        <form action="{{ route('admin.colors.update', $color) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-4">
                <flux:input class="hover-input" label="Codigo" name="code" value="{{ old('code', $color->code) }}" placeholder="Escribe el codigo del color (opcional)"></flux:input>
            </div>

            <div class="mb-4">
                <flux:input class="hover-input" label="Nombre" name="name" value="{{ old('name', $color->name) }}" placeholder="Escribe el nombre del color"></flux:input>
            </div>

            <div class="flex justify-end">
                <flux:button variant="primary" type="submit">
                    Guardar
                </flux:button>
            </div>
        </form>
    </div>
    
</x-layouts.app>
