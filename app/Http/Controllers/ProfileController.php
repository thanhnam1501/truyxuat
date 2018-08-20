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
        // return view('backend.profile.dashboard');
        return view('backend.profile.list-missions');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function destroy($id)
    {
        //
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

 public function listMissions() {
    $round_collections = RoundCollection::where('status', 1)->get();

    return view('backend.profile.list-missions', ['round_collections'   =>  $round_collections]);
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
