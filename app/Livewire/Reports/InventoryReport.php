<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Element;
use App\Models\ElementType;
use App\Models\Machine;
use App\Models\MachineType;
use App\Models\Brand;
use App\Models\State;
use App\Models\Maintenance;
use App\Models\MaintenanceType;
use App\Models\User;

class InventoryReport extends Component
{
    use WithPagination;

    // Estado principal
    public string $reportType = 'products';

    // Filtros
    public array $filters = [
        'product_type_id'     => '',
        'element_type_id'     => '',
        'machine_type_id'     => '',
        'brand_id'            => '',
        'state_id'            => '',
        'maintenance_type_id' => '',
        'user_id'             => '',
        'start'               => '',
        'end'                 => '',
        'per_page'            => 20,
    ];

    // Catálogos
    public array $productTypes    = [];
    public array $elementTypes    = [];
    public array $machineTypes    = [];
    public array $brands          = [];
    public array $states          = [];
    public array $maintenanceTypes= [];
    public array $users           = [];

    public function mount()
    {
        // Catálogos cacheados (ajusta si tu catálogo cambia mucho)
        $this->productTypes     = Cache::remember('productType',     3600, fn() => ProductType::pluck('name', 'id')->toArray());
        $this->elementTypes     = Cache::remember('elementType',     3600, fn() => ElementType::pluck('name', 'id')->toArray());
        $this->machineTypes     = Cache::remember('machineType',     3600, fn() => MachineType::pluck('name', 'id')->toArray());
        $this->brands           = Cache::remember('brands',           3600, fn() => Brand::pluck('name', 'id')->toArray());
        $this->states           = Cache::remember('states', 3600, fn() => State::whereIn('id', [3, 4, 5])->pluck('name', 'id')->toArray());
        $this->maintenanceTypes = Cache::remember('maintenanceTypes', 3600, fn() => MaintenanceType::pluck('name', 'id')->toArray());
        $this->users            = Cache::remember('users',            3600, fn() => User::orderBy('name')->pluck('name', 'card')->toArray());
    }

    // Cambiar tipo de reporte reinicia filtros y paginación
    public function updatedReportType()
    {
        $this->filters = [
            'product_type_id'     => '',
            'element_type_id'     => '',
            'machine_type_id'     => '',
            'brand_id'            => '',
            'state_id'            => '',
            'maintenance_type_id' => '',
            'user_id'             => '',
            'start'               => '',
            'end'                 => '',
            'per_page'            => 20,
        ];
        $this->resetPage();
    }

    // Reinicia página al cambiar filtro
    public function updatedFilters()
    {
        $this->resetPage();
    }

    // Query builder según el tipo de reporte y filtros
    public function getRowsProperty()
    {
        switch ($this->reportType) {
            case 'products':
                $query = Product::query()
                    ->with(['productType', 'color', 'size'])
                    ->when($this->filters['product_type_id'], fn($q, $id) => $q->where('product_type_id', $id));
                break;

            case 'elements':
                $query = Element::query()
                    ->with(['elementType', 'color'])
                    ->when($this->filters['element_type_id'], fn($q, $id) => $q->where('element_type_id', $id));
                break;

            case 'machines':
                $query = Machine::query()
                    ->with(['machineType', 'brand', 'state'])
                    ->when($this->filters['machine_type_id'], fn($q, $id) => $q->where('machine_type_id', $id))
                    ->when($this->filters['brand_id'], fn($q, $id) => $q->where('brand_id', $id))
                    ->when($this->filters['state_id'], fn($q, $id) => $q->where('state_id', $id));
                break;

            case 'maintenances':
                $query = Maintenance::query()
                    ->with(['machine', 'type', 'user'])
                    ->when($this->filters['maintenance_type_id'], fn($q, $id) => $q->where('id', $id))
                    ->when($this->filters['user_id'], fn($q, $id) => $q->where('user_id', $id))
                    ->when($this->filters['start'], fn($q, $d) => $q->whereDate('created_at', '>=', $d))
                    ->when($this->filters['end'], fn($q, $d) => $q->whereDate('created_at', '<=', $d));
                break;

            default:
                $query = Product::query()->with(['type']);
        }

        return $query->paginate($this->filters['per_page'] ?? 20);
    }

    // Exportar a Excel (Laravel-Excel)
    public function exportExcel()
    {
        $filename = 'reporte_' . $this->reportType . '_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new class($this->reportType, $this->filters) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithMapping {
            public function __construct(public $type, public $filters) {}

            public function collection()
            {
                // Crea la misma query del reporte, pero sin paginación
                switch ($this->type) {
                    case 'products':
                        $query = Product::query()->with(['productType', 'color', 'size'])
                            ->when($this->filters['product_type_id'], fn($q, $id) => $q->where('product_type_id', $id));
                        break;

                    case 'elements':
                        $query = Element::query()->with(['elementType', 'color'])
                            ->when($this->filters['element_type_id'], fn($q, $id) => $q->where('element_type_id', $id));
                        break;

                    case 'machines':
                        $query = Machine::query()->with(['machineType', 'brand', 'state'])
                            ->when($this->filters['machine_type_id'], fn($q, $id) => $q->where('machine_type_id', $id))
                            ->when($this->filters['brand_id'], fn($q, $id) => $q->where('brand_id', $id))
                            ->when($this->filters['state_id'], fn($q, $id) => $q->where('state_id', $id));
                        break;

                    case 'maintenances':
                        $query = Maintenance::query()->with(['machine', 'maintenanceType', 'user'])
                            ->when($this->filters['maintenance_type_id'], fn($q, $id) => $q->where('id', $id))
                            ->when($this->filters['user_id'], fn($q, $id) => $q->where('user_id', $id))
                            ->when($this->filters['start'], fn($q, $d) => $q->whereDate('created_at', '>=', $d))
                            ->when($this->filters['end'], fn($q, $d) => $q->whereDate('created_at', '<=', $d));
                        break;

                    default:
                        $query = Product::query()->with(['type']);
                }
                return $query->get();
            }

            public function headings(): array
            {
                return match ($this->type) {
                    'products' => ['Código', 'Nombre', 'Stock', 'Tipo', 'Color', 'Talla'],
                    'elements' => ['Código', 'Nombre', 'Stock', 'Tipo', 'Color'],
                    'machines' => ['Serial', 'Tipo', 'Marca', 'Estado'],
                    'maintenances' => ['ID', 'Serial Máquina', 'Tipo Mant.', 'Fecha', 'Técnico'],
                    default => [],
                };
            }

            public function map($row): array
            {
                return match ($this->type) {
                    'products' => [
                        $row->code,
                        $row->name,
                        $row->stock,
                        $row->productType?->name,
                        $row->color?->name,
                        $row->size?->name,
                    ],
                    'elements' => [
                        $row->code,
                        $row->name,
                        $row->stock,
                        $row->elementType?->name,
                        $row->color?->name,
                    ],
                    'machines' => [
                        $row->serial,
                        $row->machineType?->name,
                        $row->brand?->name,
                        $row->state?->name,
                    ],
                    'maintenances' => [
                        $row->id,
                        $row->machine?->serial,
                        $row->type?->name,
                        $row->created_at?->format('Y-m-d'),
                        $row->user?->name,
                    ],
                    default => [],
                };
            }
        }, $filename);
    }

    public function render()
    {
        return view('livewire.reports.inventory-report', [
            'rows' => $this->rows,
        ]);
    }
}
