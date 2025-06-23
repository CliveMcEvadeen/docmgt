<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $firstname, $lastname, $email, $mobile_no, $password, $password_confirmation;
    public $editUserId = null;

    protected $rules = [
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'mobile_no' => 'required|digits:10|unique:users,mobile_no',
        'password' => 'required|min:8|confirmed',
    ];

    public function render()
    {
        $users = User::where('role', 'admin')
            ->where(function ($query) {
                $query->where('firstname', 'like', '%'.$this->search.'%')
                      ->orWhere('lastname', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.user-management', ['users' => $users]);
    }

    public function resetInputFields()
    {
        $this->firstname = '';
        $this->lastname = '';
        $this->email = '';
        $this->mobile_no = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->editUserId = null;
    }

    public function createUser()
    {
        $this->validate();

        $user = User::create([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'mobile_no' => $this->mobile_no,
            'password' => Hash::make($this->password),
            'role' => 'admin',
        ]);

        // Send login credentials email
        Mail::to($user->email)->send(new \App\Mail\UserCredentialsMail($user, $this->password));

        session()->flash('message', 'Admin user created successfully.');

        $this->resetInputFields();
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->editUserId = $id;
        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
        $this->email = $user->email;
        $this->mobile_no = $user->mobile_no;
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function updateUser()
    {
        $this->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->editUserId,
            'mobile_no' => 'required|digits:10|unique:users,mobile_no,'.$this->editUserId,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user = User::findOrFail($this->editUserId);
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->email = $this->email;
        $user->mobile_no = $this->mobile_no;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        session()->flash('message', 'Admin user updated successfully.');

        $this->resetInputFields();
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'Admin user deleted successfully.');
    }
}
