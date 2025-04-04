<x-layouts.app>
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.brands.index')">Marcas</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="card">
        <form class="" action="{{route('admin.brands.store')}}" method="POST">
            @csrf
            <div class="mb-4">
                <flux:input label="Nombre" name="name" placeholder="Escribe el nombre de una nueva marca">Nuevo
                </flux:input>
            </div>

            <div class="flex justify-end">
                <flux:button variant="primary" type="submit">
                    Guardar
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>
