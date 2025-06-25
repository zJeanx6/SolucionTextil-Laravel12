@php
    $c = [
      '#06b6d4', // cyan-500  – Préstamos
      '#10b981', // emerald-500 – Compras
      '#f59e0b', // amber-500– Entradas
      '#ef4444', // red-500   – Salidas
    ];
@endphp

<div class="bg-white dark:bg-neutral-800 p-6 flex flex-col h-full">

    {{-- título --}}
    <h3 class="text-sm font-medium text-black dark:text-white flex items-center gap-2 mb-4">
        <span class="w-2 h-2 rounded-full bg-neutral-800 dark:bg-white"></span>
        Movimientos Hoy
    </h3>

    {{-- solo gráfico centrado --}}
    <div class="flex-1 flex items-center justify-center">
        <div id="chart-movimientos-hoy" class="w-full h-64"></div>
    </div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', () => {
    new ApexCharts(
        document.querySelector('#chart-movimientos-hoy'),
        {
            chart: { 
                type: 'donut', 
                height: 280, 
                background: 'transparent', 
                toolbar: { show: false }
            },
            series: [{{ $prestamos }}, {{ $compras }}, {{ $entradas }}, {{ $salidas }}],
            labels: ['Préstamos', 'Compras', 'Entradas', 'Salidas'],
            colors: @json($c),
            plotOptions: {
                pie: {
                    donut: {
                        size: '60%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '14px',
                                fontWeight: 600,
                                color: '#cbd5e1',
                                formatter: function() {
                                    return {{ $prestamos + $compras + $entradas + $salidas }}
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: { 
                enabled: true,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold',
                    colors: ['#ffffff']
                }
            },
            legend: { 
                position: 'bottom',
                labels: { 
                    colors: '#cbd5e1',
                    useSeriesColors: false
                },
                markers: {
                    width: 8,
                    height: 8,
                    radius: 2
                }
            },
            tooltip: { 
                theme: 'dark',
                y: {
                    formatter: function(val) {
                        return val + ' movimientos'
                    }
                }
            }
        }
    ).render();
});
</script>
@endpush