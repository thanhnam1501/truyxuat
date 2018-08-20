<?php

namespace App\Http\Controllers;

use Validator;
use DB;
use Log;
use Illuminate\Http\Request;
use Datatables;
use App\Models\Role;
use Entrust;
use App\Models\PermissionRole;
use App\Models\RoleUser;
use App\Models\Permission;

class RoleController extends Controller
{
    public function __construct() {


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.roles.index');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        \DB::beginTransaction();

        try {


            $role = Role::where('name', $data['name'])->first();
            if (empty($role) && $role == 0) {

                 Role::create($data);

                 \DB::commit();

                 return response()->json([
                    'error' => false,
                    'data' => 'success'
                ]);
             }
             else {
                return response()->json([
                    'error' => true,
                    'message' => 'Vai trò đã tồn tại'
                ]);
             }


            // $user->attachRole($role);

            // Commit d


        } catch (\Exception $e) {

            \DB::rollback();

            \Log::info($e->getMessage());

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
        return response()->json([
            'error' => false,
            'data' => Role::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $data = $request->all();

        $rules = [
            'display_name' => 'required',
            'name' => 'required|unique:roles,name,' .$id,
            // 'name' => 'required',
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập vai trò',
            'name.unique' => 'Vai trò đã tồn tại, vui lòng nhập vai trò khác',
            'display_name.required' => 'Vui lòng nhập tên hiển thị',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        } else {
            \DB::beginTransaction();

            try {
                $role = Role::where('id', $id)->first();
                $role->update($data);


                // $user->attachRole($role);

                // Commit db
                \DB::commit();

                return response()->json([
                        'error' => false,
                        'data' => 'success'
                    ]);

            } catch (\Exception $e) {

                \DB::rollback();

                \Log::info($e->getMessage());

                return response()->json([
                        'error' => false,
                        'message' => $e->getMessage()
                    ]);
            }
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
        DB::beginTransaction();
        try {

            PermissionRole::where('role_id')->delete();
            RoleUser::where('role_id', $id)->delete();
            Role::where('id', $id)->delete();

            DB::commit();

            return response()->json([
                    'error' => false,
                    'message' => 'Delete success!'
                ], 200);

        } catch(Exception $e) {
            Log::info('Can not delete role has id = ' . $id);
            DB::rollback();
            return response()->json([
                    'error' => true,
                    'message' => 'Internal Server Error'
                ], 500);
        }
    }

    public function getListRole() {
        $roles = Role::orderBy('id', 'DESC')->get();

        return Datatables::of($roles)
            ->addColumn('action', function ($role) {
                $string = '';
                if (true) {
                    $string = $string .' <a href="roles/' . $role->name .'/list-permissions" data-tooltip="tooltip" title="Xem vai trò" class="btn btn-info btn-xs">
                            <i class="fa fa-shield" aria-hidden="true"></i></a>';
                }

                if (Entrust::can(['roles-edit'])) {
                    $string = $string . '<a href="javascript:;" onclick="" data-tooltip="tooltip" title="Sửa vai trò" class="btn btn-warning btn-xs editRole" data-id="' .$role->id .'">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                }
                if (Entrust::can(['roles-delete'])) {
                    $string = $string . '<a href="javascript:;" type="submit" data-tooltip="tooltip" title="Xoá vai trò" class="btn btn-danger btn-xs alertDel" data-id="' .$role->id .'">
                            <i class="fa fa-trash-o"></i></a>';
                }
                return $string;
            })
        ->addIndexColumn()
        ->make(true);
    }

    public function getPermissions($name) {
        $role = Role::where('name', $name)->first();

        return view('backend.roles.permissions',[
            'role' => $role,
            'name' => $name
        ]);
    }

    public function getListPermission($name)
    {
        $role = Role::where('name', $name)->first();

        $permissions = Permission::all();

        if(!empty($permissions)) {
            foreach ($permissions as $key => &$permission) {
                $permission->checked = 0;
                $flag = PermissionRole::where('role_id', $role->id)->where('permission_id', $permission->id)->first();
                if(!empty($flag)) {
                    $permission->checked = 1;
                }
            }
        }
        return Datatables::of($permissions)
            ->addColumn('action', function ($permission) use ($role) {

                $string = '<input type="hidden" id="checked-' .$permission->id . '" value="'. $permission->checked . '">';
                if (!empty($permission->checked)) {
                    $string = $string .'<i id="action-'. $permission->id .'" class="fa fa-check-circle addPermission" title="Xoá" aria-hidden="true" style="cursor: pointer; color: #3598dc;font-size: 20px;" data-role="'.$role->id.'" data-permission="'.$permission->id .'"></i>';
                }
                else {
                    $string = $string .'<i id="action-'. $permission->id .'" class="fa fa-circle-o addPermission" title="Thêm" aria-hidden="true" style="cursor: pointer; color: #3598dc;font-size: 20px;" data-role="'.$role->id.'" data-permission="'.$permission->id .'"></i>';
                }
                return $string;
            })
            ->make(true);
    }

    public function postPermissions(Request $request) {

        $data = $request->all();


        if ($data['checked']) {

            DB::delete('delete from permission_roles where permission_id = ? and role_id = ?', [$data['permission_id'], $data['role_id']]);

            return response()->json([
                'error' => false,
                'message' => 'deleted'
            ], 200);


        } else {

            // $permission_role = new PermissionRole;
            // $permission_role->permission_id = $data['permission_id'];
            // $permission_role->role_id = $data['role_id'];
            // $permission_role->save();
            PermissionRole::create($data);

            return response()->json([
                'error' => false,
                'message' => 'added'
            ], 200);
        }
    }

}
