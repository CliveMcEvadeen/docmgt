<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use App\Models\DailyReport;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $admins = User::where('role', 'admin')->get();
        $officers = User::where('role', 'officer')->with('assignment.location')->get();
        $documents = Document::all();
        $reports = DailyReport::all();
        return view('dashboards.superadmin', compact('admins', 'officers', 'documents', 'reports'));
    }

    public function dashboardOverview()
    {
        $admins = User::where('role', 'admin')->get();
        $officers = User::where('role', 'officer')->with('assignment.location')->get();
        $documents = Document::all();
        $reports = DailyReport::all();

        // Prepare data for daily reports bar chart (last 7 days)
        $reportCounts = [];
        $reportLabels = [];
        $today = now()->startOfDay();
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $count = $reports->where('created_at', '>=', $date)
                             ->where('created_at', '<', $date->copy()->addDay())
                             ->count();
            $reportCounts[] = $count;
            $reportLabels[] = $date->format('D');
        }

        return view('superadmin.dashboard', compact('admins', 'officers', 'documents', 'reports', 'reportCounts', 'reportLabels'));
    }

    public function admins()
    {
        $admins = User::where('role', 'admin')->get();
        return view('superadmin.admins', compact('admins'));
    }

    public function officers()
    {
        $officers = User::where('role', 'officer')->with('assignment.location')->get();
        return view('superadmin.officers', compact('officers'));
    }

    public function documents()
    {
        $documents = Document::all();
        return view('superadmin.documents', compact('documents'));
    }
}