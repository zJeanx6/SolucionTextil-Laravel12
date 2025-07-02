<div>
    <div class="breadcrumbs mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item icon="home" :href="route('dashboard')"/>
            <flux:breadcrumbs.item :href="route('admin.dashboard-inventory')">Reporte de Movimientos</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button size="sm" wire:click="exportExcel">Exportar Selección</flux:button>
    </div>

    <form wire:submit.prevent="render" class="card grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium mb-2">Tipo de movimiento</label>
            <flux:select wire:model.live="filters.type">
                <flux:select.option value="">Todos</flux:select.option>
                @foreach($types as $t)
                    <flux:select.option value="{{ $t }}">{{ $t }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2">Usuario encargado</label>
            <flux:select wire:model.live="filters.user_id">
                <flux:select.option value="">Todos</flux:select.option>
                @foreach($users as $user)
                    <flux:select.option value="{{ $user->card }}">
                        {{ $user->name }} {{ $user->last_name }}
                    </flux:select.option>
                @endforeach
            </flux:select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2">Proveedor/Destinatario</label>
            <flux:select wire:model.live="filters.party_id">
                <flux:select.option value="">Todos</flux:select.option>
                @foreach($parties as $id => $name)
                    <flux:select.option value="{{ $id }}">
                        {{ $name }}
                    </flux:select.option>
                @endforeach
            </flux:select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2">Elemento/Producto</label>
            <flux:input type="text" wire:model.live="filters.element_name" placeholder="Buscar nombre"/>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2">Cantidad mínima</label>
            <flux:input type="number" wire:model.live="filters.quantity_min"/>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2">Cantidad máxima</label>
            <flux:input type="number" wire:model.live="filters.quantity_max"/>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2">Desde</label>
            <flux:input type="date" wire:model.live="filters.start_date"/>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2">Hasta</label>
            <flux:input type="date" wire:model.live="filters.end_date"/>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2">Registros por página</label>
            <flux:select wire:model.live="filters.per_page">
                <flux:select.option value="10">10</flux:select.option>
                <flux:select.option value="20">20</flux:select.option>
                <flux:select.option value="50">50</flux:select.option>
                <flux:select.option value="100">100</flux:select.option>
            </flux:select>
        </div>
    </form>

    <div class="div-table">
        <table class="table">
            <thead class="head-table">
                <tr>
                    <th class="px-4 py-2">Fecha</th>
                    <th class="px-4 py-2">Tipo</th>
                    <th class="px-4 py-2">Elemento</th>
                    <th class="px-4 py-2">Encargado</th>
                    <th class="px-4 py-2">Destinatario/Proveedor</th>
                    <th class="px-4 py-2">Cantidad</th>
                    <th class="px-4 py-2">Unidad</th>
                    <th class="px-4 py-2">Movimiento</th>
                    <th class="px-4 py-2">Devuelto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $row)
                    <tr class="table-content">
                        <td class="px-4 py-1">{{ \Carbon\Carbon::parse($row->date)->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-1">{{ $row->type }}</td>
                        <td class="px-4 py-1">{{ $row->element_name }}</td>
                        <td class="px-4 py-1">{{ $row->user_name }}</td>
                        <td class="px-4 py-1">{{ $row->party_name }}</td>
                        <td class="px-4 py-1">{{ (int) $row->amount }}</td>
                        <td class="px-4 py-1">{{ $row->unit }}</td>
                        <td class="px-4 py-1">{{ $row->movement_type }}</td>
                        <td class="px-4 py-1">
                            @if($row->type === 'Prestamo')
                                {{ $row->return_date ? \Carbon\Carbon::parse($row->return_date)->format('Y-m-d H:i') : 'No' }}
                            @else
                                No aplica
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-gray-400 py-4">Sin resultados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $rows->links() }}
    </div>
</div>
