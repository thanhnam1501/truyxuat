<?php

namespace App\Http\Controllers\AuthProfile;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/missions';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected function guard()
    {
        return Auth::guard('profile');
    }

    public function showLoginForm()
    {   
        if (Auth::guard('profile')->check()) {
            return redirect('/missions');
        }
        return view('backend.auth_profile.login');
    }

    protected function credentials(Request $request)
    {
        $data = $request->only($this->username(), 'password');
        $data['status'] =  1;
        return $data;
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|email',
            'password' => 'required|min:6',
        ]);
    }

    public function logout(Request $request)
    {   
        Auth::guard('profile')->logout();
        $request->session()->invalidate();
        
        return $this->loggedOut($request) ?: redirect('/login');
    }
}
