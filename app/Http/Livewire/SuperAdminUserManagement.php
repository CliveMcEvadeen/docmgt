<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SuperAdminUserManagement extends Component
{
    public $firstname, $lastname, $email, $password;
    public $showModal = false;
    public string $layout = 'layouts.app';

    protected $rules = [
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
    ];

    public function render()
    {
        $admins = User::where('role', 'admin')->get();
        return view('livewire.super-admin-user-management', compact('admins'));
    }

    public function showCreateModal()
    {
        $this->reset(['firstname', 'lastname', 'email', 'password']);
        $this->showModal = true;
    }

    public function createAdmin()
    {
        $this->validate();
        $admin = User::create([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'role' => 'admin',
            'password' => Hash::make($this->password),
            'email_verified_at' => now(),
        ]);
        // Send credentials email
        Mail::raw("Your admin account has been created.\nEmail: {$this->email}\nPassword: {$this->password}", function($msg) {
            $msg->to($this->email)->subject('Admin Account Credentials');
        });
        $this->showModal = false;
        session()->flash('success', 'Admin created and credentials sent!');
    }
}
