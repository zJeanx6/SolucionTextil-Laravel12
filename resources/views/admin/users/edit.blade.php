<x-layouts.app :title="'Editar Usuario'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.users.index')">Usuarios</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.users.edit', $user)">Editar</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:button size="xs" variant="primary" :href="route('admin.users.index')">Volver</flux:button>
    </div>

    {{-- Formulario/Tarjeta para actualizar talla. --}}
    <div class="card">
        <h2 class="text-2xl font-bold mb-4">Ver / Editar Usuario</h2>
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="mb-4">
                <flux:input class="hover-input" label="Documento" name="card" value="{{ old('card', $user->card) }}">
                </flux:input>
            </div>

            <div class="mb-4">
                <flux:input class="hover-input" label="Nombre" name="name" value="{{ old('name', $user->name) }}">
                </flux:input>
            </div>

            <div class="mb-4">
                <flux:input class="hover-input" label="Apellido" name="last_name"
                    value="{{ old('lastname', $user->last_name) }}"></flux:input>
            </div>

            <div class="mb-4">
                <flux:input class="hover-input" label="Email" name="email" value="{{ old('email', $user->email) }}">
                </flux:input>
            </div>

            <div class="mb-4">
                <flux:input class="hover-input" label="Teléfono" name="phone"
                    value="{{ old('phone', $user->phone) }}"></flux:input>
            </div>

            <div class="mb-4">
                <flux:input class="hover-input" label="Contraseña" name="password"
                    placeholder="Dejar en blanco si no se va a cambiar"></flux:input>
            </div>
            <div class="mb-4">
                <flux:input class="hover-input" label="Confirmar Contraseña" name="password_confirmation"
                    placeholder="Confirmar la nueva contraseña"></flux:input>
            </div>

            <div class="mb-4">
                <select name="role_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Selecciona un rol</option>
                    @foreach ($roles as $role)
                        <option value="{{ old('role_id', $role->id) }}"
                            @if (old('role_id', $user->role_id) == $role->id) selected @endif>
                            {{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label>Estado</label>
                <select name="state_id" class="hover-input w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Selecciona un estado</option>
                    @foreach ($states as $state)
                        <option value="{{ old('state_id', $state->id) }}"
                            @if (old('state_id', $user->state_id) == $state->id) selected @endif>
                            {{ $state->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <flux:button variant="primary" type="submit">
                    Guardar
                </flux:button>
            </div>
        </form>
    </div>

</x-layouts.app>
