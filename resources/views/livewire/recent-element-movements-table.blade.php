<div class="overflow-hidden rounded-xl p-2">
    <h2 class="text-xl font-semibold mb-2 text-center">Últimos Movimientos del los Inventarios</h2>

    <div class="div-table">
        <table class="table">
            <thead class="head-table">
                <tr>
                    <th class="head-table-item">Fecha</th>
                    <th class="head-table-item">Tipo</th>
                    <th class="head-table-item">Elemento</th>
                    <th class="head-table-item">Encargado</th>
                    <th class="head-table-item">Cantidad</th>
                    <th class="head-table-item">Movimiento</th>
                    <th class="head-table-item">Devuelto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movements as $movement)
                    <tr class="table-content">
                        <td class="column-item">{{ \Carbon\Carbon::parse($movement->date)->format('Y-m-d H:i') }}</td>
                        <td class="column-item">{{ $movement->type }}</td>
                        <td class="column-item">{{ $movement->element_name }}</td>
                        <td class="column-item">{{ $movement->user_name }}</td>
                        <td class="column-item">{{ $movement->amount }}</td>
                        <td class="column-item">{{ $movement->movement_type }}</td>
                        <td class="column-item">
                            @if($movement->return_date)
                                {{ \Carbon\Carbon::parse($movement->return_date)->format('Y-m-d H:i') }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
