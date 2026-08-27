<?php

namespace App\Livewire\Reports;

use App\Services\ProfitLossService;
use Carbon\Carbon;
use Livewire\Component;

class ProfitLossReport extends Component
{
    public string $startDate = '';
    public string $endDate = '';

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->toDateString();
        $this->endDate = now()->toDateString();
    }

    public function render(ProfitLossService $pnlService)
    {
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);

        $report = $pnlService->generateReport($start, $end);

        return view('livewire.reports.profit-loss-report', [
            'report' => $report,
        ])->layout('components.layouts.app');
    }
}
