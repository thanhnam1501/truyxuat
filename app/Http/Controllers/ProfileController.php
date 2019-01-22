<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use DB;
use Datatables;
use UploadFile;
use Auth;
use App\Models\RoundCollection;
use App\Models\Company;
use Validator;
use App\Models\User_History;
use App\Models\Quote;
use App\Models\Renewal;


class ProfileController extends Controller
{
  public function __construct(){

    $this->middleware('auth.profile');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
      return view('user.index');
    }

    public function getFormCreate(){
      $limit = Profile::where('company_id',Auth::guard('profile')->user()->company_id)->count();
      $company = Company::find(Auth::guard('profile')->user()->company_id);
      if($limit >= $company->account_limit){
        $message = 'Đã đặt mức giới hạn người dùng là: ' . $company->account_limit;
        return view('user.index',['messageError' => $message]);
      }else{

        return view('user.AddUser');
      }
    }

    /**
     * Get the list of scientist accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getlist()
    {
      $profiles = Profile::where('company_id', Auth::guard('profile')->user()->company_id)->orderBy('id', 'desc');

      return Datatables::of($profiles)
      ->addIndexColumn()           
      ->addColumn('action', function($profiles) {
        $string = "";

        $string .= '<a data-tooltip="tooltip" title="Thêm vai trò" href="'.route('user.profile.edit', $profiles->id).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>';

        $string .= '<a data-tooltip="tooltip" title="Thêm vai trò" href="javascript:;" onclick="deleteUser('. $profiles->id .')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';

        return $string;
      })
      ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->all();

      $validatedData = $request->validate([
        'name' => 'required',
        'email' => 'required|string|unique:profiles,email',
        'password' => 'required|confirmed|min:6',
        'password_confirmation' => 'required',
      ]);

      DB::beginTransaction();
      try {
        $data['password'] = bcrypt( $data['password']);
        $data['company_id'] = Auth::guard('profile')->user()->company_id;

        $user = Profile::withTrashed()->where('email', $data['email'])->first();

        if (!empty($user)) {
          $user->restore();

          $user->update([
            'name'    => $data['name'],
            'password'    => $data['password'],
            'company_id'    => $data['company_id'],
          ]);

        } else {
          $data['type'] = 2;
          $user = Profile::create($data);
          $user_history = new User_History();
          $user_history->user_id = Auth::guard('profile')->user()->id;
          $user_history->company_id = Auth::guard('profile')->user()->company_id;
          $user_history->content = 'Tạo mới người dùng: ' . $user->name . ' mã id = ' . $user->id;
          $user_history->save();
        }
        $message = 'Thêm quản trị viên thành công !';
        DB::commit();
        \Session::flash('flash_message','Thêm quản trị viên thành công !');
        return view('user.index',['messageSuccess'   =>  $message]);
      } catch (Exception $e) {
        DB::rollback();

        Log::info($e->getMessage());

        return response()->json([
          'error' => true,
          'message' => $e->getMessage()
        ]);
      }
    }

    public function edit(Request $request)
    {
      $id = $request->id;
      $data = Profile::find($id);
      $companies = Company::get();
      return view('user.EditUser', [
        'data' => $data,
        'companies' => $companies,
      ]);

    }

    public function update(Request $request)
    {
      $data = $request->all();

      $profile = Profile::where('email', $data['email'])->first();

      if (!empty($profile) ) {
        DB::beginTransaction();
        try {
          $profile->update([
            'name'  => $data['name'],
            'email'  => $data['email'],

          ]);
          $message = 'Cập nhập thành công tài khoản '. $profile->email;
          DB::commit();
          return view('user.index',['messageSuccess' => $message]);

        } catch (Exception $e) {
          DB::rollback();

          Log::info($e->getMessage());
          $message = $e->getMessage();
          return view('user.index',['messageSuccess' => $message]);
        }
      } else {
        $message =  'Không tìm thấy người dùng, vui lòng thử lại sau';
        return view('user.index',['messageError' => $message]);
      }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $profile = Profile::find($request->id);

      if (!empty($profile)) {
        DB::beginTransaction();
        try {
          $profile->delete();

          DB::commit();

          return response()->json([
            'error' => false,
            'message' => 'Tài khoản '.$profile->email.' đã bị xóa',
          ]);
        } catch (Exception $e) {
          DB::rollback();

          Log::info($e->getMessage());

          return response()->json([
            'error' => true,
            'message' => $e->getMessage()
          ]);
        }
      } else {
        return response()->json([
          'error'     =>  true,
          'message' =>  'Không tìm thấy người dùng, vui lòng thử lại sau',
        ]);
      }
    }

    public function postUpload(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'file' => 'max:1024',
      ]);

      if ($validator->fails()) {

        return response()->json([
          'status' => false,
          'message' => 'Kích thước ảnh quá lớn, Xin mời chọn lại !',
        ], 200);
      }else{

       $avatar = $request->file('file')->store('img/avatar');
       $id =  Auth::guard('profile')->user()->id;
       $profile = Profile::where('id',$id)->update(['avatar' => $avatar]);
       return response()->json([
        'status' => true,
        'data' => Auth::guard('profile')->user()->avatar,
        'message' => 'Thay ảnh đại diện thành công !',
      ]);
     }

   }


   public  function ShowFormChangePassword(){
    return view('change-password');
  }

  public function ChangePassword(Request $request){
    $oldpassword = $request->oldpassword;
    $password = $request->password;
    $passwordconf = $request->password_confirmation;

    if(Hash::check($request->oldpassword, Auth::guard('profile')->user()->password) == true && $password == $passwordconf){
      $password = bcrypt($password);
      Profile::find(Auth::guard('profile')->user()->id)->update(['password' => $password]);
      $message = 'Thay đổi mật khẩu thành công !';
      return view('user.product.index', ['messageSuccess'   =>  $message]);
    }else{
     $message = 'Thay đổi mật khẩu không thành công ! Nhập chưa đúng, Xin mời nhập lại !';
     return view('user.product.index', ['messageError'   =>  $message]);
   }
 }

 // Gia hạn tài khoản Renewal

 public function getFormRenewal(){
  $profile = Profile::find(Auth::guard('profile')->user()->id);
  $company = Company::find(Auth::guard('profile')->user()->company_id);
  $quotes = Quote::get();
  return view('user.renewal', ['profile' => $profile, 'company'=>$company,'quotes' => $quotes]);
}

public function creatRenewal(Request $request){
  $data = $request->all();

      // $validatedData = $request->validate([
      //   'name' => 'required',
      //   'email' => 'required|string|unique:profiles,email',
      //   'mobile' => 'required',     
      // ]);

  DB::beginTransaction();
  try {
    $quotes = Quote::find($data['quotes_id']);

    $renewal = array();
    $renewal['time_limit'] = $quotes->time_limit;
    $renewal['company_id'] = Auth::guard('profile')->user()->company_id;
    $renewal['content'] = $data['content'];
    $renewal['price'] = $quotes->price;
    $renewal['account_limit'] = $quotes->account_limit;
    $renewal['product_limit'] = $quotes->product_limit;
    
    Renewal::create($renewal);

    DB::commit();
    \Session::flash('flash_message','Bạn đã yêu cầu gia hạn thành công, Chúng tôi sẽ sớm xử lý và liên lạc với bạn, Xin cảm ơn!');
    return redirect()->route('user.product.index');
  } catch (Exception $e) {
    DB::rollback();

    Log::info($e->getMessage());

    return response()->json([
      'error' => true,
      'message' => $e->getMessage()
    ]);
  }
}
}
