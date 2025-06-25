<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\ElementMovement;
use App\Models\TicketDetail;  // entradas productos
use App\Models\ExitDetail;    // salidas productos
use Carbon\Carbon;

class ElementMovementsToday extends Component
{
    public int $prestamos   = 0;
    public int $compras     = 0;
    public int $entradas    = 0;
    public int $salidas     = 0;

    public function mount(): void
    {
        $today = Carbon::today();

        // Elementos
        $this->prestamos = ElementMovement::where('type', 'prestamo')
                            ->whereDate('created_at', $today)->count();

        $this->compras   = ElementMovement::where('type', 'compra')
                            ->whereDate('created_at', $today)->count();

        // Productos
        $this->entradas  = TicketDetail::whereDate('created_at', $today)->count();
        $this->salidas   = ExitDetail::whereDate('created_at', $today)->count();
    }

    public function render()
    {
        return view('livewire.dashboard.element-movements-today');
    }
}
