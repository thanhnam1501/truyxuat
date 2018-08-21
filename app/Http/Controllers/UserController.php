<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
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
        return view('backend.admins.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('backend.accounts.list_users');
    }

    /**
     * Get the list of scientist accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $profiles = User::orderBy('id', 'desc');

        return Datatables::of($profiles)
                ->addIndexColumn()
                ->editColumn('status', function ($user) {
                    if ($user->status == 0) {
                        return '<label data-tooltip="tooltip" title="Mở khóa tài khoản" class="switch switch-small"><input type="checkbox" data-user_id="'.$user->id.'" class="lock-account"/><span></span></label>';
                    } elseif ($user->status == 1) {
                        return '<label data-tooltip="tooltip" title="Khóa tài khoản" class="switch switch-small"><input type="checkbox" data-user_id="'.$user->id.'" checked class="lock-account"/><span></span></label>';
                    }
                })
                ->addColumn('action', function ($user) {
                    $string = "";

                    // if (Entrust::can('account-detail')) {
                    //
                    //   $string .= '<a onclick="detail('.$user->id.')" data-tooltip="tooltip" title="Xem chi tiết" href="javascript:;" class="btn btn-info"><i class="fa fa-eye"></i></a>';
                    // }

                    if (Entrust::can('user-roles')) {
                        $string .= '<a data-tooltip="tooltip" title="Thêm vai trò" href="'.route('user.roles', $user->id).'" class="btn btn-info btn-xs"><i class="fa fa-shield"></i></a>';
                    }


                    if (Entrust::can('user-edit')) {

                        $string .= '<a onclick="editModal('.$user->id.')" data-tooltip="tooltip" title="Chỉnh sửa" href="javascript:;" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>';
                    }

                    if (Entrust::can('user-delete')) {
                        $string .= '<a data-id="'.$user->id.'" data-tooltip="tooltip" title="Xóa tài khoản" href="javascript:;" class="btn btn-danger delete-btn btn-xs"><i class="fa fa-trash-o"></i></a>';
                    }

                    return $string;
                })
                ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only('name', 'email');

        if (!$this->checkEmail($data['email'])) {
            return response()->json([
              'error' => true,
              'message' => 'Email đã tồn tại, vui lòng sử dụng email khác'
          ]);
        }

        DB::beginTransaction();
        try {
            $data['password'] = bcrypt(123456);

            $user = User::withTrashed()->where('email', $data['email'])->first();

            if (!empty($user)) {
                $user->restore();

                $user->update([
                'name'    => $data['name'],
                'password'    => $data['password'],
                'status'  => 1,
              ]);
            } else {
                $user = User::create($data);
            }

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => 'Tạo mới thành công tài khoản'
            ]);
        } catch (Exception $e) {
            DB::rollback();

            Log::info($e->getMessage());

            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if (!empty($user)) {
            return response()->json([
              'error'     =>  false,
              'user' =>  $user,
          ]);
        } else {
            return response()->json([
              'error'     =>  true,
              'message' =>  'Không tìm thấy người dùng, vui lòng thử lại sau',
          ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only('email', 'name');

        $user = User::where('email', $data['email'])->first();

        if (!empty($user) && $user->id == $id) {
            DB::beginTransaction();
            try {
                $user->update([
                'name'  => $data['name'],
              ]);

                DB::commit();

                return response()->json([
                    'error' => false,
                    'message' => 'Cập nhập thành công tài khoản '.$user->email,
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
     * Check email if exists.
     *
     * @param  string  $email
     * @return boolean
     */
    public function checkEmail($email)
    {
        $user = User::where('email', $email)->count();

        if ($user == 0) {
            return response()->json([
                'exists'  => false,
            ]);
        } else {
            return response()->json([
                'exists'  => true,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

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

    public function lockAccount(Request $request)
    {
        $user = User::find($request->user_id);

        if (!empty($user)) {
            DB::beginTransaction();
            try {
                $user->update([
                  'status'  => $request->status,
                ]);

                if ($request->status == 1) {
                    $msg = "Tài khoản $user->email đã được kích hoạt";
                } else {
                    $msg = "Tài khoản $user->email đã bị khóa";
                }

                DB::commit();

                return response()->json([
                    'error' => false,
                    'message' => $msg,
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
    public function getRoles($id)
    {
        $user = User::find($id);
        $roles = Role::orderBy('created_at', 'desc')->get();

        if (!empty($roles)) {
            foreach ($roles as $key => &$role) {
                $role->checked = 0;
                $flag = RoleUser::where('user_id', $id)->where('role_id', $role->id)->first();

                if (!empty($flag)) {
                    $role->checked = 1;
                }
            }
        }
        return view('backend.accounts.user_roles', [
            'roles' => $roles,
            'user' => $user
        ]);
    }

    /**
     * add or delete role
     * @return [type] [description]
     */
    public function postRoles(Request $request)
    {
        $data = $request->all();

        if ($data['checked']) {
            DB::delete('delete from role_users where user_id = ? and role_id = ?', [$data['user_id'], $data['role_id']]);

            return response()->json([
                'error' => false,
                'message' => 'deleted'
            ], 200);
        } else {
            RoleUser::create($data);

            return response()->json([
                'error' => false,
                'message' => 'added'
            ], 200);
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
    return view('backend.admins.change-password');
}

 public function ChangePassword(Request $request){
    $oldpassword = $request->oldpassword;
    $password = $request->password;
    $passwordconf = $request->password_confirmation;
    if(Hash::check($request->oldpassword, Auth::user()->password) == true && $password == $passwordconf){
        $password = bcrypt($password);
        user::find(Auth::user()->id)->update(['password' => $password]);
        $message = 'Thay đổi mật khẩu thành công !';
        return view('backend.admins.change-password', ['messageSuccess'   =>  $message]);
    }else{
       $message = 'Nhập chưa đúng, Xin mời nhập lại !';
       return view('backend.admins.change-password', ['messageError'   =>  $message]);
   }
}
}
