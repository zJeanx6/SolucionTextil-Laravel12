<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.roles.index')">Roles</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.roles.create')">Crear</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="card">
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <flux:input label="Nombre" name="name" placeholder="Escribe el nombre de un nuevo rol">Nuevo
                </flux:input>
            </div>

            <div class="mb-4">
                <flux:textarea label="Descripción" name="description"
                    placeholder="Ingresa una descripción sobre este nuevo rol"></flux:textarea>
            </div>
            @error('description')
                *{{ $message }}
            @enderror

            <div class="flex justify-end">
                <flux:button variant="primary" type="submit">
                    Crear
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>
