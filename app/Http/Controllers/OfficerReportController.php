<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficerReportController extends Controller
{
    // Show the officer dashboard
    public function dashboard()
    {
        $locations = Auth::user()->assignedLocations;
        $documents = \App\Models\Document::all();
        $dailyReports = DailyReport::where('officer_id', Auth::id())->get();
        return view('dashboards.officer', compact('locations', 'documents', 'dailyReports'));
    }

    // Show the daily report form for the officer
    public function create()
    {
        $locations = Auth::user()->assignedLocations;
        return view('officer.report_form', compact('locations'));
    }

    // Show all uploaded documents for the officer
    public function documents()
    {
        $documents = \App\Models\Document::all();
        return view('officer.documents', compact('documents'));
    }

    // Store the daily report submitted by the officer
    public function store(Request $request)
    {
        $request->validate([
            'entryType' => 'required|in:arrival,departure',
            'totalCount' => 'required|integer|min:0',
            'maleCount' => 'nullable|integer|min:0',
            'femaleCount' => 'nullable|integer|min:0',
            'asylumMale' => 'nullable|integer|min:0',
            'asylumFemale' => 'nullable|integer|min:0',
            'deportMale' => 'nullable|integer|min:0',
            'deportFemale' => 'nullable|integer|min:0',
            'returnMale' => 'nullable|integer|min:0',
            'returnFemale' => 'nullable|integer|min:0',
            'nat1' => 'nullable|string|max:255',
            'nat1Male' => 'nullable|integer|min:0',
            'nat1Female' => 'nullable|integer|min:0',
            'nat2' => 'nullable|string|max:255',
            'nat2Male' => 'nullable|integer|min:0',
            'nat2Female' => 'nullable|integer|min:0',
            'nat3' => 'nullable|string|max:255',
            'nat3Male' => 'nullable|integer|min:0',
            'nat3Female' => 'nullable|integer|min:0',
            'mode' => 'required|in:flight,marine,land',
            'flightNumber' => 'nullable|string|max:255',
            'origin' => 'nullable|string|max:255',
            'destination' => 'nullable|string|max:255',
        ]);

        $nationalities = [];

        for ($i = 1; $i <= 3; $i++) {
            $country = $request->input("nat{$i}");
            $male = $request->input("nat{$i}Male");
            $female = $request->input("nat{$i}Female");

            if ($country) {
                $nationalities[] = [
                    'country' => $country,
                    'male' => $male ?? 0,
                    'female' => $female ?? 0,
                ];
            }
        }

        DailyReport::create([
            'officer_id' => Auth::id(),
            'location_id' => $request->input('location_id'),
            'report_date' => now()->toDateString(),
            'entry_type' => $request->input('entryType'),
            'total_count' => $request->input('totalCount'),
            'male_count' => $request->input('maleCount'),
            'female_count' => $request->input('femaleCount'),
            'asylum_male' => $request->input('asylumMale'),
            'asylum_female' => $request->input('asylumFemale'),
            'deport_male' => $request->input('deportMale'),
            'deport_female' => $request->input('deportFemale'),
            'return_male' => $request->input('returnMale'),
            'return_female' => $request->input('returnFemale'),
            'nationalities' => $nationalities,
            'mode' => $request->input('mode'),
            'flight_number' => $request->input('flightNumber'),
            'origin' => $request->input('origin'),
            'destination' => $request->input('destination'),
        ]);

        return redirect()->route('officer.dashboard')->with('success', 'Daily report submitted successfully.');
    }
}
