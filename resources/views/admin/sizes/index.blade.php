<x-layouts.app :title="'Tallas'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.sizes.index')"> Tallas </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:button size="sm" variant="primary" :href="route('admin.sizes.create')"> Nuevo </flux:button>
    </div>

    {{-- Tabla de contenido --}}
    <div class="div-table">
        <table class="table">
            <thead class="head-table">
                <tr>
                    <th class="head-table-item"> Nombre </th>
                    <th class="head-table-item"> Abreviación </th>
                    <th class="head-table-item"> Acciones </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sizes as $size)
                    <tr wire:key="size-{{ $size->id }}" class="table-content">
                        <td class="column-item">{{ $size->name }}</td>
                        <td class="column-item">{{ $size->abbreviation }}</td>
                        <td class="column-item">
                            <div class="two-actions">
                                <form action="{{ route('admin.sizes.destroy', $size) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <flux:button.group>
                                        <flux:button icon="pencil-square" size="sm" variant="primary"
                                            :href="route('admin.sizes.edit', $size)" />
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

</x-layouts.app>
