<?php

namespace App\Http\Controllers\AuthProfile;

use App\User;
use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Email;
use App\Models\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

use Session;
use Mail;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:profile');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:profiles',
            'password' => 'required|string|min:6|confirmed',
            'tax_code'  =>  'nullable|numeric',
            'representative'  =>  'required|min:6',
            'mobile'  =>  'required|regex:/[0][0-9]{9}/',
        ]);//
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();

        try {
            if (!empty($data['tax_code'])) {

                $organization = ['tax_code' => $data['tax_code'], 'name' => $data['name']];

                $organizations = Organization::where('tax_code', $data['tax_code'])->get();

                $id = $organizations->count() > 0 ? $organizations[0]->id : Organization::create($organization)->id;
            } else {
                $id = null;
            }

            $verification_code = str_random(20);

            $profile = Profile::create([
                'organization_id'  =>  $id,
                'email'         => $data['email'],
                'password'      => Hash::make($data['password']),
                'status'        =>  0, // Deactive,
                // 'status'        =>  1, // Active,
                'verification_code' =>  $verification_code,
                'mobile' =>  $data['mobile'],
                'representative' =>  $data['representative'],
            ]);

            $data['verification_code'] = $verification_code;

            $link = url('/').'/confirm-register/'.$data['email']."/".$verification_code ;

            $data['link'] = $link;

            $email = Email::createEmailLog($data['email'], 'Xác nhận đăng ký tài khoản', 'backend.auth_profile.passwords.verify', $data, 1, 2, 0);
            // $email = Email::createEmailLog($data['email'], 'Xác nhận đăng ký tài khoản', 'backend.auth_company.passwords.verify', $data, 1, 0, 1);

            DB::commit();

            return $profile;

        } catch (Exception $e) {
            DB::rollBack();

            return false;
        }

    }

    public function showRegistrationForm()
    {
        return view('backend.auth_profile.register');
    }

    protected function registered(Request $request, $user)
    {

    }

    protected function guard()
    {
        return Auth::guard('profile');
    }

     public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);

        Session::flash('register-success', 'Đăng ký thành công, kiểm tra Email để kích hoạt tài khoản.');
        // Session::flash('register-success', 'Đăng ký thành công. Vui lòng đăng nhập.');

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    public function confirmRegister($email, $code){

        $data = Profile::where('email', $email)->first();

        if (!empty($data) && $data->count() > 0) { // isset email
            if ($data->status == 1) { // active
                $data->verification_code = null;
                $data->save();
                abort(404);
                // Session::flash('confirm-register-success', 'Tài khoản này đã được kích hoạt. Xin vui lòng đăng nhập.');
            } else { // deactive
                if ($data->verification_code == $code) {
                    $data->verification_code = null;
                    $data->status = 1;

                    $data->save();

                    Auth::guard('profile')->login($data);

                    return redirect('/missions');
                    // Session::flash('confirm-register-success', 'Xác nhận đăng ký thành công. Mời bạn đăng nhập.');
                } else {
                    Session::flash('confirm-register-error', 'Xác nhận đăng ký không thành công. Vui lòng kiểm tra lại.');
                }
            }
        } else { // not isset email
            Session::flash('confirm-register-error', 'Email không tồn tại. Vui lòng kiếm tra lại.');
        }

        return redirect('/login');
    }
}
