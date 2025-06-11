<div x-data>
  {{-- Modal Exportar --}}
  <flux:modal name="exportar-movimientos" class="md:w-96">
    <div class="space-y-6">
      <div>
        <flux:heading size="lg">Exportar movimientos</flux:heading>
        <flux:text class="mt-2">
          Descarga un archivo Excel de los movimientos filtrados según la selección.
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

      <div class="flex justify-center">
        <flux:button variant="primary" wire:click="exportMovements">Exportar a Excel</flux:button>
      </div>
    </div>
  </flux:modal>

  <div class="overflow-hidden rounded-xl p-2">
    <h2 class="text-xl font-semibold mb-2 text-center">Últimos Movimientos de Inventarios</h2>

    @php
      $actor = auth()->user()->name . ' ' . auth()->user()->last_name;
    @endphp

    <div class="div-table">
      <table class="table w-full">
        <thead class="head-table">
          <tr>
            <th>Fecha de movimiento</th>
            <th>Tipo</th>
            <th>Categoría</th>
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
              {{-- Fecha de movimiento --}}
              <td>{{ \Carbon\Carbon::parse($m->date)->format('Y-m-d H:i') }}</td>

              {{-- Tipo --}}
              <td>{{ $m->type }}</td>

              {{-- Categoría --}}
              <td>
                {{ in_array($m->type, ['Prestamo','Compra'])
                    ? 'Elemento'
                    : 'Producto' }}
              </td>

              {{-- Elemento / Producto --}}
              <td>{{ $m->element_name }}</td>

              {{-- Encargado (usuario en sesión) --}}
              <td>{{ $actor }}</td>

              {{-- Destinatario --}}
              <td>{{ $m->instructor_name ?? 'N/A' }}</td>

              {{-- Cantidad (con “m” si es tela G-01) --}}
              <td>
                @if(in_array($m->type, ['Prestamo','Compra']) &&
                  $m->element_type_id !== null &&
                  $m->element_type_id >= 1100 &&
                  $m->element_type_id < 2000)
                  {{ $m->amount }} metro/s
                @else
                  {{ (int) $m->amount }} unidad/es
                @endif
              </td>

              {{-- Movimiento (Prestamo G-03 → Prestado/a; resto ya viene en movement_type) --}}
              <td>{{ $m->movement_type }}</td>

              {{-- Devuelto (solo herramientas G-03) --}}
              <td>
                @if(
                  $m->type === 'Prestamo' &&
                  $m->element_type_id !== null &&
                  $m->element_type_id >= 3100 &&
                  $m->element_type_id < 4000
                )
                  {{ $m->return_date ? 'Devuelto/a' : 'NO' }}
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
