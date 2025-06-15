<x-layouts.app :title="'Estados'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.states.index')"> Estados </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    {{-- Tabla de contenido --}}
    <div class="div-table">
        <table class="table">
            <thead class="head-table">
                <tr>
                    <th class="head-table-item"> Nombre </th>
                    <th class="head-table-item"> Descripción </th>
                    <th class="head-table-item"> Acciones </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($states as $state)
                    <tr wire:key="estado-{{ $state->id }}" class="table-content">
                        <td class="column-item">{{ $state->name }}</td>
                        <td class="column-item">{{ $state->description }}</td>
                        <td class="column-item">
                            <div class="two-actions">
                                <form action="{{ route('admin.states.destroy', $state) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <flux:button.group>
                                        <flux:button icon="pencil-square" size="sm" variant="primary"
                                            :href="route('admin.states.edit', $state)" />
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

    {{-- Paginación --}}
    <div class="mx-4 mt-4 mb-4">{{ $states->links() }}</div>
    
</x-layouts.app>
