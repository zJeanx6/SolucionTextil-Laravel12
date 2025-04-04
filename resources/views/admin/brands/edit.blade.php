<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.brands.index')">Marcas</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    
        <div class="card">
            <form action="{{route('admin.brands.update', $brand)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <flux:input label="Nombre" name="name" value="{{old('name', $brand->name)}}" placeholder="Escribe el nombre de una nueva marca">Nuevo
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
    