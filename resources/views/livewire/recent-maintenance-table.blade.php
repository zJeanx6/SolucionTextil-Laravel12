<div>
    {{-- migas --}}
    <div class="breadcrumbs mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item icon="home" :href="route('dashboard')" />
            <flux:breadcrumbs.item>Resumen General Mantenimientos</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <h2 class="text-xl font-semibold mb-2 text-center">Últimos Mantenimientos</h2>

    {{-- tabla --}}
    <div class="div-table">
        <table class="table">
            <thead class="head-table">
                <tr>
                    <th class="head-table-item">Serial</th>
                    <th class="head-table-item">Tipo de Mantenimiento</th>  <!-- Aquí se cambia el título -->
                    <th class="head-table-item">Fecha del Mantenimiento</th>
                    <th class="head-table-item">Próximo Mantenimiento</th>
                    <th class="head-table-item">Encargado</th>
                    <th class="head-table-item">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($maintenances as $mt)
                    <tr class="table-content">
                        <td class="column-item">{{ $mt->machine_serial }}</td>
                        <td class="column-item">
                            <!-- Se muestra el tipo de mantenimiento: Correctivo o Preventivo -->
                            {{ $mt->maintenance_type }}
                        </td>
                        <td class="column-item">{{ \Illuminate\Support\Carbon::parse($mt->maintenance_date)->format('d/m/Y') }}</td>
                        <td class="column-item">
                            {{ $mt->next_maintenance_date ? \Illuminate\Support\Carbon::parse($mt->next_maintenance_date)->format('d/m/Y') : 'N/A' }}
                        </td>
                        <td class="column-item">{{ $mt->user_name }}</td>
                        <td class="column-item text-center">
                            <flux:button size="xs" variant="primary" wire:click="showMaintenanceDetails({{ $mt->id }})">
                                Ver Detalles
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-3 py-4 text-center text-gray-500 italic"> No se encontraron mantenimientos. </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- modal de detalle --}}
    <flux:modal name="maintenance-detail" wire:model.live.defer="showModal" class="md:w-[500px]">
        @if($selectedMaintenance)
            <div class="space-y-4 p-6">
                <h3 class="text-lg font-semibold">
                    Mantenimiento – {{ $selectedMaintenance->maintenance_date ? \Illuminate\Support\Carbon::parse($selectedMaintenance->maintenance_date)->format('d/m/Y') : '' }}
                </h3>

                <p><strong>Máquina:</strong> {{ $selectedMaintenance->machine_serial }}</p>
                <p><strong>Registrado por:</strong> {{ $selectedMaintenance->user_name }}</p>
                @if($selectedMaintenance->description)
                    <p><strong>Descripción:</strong> {{ $selectedMaintenance->description }}</p>
                @endif

                <h4 class="font-medium mt-4 mb-2">Tipos de mantenimiento realizados</h4>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($details as $d)
                        <li>{{ $d->type_name }}</li>
                    @endforeach
                </ul>

                <div class="flex justify-end pt-4">
                    <flux:button size="sm" variant="filled" wire:click="closeModal">Cerrar</flux:button>
                </div>
            </div>
        @endif
    </flux:modal>

    {{-- disparador invisible --}}
    <flux:modal.trigger name="maintenance-detail" />
</div>
