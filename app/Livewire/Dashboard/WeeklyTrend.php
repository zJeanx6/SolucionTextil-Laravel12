<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Carbon\CarbonPeriod;
use App\Models\{ElementMovement, TicketDetail, ExitDetail};

class WeeklyTrend extends Component
{
    public array $labels  = [];   // ['Lun','Mar',...]
    public array $series  = [];   // [12, 9, 3, ...] tot. movimientos
    public string $chartId = 'chart-weekly-trend';

    public function mount(): void
    {
        $period = CarbonPeriod::create(now()->subDays(6)->startOfDay(), now()->endOfDay());

        foreach ($period as $date) {
            $this->labels[] = $date->isoFormat('ddd'); // Lun, Mar…
            $this->series[] =
                  ElementMovement::whereDate('created_at',$date)->count()
                + TicketDetail::whereDate('created_at',$date)->count()
                + ExitDetail::whereDate('created_at',$date)->count();
        }
    }

    public function render()
    {
        return view('livewire.dashboard.weekly-trend');
    }
}
