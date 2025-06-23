<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use App\Models\OfficerAssignment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Show the admin dashboard with officers, locations, and assignments
    public function dashboard()
    {
        $officers = User::where('role', 'officer')->get();
        $assignments = OfficerAssignment::with(['officer', 'location'])->get();
        $documents = \App\Models\Document::all();
        $reports = \App\Models\DailyReport::all();
        return view('admin.dashboard', compact('officers', 'assignments', 'documents', 'reports'));
    }

    // Assign officer to location
    public function assignOfficer(Request $request)
    {
        $request->validate([
            'officer_id' => 'required|exists:users,id',
            'location_id' => 'required|exists:locations,id',
        ]);

        OfficerAssignment::updateOrCreate(
            ['officer_id' => $request->officer_id],
            ['location_id' => $request->location_id]
        );

        return redirect()->route('admin.dashboard')->with('success', 'Officer assigned to location successfully.');
    }

    // Remove officer assignment
    public function removeAssignment($id)
    {
        $assignment = OfficerAssignment::findOrFail($id);
        $assignment->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Officer assignment removed successfully.');
    }

    // Create a new officer (for modal form)
    public function createOfficer(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'location_id' => 'required|exists:locations,id',
        ]);

        $officer = \App\Models\User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'role' => 'officer',
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        \App\Models\OfficerAssignment::create([
            'officer_id' => $officer->id,
            'location_id' => $request->location_id,
        ]);

        // Optionally send credentials email here

        return response()->json(['success' => true, 'message' => 'Officer created successfully.']);
    }

    // Officer Management Page
    public function officers()
    {
        $officers = User::where('role', 'officer')->get();
        return view('admin.officers', compact('officers'));
    }

    // Assignments Page
    public function assignments()
    {
        $officers = User::where('role', 'officer')->get();
        $locations = Location::all();
        $assignments = OfficerAssignment::with(['officer', 'location'])->get();
        return view('admin.assignments', compact('officers', 'locations', 'assignments'));
    }

    // Documents Page
    public function documents()
    {
        $officers = User::where('role', 'officer')->get();
        $documents = \App\Models\Document::all();
        return view('admin.documents', compact('officers', 'documents'));
    }

    // Dashboard Overview Page
    public function overview()
    {
        $officers = User::where('role', 'officer')->get();
        $locations = Location::all();
        $assignments = OfficerAssignment::with(['officer', 'location'])->get();
        $documents = \App\Models\Document::all();
        $reports = \App\Models\DailyReport::all();
        return view('admin.dashboard', compact('officers', 'locations', 'assignments', 'documents', 'reports'));
    }
}
