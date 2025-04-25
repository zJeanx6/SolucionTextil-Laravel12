<x-layouts.app>
    <div class="h-4 flex justify-between items-center top-8 z-10 px-4 mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.colors.index')">Colores</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

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
