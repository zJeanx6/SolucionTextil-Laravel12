<x-layouts.app>
    <div class="h-4 flex justify-between items-center top-8 z-10 px-4 mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.roles.index')">Roles</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.roles.create')">Crear</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="card">
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <flux:input class="hover-input" label="Nombre" name="name"
                    placeholder="Escribe el nombre de un nuevo rol">Nuevo
                </flux:input>
            </div>

            <div class="mb-4">
                <flux:textarea class="dark:hover:bg-zinc-800"
                    label="Descripción" name="description" placeholder="Ingresa una descripción sobre este nuevo rol" />

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
