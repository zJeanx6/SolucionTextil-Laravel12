<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\User;
use App\Models\Supplier;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class InventoryMovementsReport extends Component
{
    use WithPagination;

    // Filtros
    public $filters = [
        'start_date' => '',
        'end_date'   => '',
        'type'       => '',
        'user_id'    => '',
        'party_id'   => '',
        'element_name' => '',
        'quantity_min' => '',
        'quantity_max' => '',
        'per_page'   => 20,
    ];

    // Catálogos para selects (puedes cachear si quieres)
    public $users = [];
    public $parties = [];
    public $types = ['Prestamo', 'Compra', 'Entrada', 'Salida'];

    public function mount()
    {
        $this->users = User::whereIn('role_id', [1, 2])->where('card', '!=', 1095305042)->orderBy('name')->get(['card', 'name', 'last_name']);

        $instructors = User::where('role_id', 4)->orderBy('name')->get(['card', 'name', 'last_name'])
            ->mapWithKeys(fn ($u) => [
                $u->card => "{$u->name} {$u->last_name}",
            ]);

        $suppliers = Supplier::orderBy('name')->pluck('name', 'nit');

        $this->parties = $instructors->toArray() + $suppliers->toArray();
    }

    public function updatedFilters()    
    {
        $this->resetPage();
    }

    public function getRowsProperty()
    {
        // Unifica movimientos
        $rows = $this->movementsQuery();

        // Pagina manualmente (porque usamos collection, no query)
        $currentPage = $this->page ?? 1;
        $perPage = $this->filters['per_page'] ?? 20;

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $rows->forPage($currentPage, $perPage),
            $rows->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $paginator;
    }

    private function movementsQuery()
    {
        // PRÉSTAMOS
        $loans = DB::table('loans')
            ->join('loan_details',   'loans.id',           '=', 'loan_details.loan_id')
            ->join('elements',       'loan_details.element_code', '=', 'elements.code')
            ->join('users as u_instr','loans.instructor_id','=', 'u_instr.card')
            ->join('users as u_user', 'loans.card_id',     '=', 'u_user.card')
            ->leftJoin('loan_returns','loan_details.id',   '=', 'loan_returns.loan_detail_id')
            ->selectRaw("
                loans.created_at AS date,
                'Prestamo' AS type,
                elements.name AS element_name,
                u_user.card AS user_id,
                CONCAT(u_user.name, ' ', u_user.last_name) AS user_name,
                u_instr.card AS party_id,
                CONCAT(u_instr.name, ' ', u_instr.last_name) AS party_name,
                loan_details.amount AS amount,
                'unidad/es' AS unit,
                loan_returns.return_date AS return_date,
                CASE
                  WHEN elements.element_type_id BETWEEN 3100 AND 3999 THEN
                    CASE WHEN loan_returns.id IS NOT NULL THEN 'Devuelto/a' ELSE 'Prestado/a' END
                  ELSE 'Para consumo'
                END AS movement_type
            ");

        // COMPRAS
        $shoppings = DB::table('shoppings')
            ->join('shopping_details','shoppings.id',             '=', 'shopping_details.shopping_id')
            ->join('elements',       'shopping_details.element_code', '=', 'elements.code')
            ->join('users as u_user','shoppings.card_id',        '=', 'u_user.card')
            ->join('suppliers',      'shoppings.supplier_nit',   '=', 'suppliers.nit')
            ->selectRaw("
                shoppings.created_at AS date,
                'Compra' AS type,
                elements.name AS element_name,
                u_user.card AS user_id,
                CONCAT(u_user.name, ' ', u_user.last_name) AS user_name,
                suppliers.nit AS party_id,
                suppliers.name AS party_name,
                shopping_details.amount AS amount,
                'unidad/es' AS unit,
                NULL AS return_date,
                'Compra de elemento' AS movement_type
            ");

        // ENTRADAS
        $tickets = DB::table('ticket_details')
            ->join('tickets',       'ticket_details.ticket_id',    '=', 'tickets.id')
            ->join('products',      'ticket_details.product_code', '=', 'products.code')
            ->join('users as u_user','tickets.card_id',           '=', 'u_user.card')
            ->selectRaw("
                tickets.created_at AS date,
                'Entrada' AS type,
                products.name AS element_name,
                u_user.card AS user_id,
                CONCAT(u_user.name, ' ', u_user.last_name) AS user_name,
                NULL AS party_id,
                'N/A' AS party_name,
                ticket_details.amount AS amount,
                'unidad/es' AS unit,
                NULL AS return_date,
                'Entrada de producto' AS movement_type
            ");

        // SALIDAS
        $exits = DB::table('exit_details')
            ->join('exits',        'exit_details.exit_id',     '=', 'exits.id')
            ->join('products',     'exit_details.product_code', '=', 'products.code')
            ->join('users as u_user','exits.card_id',           '=', 'u_user.card')
            ->selectRaw("
                exits.created_at AS date,
                'Salida' AS type,
                products.name AS element_name,
                u_user.card AS user_id,
                CONCAT(u_user.name, ' ', u_user.last_name) AS user_name,
                NULL AS party_id,
                'N/A' AS party_name,
                exit_details.amount AS amount,
                'unidad/es' AS unit,
                NULL AS return_date,
                'Salida de producto' AS movement_type
            ");

        // UNIÓN
        $movements = $loans
            ->unionAll($shoppings)
            ->unionAll($tickets)
            ->unionAll($exits)
            ->orderBy('date', 'desc')
            ->get();

        // Aplica filtros (collection)
        return collect($movements)->filter(function ($row) {
            $start = $this->filters['start_date'];
            $end = $this->filters['end_date'];
            $type = $this->filters['type'];
            $user_id = $this->filters['user_id'];
            $party_id = $this->filters['party_id'];
            $element_name = $this->filters['element_name'];
            $quantity_min = $this->filters['quantity_min'];
            $quantity_max = $this->filters['quantity_max'];

            if ($start && $row->date < $start) return false;
            if ($end && $row->date > $end) return false;
            if ($type && $row->type !== $type) return false;
            if ($user_id && $row->user_id != $user_id) return false;
            if ($party_id && $row->party_id != $party_id) return false;
            if ($element_name && !str_contains(strtolower($row->element_name), strtolower($element_name))) return false;
            if ($quantity_min !== '' && $row->amount < $quantity_min) return false;
            if ($quantity_max !== '' && $row->amount > $quantity_max) return false;
            return true;
        })->values();
    }

    // EXPORTAR
    public function exportExcel()
    {
        $rows = $this->movementsQuery();

        return Excel::download(new class($rows) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithMapping {
            public function __construct(public $rows) {}
            public function collection() { return collect($this->rows); }
            public function headings(): array
            {
                return [
                    'Fecha', 'Tipo', 'Elemento', 'Encargado', 'Destinatario/Proveedor',
                    'Cantidad', 'Unidad', 'Movimiento', 'Devuelto'
                ];
            }
            public function map($row): array
            {
                return [
                    $row->date,
                    $row->type,
                    $row->element_name,
                    $row->user_name,
                    $row->party_name,
                    $row->amount,
                    $row->unit,
                    $row->movement_type,
                    $row->return_date ? $row->return_date : 'No aplica'
                ];
            }
        }, 'movimientos_inventario_' . now()->format('Ymd_His') . '.xlsx');
    }

    public function render()
    {
        return view('livewire.reports.inventory-movements-report', [
            'rows' => $this->rows,
        ]);
    }
}
