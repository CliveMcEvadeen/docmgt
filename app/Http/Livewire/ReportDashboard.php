<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DailyReport;
use Illuminate\Support\Facades\DB;

class ReportDashboard extends Component
{
    public $reportData = [];

    public function mount()
    {
        $this->loadReportData();
    }

    public function loadReportData()
    {
        // Example: Aggregate total arrivals and departures by date
        $data = DailyReport::select(
            'report_date',
            DB::raw('SUM(CASE WHEN entry_type = "arrival" THEN total_count ELSE 0 END) as total_arrivals'),
            DB::raw('SUM(CASE WHEN entry_type = "departure" THEN total_count ELSE 0 END) as total_departures')
        )
        ->groupBy('report_date')
        ->orderBy('report_date')
        ->get();

        $this->reportData = $data->toArray();
    }

    public function render()
    {
        return view('livewire.report-dashboard');
    }
}
