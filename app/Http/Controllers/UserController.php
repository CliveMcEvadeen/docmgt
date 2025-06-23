<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // List all admin users for Super Admin
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('users.index', compact('admins'));
    }

    // Show form to create new admin
    public function create()
    {
        return view('users.create');
    }

    // Store new admin user
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile_no' => 'required|digits:10|unique:users,mobile_no',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'password' => bcrypt($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('users.list')->with('success', 'Admin user created successfully.');
    }

    // Show form to edit admin user
    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('users.edit', compact('admin'));
    }

    // Update admin user
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$admin->id,
            'mobile_no' => 'required|digits:10|unique:users,mobile_no,'.$admin->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $admin->firstname = $request->firstname;
        $admin->lastname = $request->lastname;
        $admin->email = $request->email;
        $admin->mobile_no = $request->mobile_no;

        if ($request->filled('password')) {
            $admin->password = bcrypt($request->password);
        }

        $admin->save();

        return redirect()->route('users.list')->with('success', 'Admin user updated successfully.');
    }

    // Delete admin user
    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('users.list')->with('success', 'Admin user deleted successfully.');
    }
}
