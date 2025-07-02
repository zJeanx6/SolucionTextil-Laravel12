<div>
    {{-- Migaja de pan --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item icon="home" :href="route('dashboard')"/>
            <flux:breadcrumbs.item :href="route('admin.dashboard.reportes')"> Gestión de Reportes </flux:breadcrumbs.item>
        </flux:breadcrumbs>
        
        {{-- Botón Exportar --}}
        <flux:button size="sm" wire:click="exportExcel"> Exportar Selección </flux:button>
    </div>

    {{-- Filtros --}}
    <form wire:submit.prevent="render" class="card grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium mb-2">Tipo de reporte</label>
            <flux:select wire:model.live="reportType" class="w-full border rounded-md px-2 py-1">
                <flux:select.option value="products">Productos</flux:select.option>
                <flux:select.option value="elements">Elementos</flux:select.option>
                <flux:select.option value="machines">Máquinas</flux:select.option>
                <flux:select.option value="maintenances">Mantenimientos</flux:select.option>
            </flux:select>
        </div>

        @if($reportType === 'products')
            <div>
                <label class="block text-sm font-medium mb-2">Tipo de producto</label>
                <flux:select wire:model.live="filters.product_type_id" class="w-full border rounded-md px-2 py-1">
                    <flux:select.option value="">Todos</flux:select.option>
                    @foreach($productTypes as $id => $name)
                        <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        @endif

        @if($reportType === 'elements')
            <div>
                <label class="block text-sm font-medium mb-2">Tipo de elemento</label>
                <flux:select wire:model.live="filters.element_type_id" class="w-full border rounded-md px-2 py-1">
                    <flux:select.option value="">Todos</flux:select.option>
                    @foreach($elementTypes as $id => $name)
                        <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        @endif

        @if($reportType === 'machines')
            <div>
                <label class="block text-sm font-medium mb-2">Tipo de máquina</label>
                <flux:select wire:model.live="filters.machine_type_id" class="w-full border rounded-md px-2 py-1">
                    <flux:select.option value="">Todos</flux:select.option>
                    @foreach($machineTypes as $id => $name)
                        <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Marca</label>
                <flux:select wire:model.live="filters.brand_id" class="w-full border rounded-md px-2 py-1">
                    <flux:select.option value="">Todas</flux:select.option>
                    @foreach($brands as $id => $name)
                        <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Estado</label>
                <flux:select wire:model.live="filters.state_id" class="w-full border rounded-md px-2 py-1">
                    <flux:select.option value="">Todos</flux:select.option>
                    @foreach($states as $id => $name)
                        <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        @endif

        @if($reportType === 'maintenances')
            <div>
                <label class="block text-sm font-medium mb-2">Tipo de mantenimiento</label>
                <flux:select wire:model.live="filters.maintenance_type_id" class="w-full border rounded-md px-2 py-1">
                    <flux:select.option value="">Todos</flux:select.option>
                    @foreach($maintenanceTypes as $id => $name)
                        <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Técnico</label>
                <flux:select wire:model="filters.user_id" class="w-full border rounded-md px-2 py-1">
                    <flux:select.option value="">Todos</flux:select.option>
                    @foreach($users as $id => $name)
                        <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Fecha inicio</label>
                <flux:input type="date" wire:model="filters.start"/>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Fecha fin</label>
                <flux:input type="date" wire:model="filters.end"/>
            </div>
        @endif

        <div>
            <label class="block text-sm font-medium mb-2">Registros por página</label>
            <flux:select wire:model.live="filters.per_page" class="w-full border rounded-md px-2 py-1">
                <flux:select.option value="10">10</flux:select.option>
                <flux:select.option value="20">20</flux:select.option>
                <flux:select.option value="50">50</flux:select.option>
                <flux:select.option value="100">100</flux:select.option>
            </flux:select>
        </div>
    </form>
    
    {{-- Tabla --}}
    <div class="div-table">
        <table class="table">
            <thead class="head-table">
                <tr>
                    @switch($reportType)
                        @case('products')
                            <th class="px-4 py-2">Código</th>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Stock</th>
                            <th class="px-4 py-2">Tipo</th>
                            <th class="px-4 py-2">Color</th>
                            <th class="px-4 py-2">Talla</th>
                            @break

                        @case('elements')
                            <th class="px-4 py-2">Código</th>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Stock</th>
                            <th class="px-4 py-2">Tipo</th>
                            <th class="px-4 py-2">Color</th>
                            @break

                        @case('machines')
                            <th class="px-4 py-2">Serial</th>
                            <th class="px-4 py-2">Tipo</th>
                            <th class="px-4 py-2">Marca</th>
                            <th class="px-4 py-2">Estado</th>
                            @break

                        @case('maintenances')
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Serial máquina</th>
                            <th class="px-4 py-2">Tipo mant.</th>
                            <th class="px-4 py-2">Fecha</th>
                            <th class="px-4 py-2">Técnico</th>
                            @break
                    @endswitch
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $row)
                    <tr class="table-content">
                        @switch($reportType)
                            @case('products')
                                <td class="px-4 py-1">{{ $row->code }}</td>
                                <td class="px-4 py-1">{{ $row->name }}</td>
                                <td class="px-4 py-1">{{ $row->stock }}</td>
                                <td class="px-4 py-1">{{ $row->productType?->name }}</td>
                                <td class="px-4 py-1">{{ $row->color?->name }}</td>
                                <td class="px-4 py-1">{{ $row->size?->name }}</td>
                                @break

                            @case('elements')
                                <td class="px-4 py-1">{{ $row->code }}</td>
                                <td class="px-4 py-1">{{ $row->name }}</td>
                                <td class="px-4 py-1">{{ $row->stock }}</td>
                                <td class="px-4 py-1">{{ $row->elementType?->name }}</td>
                                <td class="px-4 py-1">{{ $row->color?->name }}</td>
                                @break

                            @case('machines')
                                <td class="px-4 py-1">{{ $row->serial }}</td>
                                <td class="px-4 py-1">{{ $row->machineType?->name }}</td>
                                <td class="px-4 py-1">{{ $row->brand?->name }}</td>
                                <td class="px-4 py-1">{{ $row->state?->name }}</td>
                                @break

                            @case('maintenances')
                                <td class="px-4 py-1">{{ $row->id }}</td>
                                <td class="px-4 py-1">{{ $row->machine?->serial }}</td>
                                <td class="px-4 py-1">{{ $row->type?->name }}</td>
                                <td class="px-4 py-1">{{ $row->created_at?->format('Y-m-d') }}</td>
                                <td class="px-4 py-1">{{ $row->user?->name }}</td>
                                @break
                        @endswitch
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-gray-400">
                            Sin resultados para los filtros seleccionados
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">
        {{ $rows->links() }}
    </div>
</div>
