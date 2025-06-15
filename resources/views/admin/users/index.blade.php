<x-layouts.app :title="'Usuarios'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.users.index')"> Usuarios </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:button size="sm" variant="primary" :href="route('admin.users.create')"> Nuevo </flux:button>
    </div>

    {{-- Tabla de contenido --}}
    <div class="div-table">
        <table class="table">
            <thead class="head-table">
                <tr>
                    <th class="head-table-item"> Cedula </th>
                    <th class="head-table-item"> Nombre </th>
                    <th class="head-table-item"> Apellido </th>
                    <th class="head-table-item"> Acciones </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr wire:key="usuario-{{ $user->card }}" class="table-content">
                        <th class="column-item">{{ $user->card }}</th>
                        <td class="column-item">{{ $user->name }}</td>
                        <td class="column-item">{{ $user->last_name }}</td>
                        <td class="column-item">
                            <div class="two-actions">
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <flux:button.group>
                                        <flux:button size="sm" variant="primary"
                                            :href="route('admin.users.edit', $user)"> Ver </flux:button>
                                        <flux:button size="sm" variant="danger" onclick="confirmDelete(this)">
                                            Eliminar </flux:button>
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
