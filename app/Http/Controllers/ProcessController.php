<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Process;
use App\Models\Product;
use App\Models\User_History;
use App\Models\Profile;
use Datatables;
use DB;

class ProcessController extends Controller
{
  public function __construct()
  {
   $this->middleware('auth.profile');
 }
 public function index(){
  return view('user.process.index');
}

public function getList(){
  if(Auth::guard('profile')->user()->type == 1){
    $process =  DB::table('process')
    ->join('products', 'process.product_id', '=', 'products.id') 
    ->join('profiles', 'process.user_id', '=', 'profiles.id') 
    ->select('process.*', 'products.name as product_name', 'profiles.name as user_name')
    ->orderBy('process.created_at', 'desc')
    ->get();

  }else{
    $process =  DB::table('process')
    ->join('products', 'process.product_id', '=', 'products.id') 
    ->join('profiles', 'process.user_id', '=', 'profiles.id') 
    ->select('process.*', 'products.name as product_name', 'profiles.name as user_name')
    ->where('process.user_id', Auth::guard('profile')->user()->id)
    ->orderBy('process.created_at', 'desc')
    ->get();

  }
  return Datatables::of($process)
  ->addIndexColumn()
  ->editColumn('status', function($process){
    $string = "";
    if($process->status == 1){
      $string = '<a data-tooltip="tooltip" title="Đã kích hoạt" href="javascript:;" onclick="activated('. $process->id .')" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>';
    }
    else{
      $string = '<a data-tooltip="tooltip" title="Chưa kích hoạt" href="javascript:;" onclick="activated('. $process->id .')" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></a>';
    }
    return $string; 
  })
  ->addColumn('action', function ($process){
    $string = "";
    $string .= '<a data-tooltip="tooltip" title="Sửa thông tin" href="'.route('user.process.edit', $process->id).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>';
    if(Auth::guard('profile')->user()->type == 1 || Auth::guard('profile')->user()->type == 2){
      $string .= '<a data-tooltip="tooltip" title="Xóa quy trình" href="javascript:;" onclick="deleteProcess('. $process->id .')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
    }
    return $string;
  })
  ->make(true);
}

public function getFormCreate(Request $request){
  $products = Product::where('company_id', Auth::guard('profile')->user()->company_id)->orderBy('created_at', 'desc')->get(); 
  return view('user.process.addProcess', ['products' => $products]); 
}
public function getFormCreateProcess(Request $request){
  $data = $request->all();
  $user = Profile::where('company_id', Auth::guard('profile')->user()->company_id)->orderBy('created_at', 'desc')->get(); 
  return view('user.process.addProcess', ['data' => $data,'user' => $user]); 
}

public function create(Request $request){
  $data = $request->all();

  for ($i=1; $i <= $data['number_process'] ; $i++) { 
   $data['name'] = $data ['name'.$i] ;
   $data['user_id'] = $data['user_id'.$i];
   $node = Process::create(['name' => $data['name'],'user_id' => $data['user_id'],'product_id' => $data['product_id']]);

   $node_history = new User_History();
   $node_history->user_id = Auth::guard('profile')->user()->id;
   $node_history->company_id = Auth::guard('profile')->user()->company_id;
   $node_history->content = 'Tạo mới process: ' . $node->name;
   $node_history->product_id = $node->product_id;
   $node_history->save();
 }

 if($data['number_process'] != 0){
  return redirect()->route('user.product.edit',['id' => $data['product_id']]);
} 
else{
  return redirect()->route('user.process.ShowFormCreate');
}
}

public function edit(Request $request){
  try {
    $data = Process::where('id', $request->id)->first();
    $user = Profile::where('id', $data['user_id'])->first();
    $user = Profile::where('company_id', $user['company_id'])->get();

    return view('user.process.editProcess', ['data' => $data, 'user' => $user]);

  } catch (Exception $e) {
    return redirect()->route('user.process.index');
  } 

}

public function update(Request $request){
  try {
   $data = $request->all();

   $process = Process::where('id', $data['id'])->first();

   if (!empty($process)) {
    DB::beginTransaction();
    try {
      $process->update($data);

      $node_history = new User_History();
      $node_history->user_id = Auth::guard('profile')->user()->id;
      $node_history->company_id = Auth::guard('profile')->user()->company_id;
      $node_history->content = 'Chỉnh sửa quy trình sản xuất: ' . $process->name ;
      $node_history->product_id = $process->product_id;
      $node_history->save();

      DB::commit();

      return redirect()->route('user.process.edit',['id' => $process['id']]);
    } catch (Exception $e) {
      DB::rollback();

      Log::info($e->getMessage());

      return redirect()->route('user.process.edit',['id' => $process['id']]);
    }
  } else {

   return redirect()->route('user.process.edit',['id' => $process['id']]);
 }
} catch (Exception $e) {
 return Redirect::back()->withErrors(['msg', 'Lỗi, Xin hãy sửa lại!']);
}
}

public function activated(Request $request){
  $id = $request->id;
  $products = Process::find($id);
  if($products->status == 1){
    $data = Process::find($id)->update(['status' => 0]);
  }
  else{
    $data = Process::find($id)->update(['status' => 1]);
  }

  return response()->json([
    'status' => true,
    'message' => 'Thay đổi trạng thái thành công !',
  ]);
}


public function delete(Request $request){
 $process = Process::find($request->id);

 if (!empty($process)) {
  DB::beginTransaction();
  try {
    $process->delete();

    $node_history = new User_History();
    $node_history->user_id = Auth::guard('profile')->user()->id;
    $node_history->company_id = Auth::guard('profile')->user()->company_id;
    $node_history->content = 'đã xóa node: ' . $process->name ;
    $node_history->product_id = $process->product_id;
    $node_history->save();

    DB::commit();

    return response()->json([
      'error' => false,
      'message' => 'Quy trình '.$process->name.' đã bị xóa!',
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
    'message' =>  'Không tìm thấy sản phẩm, vui lòng thử lại sau',
  ]);
}
}


}
