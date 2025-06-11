<div class="overflow-hidden rounded-xl p-2">
    {{-- Tabla de los ultimos Mantenimientos --}}
    <h2 class="text-xl font-semibold mb-2 text-center">Últimos Mantenimientos</h2>

    <div class="div-table">
        <table class="table">
            <thead class="head-table">
                <tr>
                    <th class="head-table-item">Serial</th>
                    <th class="head-table-item"> Tipo de mantenimiento</th>
                    <th class="head-table-item">Fecha del Mantenimiento</th>
                    <th class="head-table-item">Fecha del Próximo Mantenimiento</th>
                    <th class="head-table-item">Encargado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($maintenances as $maintenance)
                    <tr class="table-content">
                        <td class="column-item">{{ $maintenance->machine_serial }}</td>
                        <td class="column-item">{{ $maintenance->type }}</td>
                        <td class="column-item">{{ \Carbon\Carbon::parse($maintenance->date)->format('d/m/Y') }}</td>
                        <td class="column-item">{{ $maintenance->next_maintenance_date ? \Carbon\Carbon::parse($maintenance->next_maintenance_date)->format('d/m/Y') : 'N/A' }}</td>
                        <td class="column-item">{{ $maintenance->user_name }}</td>
                    </tr>
                @endforeach
            </tbody>    
        </table>
    </div>
</div>
