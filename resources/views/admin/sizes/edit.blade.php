<x-layouts.app>
    <div class="h-4 flex justify-between items-center top-8 z-10 px-4 mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.sizes.index')">Tallas</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="card">
        <form action="{{ route('admin.sizes.update', $size) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-4">
                <flux:input class="hover-input" label="Nombre" name="name" value="{{ old('name', $size->name) }}" placeholder="Escribe el nombre de una nueva talla">Nuevo</flux:input>
            </div>

            <div class="mb-4">
                <flux:textarea class="dark:hover:bg-zinc-800" label="Descripción" name="abbreviation"
                        placeholder="Ingresa una abreviacion para esta talla">{{old('description', $size->abbreviation)}}</flux:textarea>
                </div>
                @error('description')
                *{{$message}} 
                @enderror

                <div class="flex justify-end">
                    <flux:button variant="primary" type="submit">
                        Guardar
                    </flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>
