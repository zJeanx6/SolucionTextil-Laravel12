<x-layouts.app :title="'Editar Rol'">
    
    {{-- Migaja de pan --}}
    <div class="breadcrumbs"> 
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.roles.index')"> Roles </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.roles.edit', $role)"> Editar </flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button size="sm" variant="primary" :href="route('admin.roles.index')"> Volver </flux:button>
    </div>

    {{-- Formulario/Tarjeta para actualizar rol. --}}
    <div class="card">
        <form action="{{route('admin.roles.update', $role)}}" method="POST">
            @csrf @method('PUT')

            <div class="mb-4">
                <flux:input class="hover-input" label="Nombre" name="name" value="{{old('name', $role->name)}}" placeholder="Escribe el nombre de un nuevo rol">Nuevo
                </flux:input>
            </div>

            <div class="mb-4">
                <flux:textarea class="dark:hover:bg-zinc-800" label="Descripción" name="description"
                    placeholder="Ingresa una descripción sobre este nuevo rol">{{old('description', $role->description)}}</flux:textarea>
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
