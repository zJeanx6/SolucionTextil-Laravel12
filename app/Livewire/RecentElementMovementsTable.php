<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Exports\ElementMovementsExport;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;

#[Lazy]
class RecentElementMovementsTable extends Component
{
    public $movements;
    public $startDate;
    public $endDate;
    public $tipo = '';
    public $modalExportar = false;

    public function mount()
    {
        $this->startDate = null;
        $this->endDate   = null;
        $this->tipo      = '';
        $this->cargarMovimientos();
    }

    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    public function updated($propertyName)
    {
        $this->cargarMovimientos();
    }

    #[On('abrir-modal-exportar-movimientos')]
    public function abrirModalExportar()
    {
        $this->modalExportar = true;
    }

    public function cerrarModalExportar()
    {
        $this->modalExportar = false;
    }

    public function cargarMovimientos()
    {
        // 1) Préstamos (solo herramienta G-03 → Prestado/a|Devuelto/a; resto G-01,2,4 → Para consumo)
        $loans = DB::table('loans')
            ->join('loan_details',  'loans.id',              '=', 'loan_details.loan_id')
            ->join('elements',      'loan_details.element_code','=', 'elements.code')
            ->join('users as u_instr','loans.instructor_id', '=', 'u_instr.card')
            ->leftJoin('loan_returns','loan_details.id',      '=', 'loan_returns.loan_detail_id')
            ->selectRaw("
                loans.created_at AS date,
                'Prestamo' AS type,
                elements.name AS element_name,
                CONCAT(u_instr.name, ' ', u_instr.last_name) AS instructor_name,
                loan_details.amount AS amount,
                CASE WHEN loan_returns.id IS NOT NULL THEN loan_returns.return_date ELSE NULL END AS return_date,

                -- Movement type: Herramienta G-03 = Prestado/a|Devuelto/a, resto G-01,2,4 = Para consumo
                CASE
                  WHEN elements.element_type_id BETWEEN 3100 AND 3999 THEN
                    CASE WHEN loan_returns.id IS NOT NULL THEN 'Devuelto/a' ELSE 'Prestado/a' END
                  ELSE 'Para consumo'
                END AS movement_type,

                elements.element_type_id AS element_type_id
            ");

        if ($this->startDate) {
            $loans->whereDate('loans.created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $loans->whereDate('loans.created_at', '<=', $this->endDate);
        }
        if ($this->tipo) {
            $loans->whereRaw("'Prestamo' = ?", [$this->tipo]);
        }

        // 2) Compras (G-01,2,4 siempre Para consumo)
        $shoppings = DB::table('shoppings')
            ->join('shopping_details','shoppings.id',             '=', 'shopping_details.shopping_id')
            ->join('elements',         'shopping_details.element_code','=', 'elements.code')
            ->join('users as u_user',  'shoppings.card_id',       '=', 'u_user.card')
            ->join('suppliers',        'shoppings.supplier_nit',  '=', 'suppliers.nit')
            ->selectRaw("
                shoppings.created_at AS date,
                'Compra' AS type,
                elements.name AS element_name,
                suppliers.name AS instructor_name,
                shopping_details.amount AS amount,
                NULL AS return_date,
                'Para consumo' AS movement_type,
                elements.element_type_id AS element_type_id
            ");

        if ($this->startDate) {
            $shoppings->whereDate('shoppings.created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $shoppings->whereDate('shoppings.created_at', '<=', $this->endDate);
        }
        if ($this->tipo) {
            $shoppings->whereRaw("'Compra' = ?", [$this->tipo]);
        }

        // 3) Entradas de productos
        $tickets = DB::table('ticket_details')
            ->join('tickets',  'ticket_details.ticket_id',    '=', 'tickets.id')
            ->join('products', 'ticket_details.product_code', '=', 'products.code')
            ->join('users as u','tickets.card_id',              '=', 'u.card')
            ->selectRaw("
                tickets.created_at AS date,
                'Entrada' AS type,
                products.name AS element_name,
                'N/A' AS instructor_name,
                ticket_details.amount AS amount,
                NULL AS return_date,
                'Entrada de producto' AS movement_type,
                NULL AS element_type_id
            ");

        if ($this->startDate) {
            $tickets->whereDate('tickets.created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $tickets->whereDate('tickets.created_at', '<=', $this->endDate);
        }
        if ($this->tipo) {
            $tickets->whereRaw("'Entrada' = ?", [$this->tipo]);
        }

        // 4) Salidas de productos
        $exits = DB::table('exit_details')
            ->join('exits',    'exit_details.exit_id',     '=', 'exits.id')
            ->join('products','exit_details.product_code', '=', 'products.code')
            ->join('users as u','exits.card_id',            '=', 'u.card')
            ->selectRaw("
                exits.created_at AS date,
                'Salida' AS type,
                products.name AS element_name,
                'N/A' AS instructor_name,
                exit_details.amount AS amount,
                NULL AS return_date,
                'Salida de producto' AS movement_type,
                NULL AS element_type_id
            ");

        if ($this->startDate) {
            $exits->whereDate('exits.created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $exits->whereDate('exits.created_at', '<=', $this->endDate);
        }
        if ($this->tipo) {
            $exits->whereRaw("'Salida' = ?", [$this->tipo]);
        }

        // Unión y últimos 20 movimientos
        $this->movements = $loans
            ->unionAll($shoppings)
            ->unionAll($tickets)
            ->unionAll($exits)
            ->orderBy('date','desc')
            ->limit(20)
            ->get();
    }

    public function exportMovements()
    {
        $this->cerrarModalExportar();
        return new ElementMovementsExport(collect($this->movements));
    }

    public function render()
    {
        return view('livewire.recent-element-movements-table');
    }
}
