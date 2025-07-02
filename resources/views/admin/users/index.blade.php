<x-layouts.app :title="'Usuarios'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.users.index')">Gestión de Usuarios</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button size="sm" variant="primary" :href="route('admin.users.create')">Nuevo</flux:button>
    </div>

    {{-- Tabla de usuarios --}}
    <div class="div-table">
        <table class="table">
            <thead class="head-table">
                <tr>
                    <th class="head-table-item">Cédula</th>
                    <th class="head-table-item">Nombre</th>
                    <th class="head-table-item">Apellido</th>
                    <th class="head-table-item">Email</th>
                    <th class="head-table-item">Teléfono</th>
                    <th class="head-table-item">Rol</th>
                    <th class="head-table-item">Estado</th>
                    <th class="head-table-item">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr wire:key="usuario-{{ $user->card }}" class="table-content">
                        <td class="column-item">{{ $user->card }}</td>
                        <td class="column-item">{{ $user->name }}</td>
                        <td class="column-item">{{ $user->last_name }}</td>
                        <td class="column-item">{{ $user->email }}</td>
                        <td class="column-item">{{ $user->phone }}</td>
                        <td class="column-item">{{ $user->role->name ?? '-' }}</td>
                        <td class="column-item">
                            <span class="{{ $user->state_id == 1 ? 'px-2 py-1 rounded-full text-sm font-semibold text-white bg-green-600' : 'px-2 py-1 rounded-full text-sm font-semibold text-white bg-red-600' }}">
                                {{ $user->state->name ?? '-' }}
                            </span>
                        </td>
                        <td class="column-item">
                            <div class="two-actions">
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <flux:button.group>
                                        <flux:button icon="pencil-square" size="sm" variant="primary"
                                            :href="route('admin.users.edit', $user)" />
                                        <flux:button icon="trash" size="sm" variant="danger"
                                            onclick="confirmDelete(this)" />
                                    </flux:button.group>          
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mx-4 mt-4 mb-4">{{ $users->links() }}</div>

</x-layouts.app>
