<div>
    <div class="breadcrumbs-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.elements.index')">Elementos</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="table">
            <thead class="head-table">
                <tr>
                    <th class="head-table-item">Codigo</th>
                    <th class="head-table-item">Nombre</th>
                    <th class="head-table-item">Stock Actual</th>
                    <th class="head-table-item">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($elements as $element)
                <tr class="table-content">
                    <td class="column-item">{{$element->code}}</td>
                    <td class="column-item">{{$element->name}}</td>
                    <td class="column-item">{{$element->stock}}</td>
                    <td class="column-item">
                        <div class="two-actions">
                            <flux:button.group>
                                <flux:button size="sm" variant="primary">Editar</flux:button>
                                <flux:button size="sm" variant="danger">Eliminar</flux:button>
                            </flux:button.group>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
