<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\EmailVerification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login()
    {
        return view('auth.login');
    }



    /**
     * Show the form for   a new resource.
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile_no' => 'required|digits:10|unique:users,mobile_no',
            'password' => 'required|min:8',
        ]);

        // Create the user

        $code = Str::random(100);
        $link = route('verify_link', ['code' => $code]);
        $user = User::create([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            'mobile_no' => $validatedData['mobile_no'],
            'password' => Hash::make($validatedData['password']),
            'email_code' => $code
        ]);


        $user->notify(new EmailVerification($link));

        return redirect()->route('login')->with('success', 'Email verification link sent to your email address. Please verify it');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function verify(string $code)
    {

        // dd(vars: $code);

        $user = User::where("email_code", $code)->first();
        if ($user) {
            $user->email_verified_at = Carbon::now();
            $user->email_code = null;
            $user->save();

            return redirect(to: route('login'))->with('success', 'Email verification is done. now please login');;
        }else{
            abort(404);
        }
    }

    public function doLogin(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Attempt to log in the user
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        if ($user) {
            if (Hash::check($credentials['password'], $user->password)) {
                if ($user->email_verified_at) {
                    # code...
                    if (Auth::attempt($credentials)) {
                        // Regenerate session
                        $request->session()->regenerate();

                        return redirect()->route('dashboard')->with('success', 'Login successful!');
                    }
                } else {
                    $code = Str::random(100);
                    $link = route('verify_link', ['code' => $code]);

                    $user->email_code = $code;
                    $user->save();

                    $user->notify(new EmailVerification($link));

                    // If authentication fails
                    return back()->with('success', 'Email verification link is sent to your email address. Please verify it!');
                }
            }
        }


        // If authentication fails
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }
}
