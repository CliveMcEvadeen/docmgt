<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class TestController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //

        $user = User::find(1);
        $code = Str::random(100);
      
        $link = route('verify_link', ['code' => $code]);
        $user->email_code = $code;

        $user->notify(new EmailVerification($link));

        $user->save();

    }
}
