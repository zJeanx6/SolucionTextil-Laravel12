<x-layouts.app :title="'Editar Usuario'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.users.index')">Usuarios</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.users.edit', $user)">Editar</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button size="sm" variant="primary" :href="route('admin.users.index')">Volver</flux:button>
    </div>

    <div class="card">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <flux:input class="hover-input" label="Documento" name="card" value="{{ old('card', $user->card) }}" required />
                </div>
                <div>
                    <flux:input class="hover-input" label="Nombre" name="name" value="{{ old('name', $user->name) }}" required />
                </div>
                <div>
                    <flux:input class="hover-input" label="Apellido" name="last_name" value="{{ old('last_name', $user->last_name) }}" required />
                </div>
                <div>
                    <flux:input class="hover-input" label="Email" name="email" value="{{ old('email', $user->email) }}" required type="email" />
                </div>
                <div>
                    <flux:input class="hover-input" label="Teléfono" name="phone" value="{{ old('phone', $user->phone) }}" required />
                </div>
                <div>
                    <flux:input class="hover-input" label="Contraseña" name="password"
                        placeholder="Dejar en blanco si no se va a cambiar" type="password" />
                </div>
                <div>
                    <flux:input class="hover-input" label="Confirmar Contraseña" name="password_confirmation"
                        placeholder="Confirmar la nueva contraseña" type="password" />
                </div>
                <div>
                    <label class="block mb-1">Rol</label>
                    <flux:select name="role_id" required>
                        <option value="">Selecciona un rol</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @if (old('role_id', $user->role_id) == $role->id) selected @endif>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </flux:select>
                </div>
                <div>
                    <label class="block mb-1">Estado</label>
                    <flux:select name="state_id" required>
                        <option value="">Selecciona un estado</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}" @if (old('state_id', $user->state_id) == $state->id) selected @endif>
                                {{ $state->name }}
                            </option>
                        @endforeach
                    </flux:select>
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <flux:button variant="primary" type="submit">
                    Guardar
                </flux:button>
            </div>
        </form>
    </div>

</x-layouts.app>
