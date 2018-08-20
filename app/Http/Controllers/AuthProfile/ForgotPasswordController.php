<?php

namespace App\Http\Controllers\AuthProfile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    protected $users;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:profile');
    }

    public function broker()
    {
        return Password::broker('profiles');
    }

    public function showLinkRequestForm(){
        if (Auth::guard('profile')->check()) {
            return redirect('/profile');
        }

        return view('backend.auth_profile.passwords.email');
    }

}
