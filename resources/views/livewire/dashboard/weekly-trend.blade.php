<div class="bg-white dark:bg-neutral-800 p-4 shadow-lg">
    <h3 class="text-lg font-semibold text-dark mb-4">Tendencia última semana</h3>

    <div id="{{ $chartId }}"></div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const chart = new ApexCharts(
        document.querySelector('#{{ $chartId }}'),
        {
            chart: { type: 'area', height: 220 },
            stroke: { curve: 'smooth' },
            series: [{
                name: 'Movimientos',
                data: @json($series)
            }],
            xaxis: { categories: @json($labels) },
            legend: { position: 'bottom' }
        }
    );
    chart.render();
});
</script>
@endpush
