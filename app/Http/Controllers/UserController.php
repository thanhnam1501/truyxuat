<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Option;
use App\Models\OptionValue;
use DB;
use Datatables;
use Entrust;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('revalidate');
  }

  public function home()
  {   
    return view('admin.index');
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
      return view('admin.index');
    }

    /**
     * Get the list of scientist accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getlist()
    {
      $profiles = User::orderBy('id', 'desc');

      return Datatables::of($profiles)
      ->addIndexColumn()           
      ->addColumn('action', function($profiles) {
        $string = "";

        $string .= '<a data-tooltip="tooltip" title="Sửa" href="'.route('user.edit', $profiles->id).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>';

        $string .= '<a data-tooltip="tooltip" title="Xóa" href="javascript:;" onclick="deleteAdmin('. $profiles->id .')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';

        return $string;
      })
      ->make(true);
    }

    public static function getFormCreate(){
      return view('admin.AddAdmin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->all();

      $validatedData = $request->validate([
        'name' => 'required',
        'email' => 'required|string|unique:users,email',
        'mobile' => 'required',
        'password' => 'required|confirmed|min:6',
        'password_confirmation' => 'required',     
      ]);

      DB::beginTransaction();
      try {
       $data['password'] = bcrypt( $data['password']);

       $user = User::withTrashed()->where('email', $data['email'])->first();

       if (!empty($user)) {
        $user->restore();

        $user->update([
          'name'    => $data['name'],
          'password'    => $data['password'],
          'mobile'    => $data['mobile'],
          'status'  => 1,
        ]);
      } else {
        $user = User::create($data);
      }

      DB::commit();
      $message = 'Tài khoản ' . $data['name'] . ' đã được tạo thành công !'; 
      \Session::flash('flash_message','Thêm quản trị viên thành công !');
      return view('admin.index',['messageSuccess' => $message]);
    } catch (Exception $e) {
      DB::rollback();

      Log::info($e->getMessage());
      $message = $e->getMessage();
      return view('admin.index',['messageSuccess' => $message]);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
      $id = $request->id;
      $data = User::find($id);
      return view('admin.EditAdmin', [
        'data' => $data,
      ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $data = $request->all();

      $profile = User::where('email', $data['email'])->first();

      if (!empty($profile) ) {
        DB::beginTransaction();
        try {
          $profile->update([
            'name'  => $data['name'],
            'email'  => $data['email'],
            
          ]);
          $message = 'Cập nhập thành công tài khoản '. $profile->email;
          DB::commit();
          return view('admin.index',['messageSuccess' => $message]);

        } catch (Exception $e) {
          DB::rollback();

          Log::info($e->getMessage());
          $message = $e->getMessage();
          return view('admin.index',['messageSuccess' => $message]);
        }
      } else {
        $message =  'Không tìm thấy người dùng, vui lòng thử lại sau';
        return view('admin.index',['messageError' => $message]);
      }
    }

    function destroy(Request $request)
    {
      $user = User::find($request->id);
      
      if (!empty($user)) {
        DB::beginTransaction();
        try {
          $user->delete();

          DB::commit();

          return response()->json([
            'error' => false,
            'message' => 'Tài khoản '.$user->email.' đã bị xóa',
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

    

    /**
     * get list role for user
     * @param  [type] $id [description]
     * @return [type]     [description]
     */


    /**
     * add or delete role
     * @return [type] [description]
     */



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
      }
      else{
       $avatar = $request->file('file')->store('img/avatar');
       $id =  Auth::user()->id;
       $profile = User::where('id',$id)->update(['avatar' => $avatar]);
       return response()->json([
        'status' => true,
        'data' => Auth::user()->avatar,
        'message' => 'Thay ảnh đại diện thành công !',
      ]);
     }
   }

   public  function showLinkChangePassword(){
    return view('admin-change-password');
  }

  public function ChangePassword(Request $request){
    $oldpassword = $request->oldpassword;
    $password = $request->password;
    $passwordconf = $request->password_confirmation;
    if(Hash::check($request->oldpassword, Auth::user('web')->password) == true && $password == $passwordconf){
      $password = bcrypt($password);
      user::find(Auth::user('web')->id)->update(['password' => $password]);
      $message = 'Thay đổi mật khẩu thành công !';
      return view('user.product.index', ['messageSuccess'   =>  $message]);
    }else{
     $message = 'Nhập chưa đúng, Xin mời nhập lại !';
     return view('user.product.index', ['messageError'   =>  $message]);
   }
 }
}
