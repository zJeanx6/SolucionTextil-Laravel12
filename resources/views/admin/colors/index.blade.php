<x-layouts.app :title="'Colores'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')"> Dashboard </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.colors.index')"> Colores </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:button size="sm" variant="primary" :href="route('admin.colors.create')"> Nuevo </flux:button>
    </div>

    {{-- Tabla de contenido --}}
    <div class="div-table">
        <table class="table">
            <thead class="head-table">
                <tr>
                    <th class="head-table-item"> Codigo </th>
                    <th class="head-table-item"> Nombre </th>
                    <th class="head-table-item"> Acciones </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($colors as $color)
                    <tr wire:key="color-{{ $color->id }}" class="table-content">
                        <td class=column-item>#{{ $color->code }}</td>
                        <td class=column-item>{{ $color->name }}</td>
                        <td class="column-item">
                            <div class="two-actions">
                                <form action="{{ route('admin.colors.destroy', $color) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <flux:button.group>
                                        <flux:button icon="pencil-square" size="sm" variant="primary"
                                            :href="route('admin.colors.edit', $color)" />
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
    <div class="mx-4 mt-4 mb-4">{{ $colors->links() }}</div>

</x-layouts.app>
