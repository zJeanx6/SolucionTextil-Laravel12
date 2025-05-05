<x-layouts.app :title="'Crear Usuario'">
    <div class="breadcrumbs-center">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.users.index')">Usuarios</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.users.create')">Crear</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    </div>

    <div class="card">
        <form action="{{route('admin.users.store')}}" method="POST">
            @csrf
            <div class="mb-4">
                <flux:input class="hover-input" label="Documento" name="card" placeholder="Escribe el documento de identidad del nuevo usuario">Documento</flux:input>
            </div>

            <div class="mb-4">
                <flux:input class="hover-input" label="Nombre" name="name" placeholder="Escribe el nombre del nuevo usuario">Nombre</flux:input>
            </div>

            <div class="mb-4">
                <flux:input class="hover-input" label="Apellido" name="last_name" placeholder="Escribe el apellido del nuevo usuario">Apellido</flux:input>
            </div>

            <div class="mb-4">
                <flux:input class="hover-input" label="Email" name="email" placeholder="Escribe el email del nuevo usuario">Email</flux:input>
            </div>

            <div class="mb-4">
                <flux:input class="hover-input" label="Teléfono" name="phone" placeholder="Escribe el teléfono del nuevo usuario">Telefono</flux:input>
            </div>

            <div class="mb-4">
                <flux:input class="hover-input" label="Contraseña" name="password" placeholder="Escribe la contraseña del nuevo usuario">Contraseña</flux:input>
            </div>
            <div class="mb-4">
                <flux:input class="hover-input" label="Confirmar Contraseña" name="password_confirmation" placeholder="Confirma la contraseña del nuevo usuario">Confirmar Contraseña</flux:input>
            </div>

            <div class="mb-4">
                <label>Rol</label>
                <select name="role_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Selecciona un rol</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label>Estado</label>
                <select name="state_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Selecciona un estado</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <flux:button variant="primary" type="submit">
                    Crear
                </flux:button>
            </div>
        </form>
    </div>

</x-layouts.app>