<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);

            \Log::info('Admin registration request received', $validated);
            // Split full_name into firstname and lastname
            $names = explode(' ', $validated['full_name'], 2);
            $firstname = $names[0];
            $lastname = isset($names[1]) ? $names[1] : '';
            \Log::info('Parsed names', ['firstname' => $firstname, 'lastname' => $lastname]);

            $admin = User::create([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'admin',
            ]);
            \Log::info('Admin created', ['admin_id' => $admin->id]);

            return redirect()->route('superadmin.admins')->with('success', 'Admin registered successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('superadmin.admins')
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Admin registration error', ['error' => $e->getMessage()]);
            return redirect()->route('superadmin.admins')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return view('superadmin.admins.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:6',
        ]);
        $admin->full_name = $validated['full_name'];
        $admin->email = $validated['email'];
        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }
        $admin->save();
        return redirect()->route('superadmin.admins')->with('success', 'Admin updated successfully.');
    }

    public function destroy($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        $admin->delete();
        return redirect()->route('superadmin.admins')->with('success', 'Admin deleted successfully.');
    }
}
