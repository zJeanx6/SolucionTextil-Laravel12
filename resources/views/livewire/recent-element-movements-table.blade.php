<div x-data>
  {{-- Modal Flux UI --}}
  <flux:modal name="exportar-movimientos" class="md:w-96">
    <div class="space-y-6">
      <div>
        <flux:heading size="lg">Exportar movimientos</flux:heading>
        <flux:text class="mt-2">
          Descarga un Excel con los movimientos según tus filtros.
        </flux:text>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Desde:</label>
        <flux:input type="date" wire:model="startDate" max="{{ $endDate }}" />
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Hasta:</label>
        <flux:input type="date" wire:model="endDate" min="{{ $startDate }}" />
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Tipo:</label>
        <flux:select wire:model="tipo">
          <option value="">Todos</option>
          <option value="Prestamo">Préstamo</option>
          <option value="Compra">Compra</option>
          <option value="Entrada">Entrada</option>
          <option value="Salida">Salida</option>
        </flux:select>
      </div>

      <div class="flex justify-end gap-2">
        <flux:button variant="outline" @click="$modal.close('exportar-movimientos')">
          Cancelar
        </flux:button>
        <flux:button variant="primary" wire:click="exportMovements">
          Exportar a Excel
        </flux:button>
      </div>
    </div>
  </flux:modal>

  {{-- Tabla de movimientos --}}
    <div class="overflow-hidden rounded-xl p-2">
        <h2 class="text-xl font-semibold mb-2 text-center">Últimos Movimientos de Inventarios</h2>
        <div class="div-table">
            <table class="table w-full">
                <thead class="head-table">
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Elemento</th>
                        <th>Encargado</th>
                        <th>Destinatario</th>
                        <th>Cantidad</th>
                        <th>Movimiento</th>
                        <th>Devuelto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movements as $m)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($m->date)->format('Y-m-d H:i') }}</td>
                            <td>{{ $m->type }}</td>
                            <td>{{ $m->element_name }}</td>
                            <td>{{ $m->user_name ?? 'No aplica' }}</td>
                            <td>{{ $m->instructor_name ?? 'No aplica' }}</td>
                            <td>
                                @if(
                                    in_array($m->type, ['Prestamo','Compra'])
                                    && $m->element_type_id !== null
                                    && $m->element_type_id >= 1100
                                    && $m->element_type_id < 2000
                                )
                                    {{ $m->amount }} metro/s
                                @else
                                    {{ (int)$m->amount }} unidad/es
                                @endif
                            </td>
                            <td>{{ $m->movement_type }}</td>
                            <td>
                                @if(
                                    $m->type === 'Prestamo'
                                    && $m->element_type_id !== null
                                    && $m->element_type_id >= 3100
                                    && $m->element_type_id < 4000
                                )
                                    {{ $m->return_date
                                        ? \Carbon\Carbon::parse($m->return_date)->format('Y-m-d H:i')
                                        : 'No'
                                    }}
                                @else
                                    No aplica
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



