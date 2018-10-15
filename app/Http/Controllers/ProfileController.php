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
    $companies = Company::get();
    return view('user.AddUser', ['companies' => $companies]);
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
        ]);

        DB::beginTransaction();
        try {
            $data['password'] = bcrypt(123456);
            $data['company_id'] = Auth::guard('profile')->user()->company_id;

            $user = Profile::withTrashed()->where('email', $data['email'])->first();

            if (!empty($user)) {
              $user->restore();

              $user->update([
                'name'    => $data['name'],
                'password'    => $data['password'],
                'company_id'    => $data['company_id'],
                'status'  => 2,
            ]);
          } else {
            $data['status'] = 2;
              $user = Profile::create($data);
          }

          DB::commit();
          \Session::flash('flash_message','Thêm quản trị viên thành công !');
          return view('user.index');
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

public function update(Request $request, $id)
{
  $data = $request->all;

  $profile = Profile::where('email', $data['email'])->first();

  if (!empty($profile) && $profile->id == $id) {
    DB::beginTransaction();
    try {
      $user->update([
        'name'  => $data['name'],
        'type'  => $data['type'],
        'mobile'  => $data['mobile'],
    ]);

      DB::commit();

      return response()->json([
        'error' => false,
        'message' => 'Cập nhập thành công tài khoản '.$profile->email,
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


public  function showLinkChangePassword(){
    return view('backend.profile.change-password');
}

public function ChangePassword(Request $request){
    $oldpassword = $request->oldpassword;
    $password = $request->password;
    $passwordconf = $request->password_confirmation;
    if(Hash::check($request->oldpassword, Auth::guard('profile')->user()->password) == true && $password == $passwordconf){
        $password = bcrypt($password);
        Profile::find(Auth::guard('profile')->user()->id)->update(['password' => $password]);
        $message = 'Thay đổi mật khẩu thành công !';
        return view('backend.profile.change-password', ['messageSuccess'   =>  $message]);
    }else{
     $message = 'Nhập chưa đúng, Xin mời nhập lại !';
     return view('backend.profile.change-password', ['messageError'   =>  $message]);
 }
}

}
