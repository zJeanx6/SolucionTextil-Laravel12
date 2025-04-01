<x-layouts.app>
<div class="mb-4 flex justify-between items-center">
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.roles.index')">Roles</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>
</div>

    <div class="card">
        <form action="{{route('admin.roles.update', $role)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <flux:input label="Nombre" name="name" value="{{old('name', $role->name)}}" placeholder="Escribe el nombre de un nuevo rol">Nuevo
                </flux:input>
            </div>

            <div class="mb-4">
                <flux:textarea label="Descripción" name="description"
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
