<x-layouts.app :title="'Roles'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')"> Dashboard </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.roles.index')"> Roles </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    {{-- Tabla de contenido --}}
    <div class="div-table">
        <table class="table">
            <thead class="head-table">
                <tr>
                    <th class="head-table-item"> Nombre </th>
                    <th class="head-table-item "> Descripción </th>
                    <th class="head-table-item"> Acciones </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr wire:key="rol-{{ $role->id }}" class="table-content">
                        <td class="column-item">{{ $role->name }}</td>
                        <td class="column-item">{{ $role->description }}</td>
                        <td class="column-item">
                            <div class="two-actions">
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <flux:button.group>
                                        <flux:button icon="pencil-square" size="sm" variant="primary"
                                            :href="route('admin.roles.edit', $role)" />
                                        <flux:button icon="trash" size="sm" variant="danger" onclick="confirmDelete(this)" />
                                    </flux:button.group>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-layouts.app>
