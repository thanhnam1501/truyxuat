<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use DB;
use Datatables;
use Entrust;
use App\Models\Email;
use App\Models\Company;
use App\Models\Renewal;


class AdminProfileController extends Controller
{
 public function __construct(){

  $this->middleware('auth');
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  

      return view('admin.user.index');
    }

    public function getFormCreate(){
      $companies = Company::get();
      return view('admin.user.AddUser', ['companies' => $companies]);
    }

    /**
     * Get the list of scientist accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getlist()
    {
     $profiles = DB::table('profiles')
     ->join('companies', 'companies.id', '=', 'profiles.company_id')
     ->select('profiles.*','companies.name as company_name')
     ->get();

     return Datatables::of($profiles)
     ->addIndexColumn()           
     ->addColumn('action', function($profiles) {
      $string = "";

      $string .= '<a data-tooltip="tooltip" title="Sửa thông tin" href="'.route('profile.edit', $profiles->id).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>';

      $string .= '<a data-tooltip="tooltip" title="Xóa" href="javascript:;" onclick="deleteUser('. $profiles->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';

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
        'mobile' => 'required',     
      ]);

      DB::beginTransaction();
      try {
        $data['password'] = bcrypt(123456);

        $user = Profile::withTrashed()->where('email', $data['email'])->first();

        if (!empty($user)) {
          $user->restore();

          $user->update([
            'name'    => $data['name'],
            'password'    => $data['password'],
            'mobile'    => $data['mobile'],
            'status'  => 1,
            'company_id' => $data['company_id'] 
          ]);
        } else {
          $user = Profile::create($data);
        }

        DB::commit();
        \Session::flash('flash_message','Thêm quản trị viên thành công !');
        return view('admin.user.index');
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
      return view('admin.user.EditUser', [
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
        if (!empty($data->password)) {
         $oldpassword = $request->oldpassword;
         $password = $request->password;
         $passwordconf = $request->password_confirmation;

         if(Hash::check($request->oldpassword, Auth::guard('profile')->user()->password) == true && $password == $passwordconf){
          $password = bcrypt($password);
          $profile->update([
            'name'  => $data['name'],
            'email'  => $data['email'],
            'mobile' => $data['mobile'],
            'password' => $password,
          ]);
        }
      }else{
        $profile->update([
          'name'  => $data['name'],
          'email'  => $data['email'],
          'mobile' => $data['mobile'],
        ]);
      }

      $message = 'Cập nhập thành công tài khoản '. $profile->email;
      DB::commit();
      return view('admin.user.index',['messageSuccess' => $message]);

    } catch (Exception $e) {
      DB::rollback();

      Log::info($e->getMessage());
      $message = $e->getMessage();
      return view('admin.user.index',['messageSuccess' => $message]);
    }
  } else {
    $message =  'Không tìm thấy người dùng, vui lòng thử lại sau';
    return view('admin.user.index',['messageError' => $message]);
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
    $user = User::find($request->id);

    if (!empty($user)) {
      DB::beginTransaction();
      try {
        $user->delete();

        DB::commit();

        return response()->json([
          'error' => false,
          'message' => 'Quản trị viên '.$user->name.' đã bị xóa',
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
        'message' =>  'Không tìm thấy quản trị viên, vui lòng thử lại sau',
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

    // Gia hạn tài khoản (Renewal)
    public function getRenewal(){
      return view('admin.indexRenewal');
    }

    public function getListRenewal(){
      $data = DB::table('renewals')
      ->join('companies', 'companies.id', '=', 'renewals.company_id')
      ->select('renewals.*','companies.name as company_name')
      ->get();

      return Datatables::of($data)
      ->editColumn('status', function($data){
        $string = "";
        if($data->status == 1){
          $string = '<a data-tooltip="tooltip" title="Đã kích hoạt" href="javascript:;" onclick="activated('. $data->id .')" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>';
        }
        else{
          $string = '<a data-tooltip="tooltip" title="Chưa kích hoạt" href="javascript:;" onclick="activated('. $data->id .')" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></a>';
        }
        return $string;      
      })
      ->addIndexColumn()
      // ->addColumn()           
      ->addColumn('action', function($data) {
        $string = "";
        $string .= '<a data-tooltip="tooltip" title="Xem chi tiết" href="'.route('user.product.show', $data->id).'" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>';

        return $string;
      })
      ->make(true);
    }

    public function activatedRenewal(Request $request){
      $id = $request->id;
      $renewal = Renewal::find($id);
      if (!empty($renewal)) {
        $company = Company::find($renewal->company_id);
        $data['time_limit'] = $company->time_limit + $renewal->time_limit;
        $data['account_limit'] = $renewal->account_limit;
        $data['product_limit'] = $renewal->product_limit;
        $check = Company::find($renewal->company_id)->update(['time_limit' => $data['time_limit'], 'account_limit' => $data['account_limit'], 'product_limit' => $data['product_limit']]);
        if($renewal->status == 0 && $check == true){
        $data = Renewal::find($id)->update(['status' => 1]);

        return response()->json([
          'status' => true,
          'message' => 'Thay đổi trạng thái thành công !',
        ]);
      }
      else{ 
        return response()->json([
          'status' => false,
          'message' => 'Không thể thay đổi trạng thái !',
        ]);
      }
      }else{
        return response()->json([
          'status' => false,
          'message' => 'Không tìm thấy yêu cầu gian hạn ! Liên hệ với IT để giải quyết!',
        ]);
      }
      
    }
  }
