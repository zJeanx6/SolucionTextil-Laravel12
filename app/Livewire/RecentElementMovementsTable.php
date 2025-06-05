<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Lazy;

#[Lazy]
class RecentElementMovementsTable extends Component
{
    public $movements;

    public function mount()
    {
        // Obtenemos los últimos 10 movimientos de préstamos, compras y devoluciones combinados
        $this->movements = DB::table('loans')
            ->join('loan_details', 'loans.id', '=', 'loan_details.loan_id')
            ->join('elements', 'loan_details.element_code', '=', 'elements.code')
            ->join('users as u_user', 'loans.card_id', '=', 'u_user.card')
            ->join('users as u_instructor', 'loans.instructor_id', '=', 'u_instructor.card')
            ->leftJoin('loan_returns', 'loan_details.id', '=', 'loan_returns.loan_detail_id') // Join para devoluciones
            ->selectRaw("
                loans.created_at AS date,
                'Prestamo' AS type,
                elements.name AS element_name,
                CONCAT(u_instructor.name, ' ', u_instructor.last_name) AS instructor_name,
                CONCAT(u_user.name, ' ', u_user.last_name) AS user_name,
                loan_details.amount AS amount,
                loan_returns.return_date AS return_date,
                CASE
                    WHEN elements.element_type_id BETWEEN 1100 AND 1999 THEN 'Material consumible'
                    WHEN elements.element_type_id BETWEEN 2100 AND 2999 THEN 'Material consumible'
                    WHEN elements.element_type_id BETWEEN 3100 AND 3999 THEN 
                        CASE 
                            WHEN loan_returns.id IS NOT NULL THEN 'Herramienta devuelta'
                            ELSE 'Herramienta prestada'
                        END
                    WHEN elements.element_type_id BETWEEN 4100 AND 4999 THEN 'Material consumible'
                    ELSE 'Material desconocido'
                END AS movement_type
            ")
            ->unionAll(
                DB::table('shoppings')
                    ->join('shopping_details', 'shoppings.id', '=', 'shopping_details.shopping_id')
                    ->join('elements', 'shopping_details.element_code', '=', 'elements.code')
                    ->join('users as u_user', 'shoppings.card_id', '=', 'u_user.card')
                    ->join('suppliers', 'shoppings.supplier_nit', '=', 'suppliers.nit')
                    ->selectRaw("
                        shoppings.created_at AS date,
                        'Compra' AS type,
                        elements.name AS element_name,
                        suppliers.name AS supplier_name,
                        CONCAT(u_user.name, ' ', u_user.last_name) AS user_name,
                        shopping_details.amount AS amount,
                        NULL AS return_date,
                        'Para consumo' AS movement_type
                    ")
            )
            ->orderBy('date', 'desc')
            ->take(12) // Traemos los últimos 10 registros
            ->get();
    }

    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    public function render()
    {
        return view('livewire.recent-element-movements-table');
    }
}
