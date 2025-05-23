<x-layouts.app :title="'Crear Estado'">
    <div class="breadcrumbs">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.states.index')">Estados</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.states.create')">Crear</flux:breadcrumbs.item>
    </flux:breadcrumbs>
</div>

    <div class="card">
        <form action="{{route('admin.states.store')}}" method="POST">
            @csrf
            <div class="mb-4">
                <flux:input class="hover-input" label="Nombre" name="name" placeholder="Escribe el nombre de un nuevo estado">Nuevo</flux:input>
            </div>

            <div class="mb-4">
                <flux:textarea class="dark:hover:bg-zinc-800"
                    label="Descripción" name="description" placeholder="Ingresa una descripción sobre este nuevo estado" />

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
