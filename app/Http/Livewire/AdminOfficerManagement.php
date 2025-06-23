<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Location;
use App\Models\OfficerAssignment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminOfficerManagement extends Component
{
    public $firstname, $lastname, $email, $password, $location_id;
    public $showModal = false;
    public string $layout = 'layouts.app';

    protected $rules = [
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'location_id' => 'required|exists:locations,id',
    ];

    public function render()
    {
        $officers = User::where('role', 'officer')->with('assignment.location')->get();
        $locations = Location::all();
        $assignments = OfficerAssignment::with(['officer', 'location'])->get();
        return view('livewire.admin-officer-management', compact('officers', 'locations', 'assignments'));
    }

    public function showCreateModal()
    {
        $this->reset(['firstname', 'lastname', 'email', 'password', 'location_id']);
        $this->showModal = true;
    }

    public function createOfficer()
    {
        $this->validate();
        $officer = User::create([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'role' => 'officer',
            'password' => Hash::make($this->password),
            'email_verified_at' => now(),
        ]);
        OfficerAssignment::create([
            'officer_id' => $officer->id,
            'location_id' => $this->location_id,
        ]);
        // Send credentials email
        Mail::raw("Your officer account has been created.\nEmail: {$this->email}\nPassword: {$this->password}", function($msg) {
            $msg->to($this->email)->subject('Officer Account Credentials');
        });
        $this->showModal = false;
        session()->flash('success', 'Officer created, assigned, and credentials sent!');
    }

    public $editOfficerId = null;

    public function editOfficer($id)
    {
        $officer = User::findOrFail($id);
        $this->editOfficerId = $id;
        $this->firstname = $officer->firstname;
        $this->lastname = $officer->lastname;
        $this->email = $officer->email;
        $this->location_id = $officer->assignment->location_id ?? null;
        $this->password = '';
    }

    public function updateOfficer()
    {
        $this->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$this->editOfficerId,
            'location_id' => 'required|exists:locations,id',
            'password' => 'nullable|min:8',
        ]);

        $officer = User::findOrFail($this->editOfficerId);
        $officer->firstname = $this->firstname;
        $officer->lastname = $this->lastname;
        $officer->email = $this->email;
        if ($this->password) {
            $officer->password = Hash::make($this->password);
        }
        $officer->save();

        $assignment = OfficerAssignment::where('officer_id', $officer->id)->first();
        if ($assignment) {
            $assignment->location_id = $this->location_id;
            $assignment->save();
        } else {
            OfficerAssignment::create([
                'officer_id' => $officer->id,
                'location_id' => $this->location_id,
            ]);
        }

        $this->reset(['firstname', 'lastname', 'email', 'password', 'location_id', 'editOfficerId']);
        $this->showModal = false;
        session()->flash('success', 'Officer updated successfully!');
    }

    public function deleteOfficer($id)
    {
        $officer = User::findOrFail($id);
        OfficerAssignment::where('officer_id', $officer->id)->delete();
        $officer->delete();
        session()->flash('success', 'Officer deleted successfully!');
    }
}
