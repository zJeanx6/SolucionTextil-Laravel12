<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\LoanDetail;

class PendingLoans extends Component
{
    public int $pendientes = 0;

    public function mount(): void
    {
        $this->contarPendientes();
    }

    public function poll(): void   // ← si luego quieres wire:poll
    {
        $this->contarPendientes();
    }

    private function contarPendientes(): void
    {
        // LEFT JOIN loan_returns y cuenta donde loan_returns.loan_detail_id es NULL
        $this->pendientes = LoanDetail::leftJoin(
                                'loan_returns',
                                'loan_returns.loan_detail_id',
                                '=',
                                'loan_details.id'
                            )
                            ->whereNull('loan_returns.loan_detail_id')
                            ->count();
    }

    public function render()
    {
        return view('livewire.dashboard.pending-loans');
    }
}
