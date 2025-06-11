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
    public $movements = [];
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

    public function updated($propertyName)
    {
        // cada vez que cambia startDate, endDate o tipo,
        // recarga la tabla (sigue limitada a 20)
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

    /**
     * Arma la query base para todos los movimientos, aplicando filtros
     * pero SIN límite. Úsala tanto para la tabla (añadiendo limit(20))
     * como para la exportación (sin límite).
     */
    private function buildMovementsQuery()
    {
        // 1) Préstamos
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
                CONCAT(u_user.name, ' ', u_user.last_name) AS user_name,
                CONCAT(u_instr.name, ' ', u_instr.last_name) AS instructor_name,
                loan_details.amount AS amount,
                loan_returns.return_date AS return_date,
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

        // 2) Compras
        $shoppings = DB::table('shoppings')
            ->join('shopping_details','shoppings.id',             '=', 'shopping_details.shopping_id')
            ->join('elements',       'shopping_details.element_code', '=', 'elements.code')
            ->join('users as u_user','shoppings.card_id',        '=', 'u_user.card')
            ->join('suppliers',      'shoppings.supplier_nit',   '=', 'suppliers.nit')
            ->selectRaw("
                shoppings.created_at AS date,
                'Compra' AS type,
                elements.name AS element_name,
                CONCAT(u_user.name, ' ', u_user.last_name) AS user_name,
                suppliers.name AS instructor_name,
                shopping_details.amount AS amount,
                NULL AS return_date,
                'Compra de elemento' AS movement_type,
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
            ->join('tickets',       'ticket_details.ticket_id',    '=', 'tickets.id')
            ->join('products',      'ticket_details.product_code', '=', 'products.code')
            ->join('users as u_user','tickets.card_id',           '=', 'u_user.card')
            ->selectRaw("
                tickets.created_at AS date,
                'Entrada' AS type,
                products.name AS element_name,
                CONCAT(u_user.name, ' ', u_user.last_name) AS user_name,
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
            ->join('exits',        'exit_details.exit_id',     '=', 'exits.id')
            ->join('products',     'exit_details.product_code', '=', 'products.code')
            ->join('users as u_user','exits.card_id',           '=', 'u_user.card')
            ->selectRaw("
                exits.created_at AS date,
                'Salida' AS type,
                products.name AS element_name,
                CONCAT(u_user.name, ' ', u_user.last_name) AS user_name,
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

        // Unión de todas sin límite
        return $loans
            ->unionAll($shoppings)
            ->unionAll($tickets)
            ->unionAll($exits)
            ->orderBy('date', 'desc');
    }

    /**
     * Carga la tabla con los últimos 20 movimientos.
     */
    public function cargarMovimientos()
    {
        $this->movements = $this
            ->buildMovementsQuery()
            ->limit(20)
            ->get();
    }

    /**
     * Exporta todos los movimientos que cumplen filtros,
     * sin límite de registros.
     */
    public function exportMovements()
    {
        $this->cerrarModalExportar();

        $allMovements = $this
            ->buildMovementsQuery()
            ->get();

        return new ElementMovementsExport($allMovements);
    }

    public function render()
    {
        return view('livewire.recent-element-movements-table');
    }
}
