<div>
    <div>
    {{-- Breadcrumbs --}}
    <div class="breadcrumbs">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Mantenimientos</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        @if ($view === 'index')
            <flux:button  size="sm" variant="primary" wire:click="toggleShowAll">
                    {{ $showAll ? 'Mostrar solo pendientes' : 'Mostrar todas' }}
            </flux:button>
        @else 
            <flux:button size="sm" variant="primary" wire:click="index">Volver</flux:button>
        @endif 
    </div>

    {{-- Variable que determina que vista esta en index --}}
    @if ($view === 'index')
        <div class="mb-6">
            <div class="card p-6">
                {{-- Barra de búsqueda --}}
                <div class="card mb-6">
                    <flux:input label="Buscar por serial" wire:model.live="search" placeholder="Ingrese serial..."/>
                </div>
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
                        @foreach ($machines as $machine)
                            <tr class="table-content">
                                <td class="column-item">{{ $machine->serial }}</td>
                                <td class="column-item">
                                    {{-- Evalua si la variable tiene algun valor, si lo tiene ejecuta lo que esta despues del : sino la tiene solo muestra "nunca"  --}}
                                    {{ $machine->last_maintenance ? Carbon\Carbon::parse($machine->last_maintenance)->format('d/m/Y') : 'Nunca' }}
                                </td>
                                <td class="column-item">
                                    {{-- condicionales que ayudan a determinar visualmente en que estado esta el mantenimiento de la maquina --}}
                                    @if(!$machine->last_maintenance)
                                        <span class="px-2 py-1 rounded-full text-sm font-semibold text-white bg-red-600">Sin mantenimiento</span>
                                    @elseif($machine->last_maintenance < now()->subDays(30))
                                        <span class="px-2 py-1 rounded-full text-sm font-semibold text-white bg-yellow-500">Pendiente</span>
                                    @else
                                        <span class="px-2 py-1 rounded-full text-sm font-semibold text-white bg-green-600">Al día</span>
                                    @endif
                                </td>
                                <td class="column-item text-center align-middle">
                                    <flux:button.group>
                                        <flux:button icon="document-plus" size="sm" class="mx-auto" wire:click="showCreateForm('{{ $machine->serial }}')"/>
                                    </flux:button.group>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $machines->links() }}
            </div>
    {{-- Vista para crear mantenimiento --}}
    @elseif ($view === 'create')
        <div class="card p-6">
            <h3 class="text-lg font-bold mb-4">Registrar Mantenimiento para {{ $selectedMachine->serial }}</h3>
            {{-- Formulario de Mantenimiento --}}
            <div class="flex flex-col lg:flex-row gap-6">
                {{-- Columna Izquierda --}}
                <div class="flex-1 space-y-4">
                    <div class="mb-4">
                        <flux:select label="Tipo de Mantenimiento" wire:model="maintenance_type_id">
                            <option value="">Seleccione un tipo...</option>
                            @foreach($maintenanceTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </flux:select>
                        @error('maintenance_type_id') 
                            <span class="text-red-500">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div class="mb-4">
                        <flux:textarea label="Descripción" wire:model="description" rows="3"/>
                    </div>
                </div>
                {{-- Division --}}
                <div class="hidden lg:block w-px bg-gray-300"></div>

                {{-- Columna Derecha --}}
                <div class="flex-1 space-y-4">
                    <div class="mb-4">
                        <flux:input type="date" label="Fecha" wire:model="maintenance_date" :disabled="true" :value="$maintenance_date" wire:change="updatedMaintenanceDate"/>  
                          {{--Campo de fecha que hace el mantenimiento se registre hoy, este campo no es editable  --}}
                    </div>
                    <div class="mb-4">    
                        <flux:input type="date" label="Próxima Fecha de mantenimiento" wire:model="next_maintenance_date" :min="\Carbon\Carbon::parse($maintenance_date)->addDay()->format('Y-m-d')"/>
                            {{-- Determina que la proxima fecha de mantenimiento no sea antes de hoy --}}
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
