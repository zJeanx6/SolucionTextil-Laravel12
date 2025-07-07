<div>
    {{-- Breadcrumbs --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" icon="home"/>
            <flux:breadcrumbs.item :href="route('admin.dashboard-maintenance')">Mantenimientos</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        @if ($view === 'index')
            <flux:button size="sm" variant="primary" wire:click="toggleShowAll">
                {{ $showAll ? 'Mostrar solo pendientes' : 'Mostrar todas' }}
            </flux:button>
        @else 
            <flux:button size="sm" variant="primary" wire:click="index">Volver</flux:button>
        @endif 
    </div>

    @if ($view === 'index')
        <div class="mb-6">
            {{-- Barra de búsqueda --}}
            <div class="card mb-6">
                <flux:input wire:model.live="search" placeholder="Buscar serial..."/>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="div-table">
            <table class="table">
                <thead class="head-table">
                    <tr>
                        <th class="head-table-item">Serial</th>
                        <th class="head-table-item">Último Mantenimiento</th>
                        <th class="head-table-item">Estado</th>
                        <th class="head-table-item">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($machines as $machine)
                        <tr class="table-content">
                            <td class="column-item">{{ $machine->serial }}</td>
                            <td class="column-item">
                                {{ $machine->last_maintenance ? \Carbon\Carbon::parse($machine->last_maintenance)->format('d/m/Y') : 'Nunca' }}
                            </td>
                            <td class="column-item">
                                @if($machine->state)
                                    {{ $machine->state->name }} - {{ $machine->state->description }}
                                @else
                                    No definido
                                @endif
                            </td>
                            <td class="column-item text-center align-middle">
                                <flux:button.group>
                                    <flux:button icon="document-plus" size="sm" class="mx-auto" wire:click="showCreateForm('{{ $machine->serial }}')"/>
                                </flux:button.group>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-4 text-center text-gray-500 italic"> No se encontraron maquinas. </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mx-4 mt-4 mb-4">{{ $machines->links() }}</div>
        
    @elseif ($view === 'create')
        <div class="card p-6">
            <h3 class="text-lg font-bold mb-4">Registrar Mantenimiento para la Máquina</h3>

            {{-- Formulario de Mantenimiento --}}
            <div class="flex flex-col lg:flex-row gap-6">
                {{-- Columna Izquierda --}}
                <div class="flex-1 space-y-4">
                    <flux:input label="Serial de la máquina" :value="$selectedMachine->serial" disabled/>

                    {{-- Seleccionar tipo de mantenimiento --}}
                    <div class="mb-4">
                        <flux:select label="Tipo de Mantenimiento" wire:model.live="maintenance_type" wire:change="updateMaintenanceTypes">
                            <flux:select.option value="Correctivo">Correctivo</flux:select.option>
                            <flux:select.option value="Preventivo">Preventivo</flux:select.option>
                        </flux:select>
                    </div>

                    {{-- Seleccionar los tipos de mantenimiento --}}
                    <div class="mb-4">
                        <div class="p-6 w-full mx-auto">
                            <div class="space-y-4">
                                <div class="flex flex-wrap gap-4">
                                    <flux:checkbox.group wire:model="maintenance_type_id" label="Tipos de Mantenimiento">
                                        @foreach ($maintenance_types as $type)
                                            <flux:checkbox label="{{ $type->name }}" value="{{ $type->id }}" description="{{ $type->description }}" />
                                        @endforeach
                                    </flux:checkbox.group>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha --}}
                <div class="flex-1 space-y-4">
                    <div class="mb-4">
                        <flux:input type="date" label="Fecha de Mantenimiento" wire:model="maintenance_date" :disabled="true" :value="$maintenance_date" wire:change="updatedMaintenanceDate"/>
                    </div>
                    <div class="mb-4">    
                        <flux:input type="date" label="Próxima Fecha de Mantenimiento" wire:model="next_maintenance_date" :min="\Carbon\Carbon::parse($maintenance_date)->addDay()->format('Y-m-d')"/>
                    </div>

                    <div class="mb-4">
                        <flux:textarea label="Descripción" wire:model="description" rows="3"/>
                    </div>

                    {{-- Seleccionar estado --}}
                    <div class="mb-4">
                        <flux:radio.group label="Estado de la máquina" wire:model="state_id">
                            @foreach ($states as $state)
                                <flux:radio value="{{ $state->id }}" label="{{ $state->name }}" description="{{ $state->description }}" />
                            @endforeach
                        </flux:radio.group>
                    </div>
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="flex justify-end gap-2 mt-6">
                <flux:button variant="primary" wire:click="$set('view', 'index')">Cancelar</flux:button>
                <flux:button variant="primary" wire:click="saveMaintenance">Guardar</flux:button>
            </div>
        </div>
    @endif
</div>
