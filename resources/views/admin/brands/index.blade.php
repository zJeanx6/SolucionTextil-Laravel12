<x-layouts.app :title="'Marcas'">

    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.brands.index')"> Marcas </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:button size="sm" variant="primary" :href="route('admin.brands.create')"> Nuevo </flux:button>
    </div>

    {{-- Tabla de contenido --}}
    <div class="div-table">
        <table class="table">
            <thead class="head-table">
                <tr>
                    <th class="head-table-item"> Nombre </th>
                    <th class="head-table-item"> Acciones </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $brand)
                    <tr wire:key="marca-{{ $brand->id }}" class="table-content">
                        <td class="column-item">{{ $brand->name }}</td>
                        <td class="column-item">
                            <div class="two-actions">
                                <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <flux:button.group>
                                        <flux:button icon="pencil-square" size="sm" variant="primary"
                                            :href="route('admin.brands.edit', $brand)" />
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
    <div class="mx-4 mt-4 mb-4">{{ $brands->links() }}</div>

</x-layouts.app>
