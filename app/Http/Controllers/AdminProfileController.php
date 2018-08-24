<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use DB;
use Datatables;
use Entrust;

class AdminProfileController extends Controller
{
  public function __construct(){

      $this->middleware('revalidate');

      $this->middleware('auth');

  }

  public function index()
  {
    if (!Entrust::can('account-profile-menu')) {
        abort(404);
    }
    return view('backend.accounts.list');
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
   * Get the list of scientist accounts.
   *
   * @return \Illuminate\Http\Response
   */
  public function list()
  {
      $profiles = Profile::orderBy('id','desc')->with(['organization']);

      return Datatables::eloquent($profiles)
              ->addIndexColumn()
              ->editColumn('status', function($profile) {

                if ($profile->status == 0 && Entrust::can('account-unlock')) {

                  return '<label data-tooltip="tooltip" title="Mở khóa tài khoản" class="switch switch-small"><input type="checkbox" data-profile_id="'.$profile->id.'" class="lock-account"/><span></span></label>';

                } else if ($profile->status == 1 && Entrust::can('account-lock')) {

                  return '<label data-tooltip="tooltip" title="Khóa tài khoản" class="switch switch-small"><input type="checkbox" data-profile_id="'.$profile->id.'" checked class="lock-account"/><span></span></label>';

                }
              })
              ->editColumn('organization', function($profile) {
                  if ($profile->organization()->exists()) {
                      return $profile->organization->name;
                  } else {
                      return "Chưa cập nhập";
                  }
              })
              ->editColumn('email', function($profile){
                $string = '<a href="javascript:;" onclick="sendEmail('.$profile->id.')">'.$profile->email.'</a>';
                return $string;
              })
              ->editColumn('mobile', function($profile){
                $string = '<a id="call-mobile" href="#">'.$profile->mobile.'</a>';
                return $string;
              })
              ->addColumn('action', function($profile) {

                  $string = "";

                  // if (Entrust::can('account-detail')) {
                  //
                  //   $string .= '<a onclick="detail('.$profile->id.')" data-tooltip="tooltip" title="Xem chi tiết" href="javascript:;" class="btn btn-info"><i class="fa fa-eye"></i></a>';
                  // }

                  if (Entrust::can('user-edit')) {

                    $string .= '<a onclick="editModal('.$profile->id.')" data-tooltip="tooltip" title="Chỉnh sửa" href="javascript:;" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>';
                  }

                  if (Entrust::can('user-delete')) {

                    $string .= '<a data-id="'.$profile->id.'" data-tooltip="tooltip" title="Xóa tài khoản" href="javascript:;" class="btn btn-danger delete-btn btn-xs"><i class="fa fa-trash-o"></i></a>';
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
      $data = $request->only('name','email');

      if (!$this->checkEmail($data['email'])) {

        return response()->json([
            'error' => true,
            'message' => 'Email đã tồn tại, vui lòng sử dụng email khác'
        ]);
      }

      DB::beginTransaction();
      try {

        $data['password'] = bcrypt(123456);

        $profile = Profile::create($data);

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
      $profile = Profile::find($id);

      if (!empty($profile)) {

        return response()->json([
            'error'     =>  false,
            'profile' =>  $profile,
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
      $data = $request->only('email','name');

      $profile = Profile::where('email',$data['email'])->first();

      if (!empty($profile) && $profile->id == $id) {

          DB::beginTransaction();
          try {

            $profile->update([
              'name'  => $data['name'],
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
   * Check email if exists.
   *
   * @param  string  $email
   * @return boolean
   */
  public function checkEmail($email)
  {
      $profile = Profile::where('email',$email)->count();

      if ($profile == 0) {

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

      $profile = Profile::find($id);

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

  public function lockAccount(Request $request)
  {
      $profile = Profile::find($request->profile_id);

      if (!empty($profile)) {

          DB::beginTransaction();
          try {

              $profile->update([
                'status'  => $request->status,
              ]);

              if ($request->status == 1) {

                  $msg = "Tài khoản $profile->email đã được kích hoạt";
              } else {

                  $msg = "Tài khoản $profile->email đã bị khóa";
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
}
