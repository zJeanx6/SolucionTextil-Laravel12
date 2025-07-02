<x-layouts.app :title="'Crear Usuario'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.users.index')">Usuarios</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.users.create')">Crear</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button size="sm" variant="primary" :href="route('admin.users.index')">Volver</flux:button>
    </div>

    {{-- Formulario en dos columnas --}}
    <div class="card">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <flux:input class="hover-input" label="Documento" name="card"
                        placeholder="Escribe el documento de identidad del nuevo usuario" required />
                </div>
                <div>
                    <flux:input class="hover-input" label="Nombre" name="name"
                        placeholder="Escribe el nombre del nuevo usuario" required />
                </div>
                <div>
                    <flux:input class="hover-input" label="Apellido" name="last_name"
                        placeholder="Escribe el apellido del nuevo usuario" required />
                </div>
                <div>
                    <flux:input class="hover-input" label="Email" name="email"
                        placeholder="Escribe el email del nuevo usuario" required type="email" />
                </div>
                <div>
                    <flux:input class="hover-input" label="Teléfono" name="phone"
                        placeholder="Escribe el teléfono del nuevo usuario" required />
                </div>
                <div>
                    <flux:input class="hover-input" label="Contraseña" name="password"
                        placeholder="Escribe la contraseña del nuevo usuario" required type="password" />
                </div>
                <div>
                    <flux:input class="hover-input" label="Confirmar Contraseña" name="password_confirmation"
                        placeholder="Confirma la contraseña del nuevo usuario" required type="password" />
                </div>
                <div>
                    <label class="block mb-1">Rol</label>
                    <flux:select name="role_id" required>
                        <flux:select.option value="">Selecciona un rol</flux:select.option>
                        @foreach ($roles as $role)
                            <flux:select.option value="{{ $role->id }}">{{ $role->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <div>
                    <label class="block mb-1">Estado</label>
                    <flux:select name="state_id" required>
                        <flux:select.option value="">Selecciona un estado</flux:select.option>
                        @foreach ($states as $state)
                            <flux:select.option value="{{ $state->id }}">{{ $state->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <flux:button variant="primary" type="submit">
                    Crear
                </flux:button>
            </div>
        </form>
    </div>

</x-layouts.app>
