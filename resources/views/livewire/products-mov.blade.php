<div>
    <div class="breadcrumbs mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item> Movimientos de Productos </flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:dropdown>
            <flux:button size="sm" variant="filled" icon:trailing="chevron-down"> Acciones </flux:button>
            <flux:menu>
                <flux:menu.group heading="Registrar Movimiento">
                    <flux:menu.item wire:click="openIngresoModal">Registrar Productos</flux:menu.item>
                    <flux:menu.item wire:click="openSalidaModal">Registrar Salida</flux:menu.item>
                </flux:menu.group>
                <flux:menu.group heading="Filtrar">
                    <flux:menu.item wire:click="$set('typeFilter', 'Ingreso')">Solo Ingresos</flux:menu.item>
                    <flux:menu.item wire:click="$set('typeFilter', 'Salida')">Solo Salidas</flux:menu.item>
                    <flux:menu.item wire:click="$set('typeFilter', '')">Todos</flux:menu.item>
                </flux:menu.group>
            </flux:menu>
        </flux:dropdown>
    </div>

    <div class="card mb-4">
        <div class="flex gap-4">
            <div class="w-full">
                <flux:input type="text" placeholder="Buscar por producto o usuario..." wire:model.live="search" />
            </div>
        </div>
    </div>

    <div class="div-table">
        <table class="table">
            <thead class="head-table">
                <tr>
                    <th class="head-table-item cursor-pointer" wire:click="sortBy('date')">
                        Fecha
                        @include('partials.sort-icon', ['field' => 'date'])
                    </th>
                    <th class="head-table-item cursor-pointer" wire:click="sortBy('type')">
                        Tipo
                        @include('partials.sort-icon', ['field' => 'type'])
                    </th>
                    <th class="head-table-item">Producto</th>
                    <th class="head-table-item">Cantidad</th>
                    <th class="head-table-item">Usuario</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($movements as $m)
                    <tr wire:key="product-mov-{{$m->movement_id}}" class="table-content">
                        <td class="column-item">{{ \Carbon\Carbon::parse($m->date)->format('Y-m-d H:i') }}</td>
                        <td class="column-item">{{ $m->type }}</td>
                        <td class="column-item">{{ $m->product_name ?? '-' }}</td>
                        <td class="column-item">{{ $m->amount }}</td>
                        <td class="column-item">{{ $m->user ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-3 py-4 text-center text-gray-500 italic">No se encontraron movimientos.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mx-4 mt-4 mb-4">{{ $movements->links(data: ['scrollTo' => false]) }}</div>
    </div>

    {{-- MODAL Ingreso --}}
    <flux:modal name="ingreso-modal" wire:model.live.defer="showIngresoModal" class="md:w-[500px]">
        <div class="space-y-6 p-4">
            <h3 class="text-lg font-semibold">Registrar Ingreso de Producto</h3>
            <flux:select label="Producto" wire:model.live="ingresoProductCode">
                <flux:select.option value="">Seleccione producto</flux:select.option>
                @foreach ($products as $p)
                    <flux:select.option value="{{ $p->code }}">[{{ $p->code }}] {{ $p->name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:input type="number" wire:model.live="ingresoAmount" label="Cantidad" min="1" />
            <div class="flex justify-end gap-2 pt-4">
                <flux:button size="sm" variant="primary" wire:click="closeIngresoModal">Cancelar</flux:button>
                <flux:button size="sm" variant="primary" wire:click="saveIngreso">Guardar Ingreso</flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal.trigger name="ingreso-modal" />

    {{-- MODAL Salida --}}
    <flux:modal name="salida-modal" wire:model.live.defer="showSalidaModal" class="md:w-[500px]">
        <div class="space-y-6 p-4">
            <h3 class="text-lg font-semibold">Registrar Salida de Producto</h3>
            <flux:select label="Producto" wire:model.live="salidaProductCode">
                <flux:select.option value="">Seleccione producto</flux:select.option>
                @foreach ($products as $p)
                    <flux:select.option value="{{ $p->code }}">[{{ $p->code }}] {{ $p->name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:input type="number" wire:model.live="salidaAmount" label="Cantidad" min="1" />
            <div class="flex justify-end gap-2 pt-4">
                <flux:button size="sm" variant="primary" wire:click="closeSalidaModal">Cancelar</flux:button>
                <flux:button size="sm" variant="primary" wire:click="saveSalida">Guardar Salida</flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal.trigger name="salida-modal" />
</div>
