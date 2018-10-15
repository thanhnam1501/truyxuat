<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Datatables;
use DB;

class CompanyController extends Controller
{
  public static function index(){
   return view('company.index');
 }

 public static function getlist(Request $request){
  $data = Company::orderBy('id', 'desc');
  return Datatables::of($data)
  ->addIndexColumn()
  ->addColumn('action', function($data) {
    $string = "";

    $string .= '<a data-tooltip="tooltip" title="Thêm vai trò" href="'.route('company.edit', $data->id).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>';

    $string .= '<a data-tooltip="tooltip" title="Thêm vai trò" href="javascript:;" onclick="deleteCompany('. $data->id .')" class="btn btn-danger btn_delete btn-xs"><i class="fa fa-trash"></i></a>';
    return $string;
  })
  ->make(true);

}

public static function getFormCreate(){
 return view('company.AddCompany');
}

public static function create(Request $request){
  $data = $request->all();
  $create = Company::create($data);
  $message = 'Thêm mới thành công !';
  return redirect()->route('company.index',['message' => $message]);
}

public static function edit(Request $request){
  $id = $request->id;
  $data = Company::find($id);
  return view('company.Edit', [
    'data' => $data,
  ]);
}

public static function update(Request $request){
  $data = $request->all();
  Company::find($data['id'])->update($data);
  return view('company.index');
}

public static function delete(Request $request){
  $id = $request->id;
  $company = Company::find($id);

  if (!empty($company)) {

    DB::beginTransaction();
    try {

      $company->delete();

      DB::commit();

      return response()->json([
        'error' => false,
        'message' => 'Tài khoản '.$company->email.' đã bị xóa',
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

