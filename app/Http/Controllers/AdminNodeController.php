<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Node;
use App\Models\Company;
use DB;
use Datatables;
use QrCode;
use Auth;
use App\Models\Imageupload;
use App\Models\User_History;
use App\Models\Profile;

class AdminNodeController extends Controller
{
	public function __construct()
	{
   $this->middleware('auth');
 }
 public function getFormCreate (Request $request){

  $data = $request->all();
  $user = Profile::where('company_id', $data['company_id'])->get();
  return view('admin.node.AddNode',['node' => $data['node'], 'product_id' => $data['product_id'],'company_id' => $data['company_id'], 'user' => $user]);

}

public function index()
{ 
  return view('admin.node.index');
}

    /**
     * Get the list of scientist accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getlist()
    {
    			$nodes = DB::table('nodes')
    			->join('products', 'products.id', '=', 'nodes.product_id')
    			->select('nodes.*', 'products.name as product_name')
    			->orderBy('nodes.created_at', 'desc')
    			->get();
    		
    		return Datatables::of($nodes)
    		->addIndexColumn()
      // ->addColumn()           
    		->addColumn('action', function($nodes) {
    			$string = "";

    			$string .= '<a data-tooltip="tooltip" title="Chỉnh sửa" href="'.route('node.edit', $nodes->id).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>';

    			$string .= '<a data-tooltip="tooltip" title="Xóa sản phẩm" href="javascript:;" onclick="deleteNode('. $nodes->id .')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';

    			return $string;
    		})
    		->make(true);
    	}


    	public function store(Request $request)
    	{

    		$data = $request->all();

    		for ($i=1; $i <= $data['node'] ; $i++) { 
    			$data['name'] = $data ['name'.$i] ;
    			$data['content'] = $data['content'.$i];
    			$data['user_id'] = $data['user_id'.$i];
    			$node = Node::create(['name' => $data['name'],'content' => $data['content'],'user_id' => $data['user_id'],'product_id' => $data['product_id']]);

    			$node_history = new User_History();
    			$node_history->user_id = Auth::guard('web')->user()->id;
    			$node_history->company_id = Auth::guard('web')->user()->company_id;
    			$node_history->content = 'Tạo mới node: ' . $node->name;
    			$node_history->product_id = $node->product_id;
    			$node_history->save();
    		}

    		if($data['node'] != 0){
    			return redirect()->route('product.edit',['id' => $data['product_id']]);
    		} 
    		else{
    			return redirect()->route('node.ShowFormCreate');
    		}

    	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
    	$data = Node::find($id);

    	return view('admin.node.EditNode', ['data' => $data]);
    }
    
    public function update(Request $request)
    {
    	$data = $request->all();

    	$node = Node::where('id', $data['id'])->first();

    	if (!empty($node)) {
    		DB::beginTransaction();
    		try {
    			$node->update($data);

    			$node_history = new User_History();
    			$node_history->user_id = Auth::guard('web')->user()->id;
    			$node_history->company_id = Auth::guard('web')->user()->company_id;
    			$node_history->content = 'Chỉnh sửa node: ' . $node->name ;
    			$node_history->product_id = $node->product_id;
    			$node_history->save();

    			DB::commit();

    			return redirect()->route('node.edit',['id' => $node['id']]);
    		} catch (Exception $e) {
    			DB::rollback();

    			Log::info($e->getMessage());

    			return redirect()->route('node.edit',['id' => $node['id']]);
    		}
    	} else {

    		return redirect()->route('node.edit',['id' => $node['id']]);
    	}
    }

    public function updateById(Request $request)
   {
    $data = $request->all();

    $node = Node::where('id', $data['id'])->first();

    if (!empty($node)) {
      DB::beginTransaction();
      try {
        $node->update($data);

        $node_history = new User_History();
        $node_history->user_id = Auth::guard('web')->user()->id;
        $node_history->company_id = Auth::guard('web')->user()->company_id;
        $node_history->content = 'Chỉnh sửa node: ' . $node->name ;
        $node_history->product_id = $node->product_id;
        $node_history->save();

        DB::commit();

     return redirect()->route('product.edit',['id' => $node['product_id'],]);
      } catch (Exception $e) {
        DB::rollback();

        Log::info($e->getMessage());

       return redirect()->route('product.edit',['id' => $node['product_id'],]);
      }
    } else {

      return redirect()->route('product.edit',['id' => $node['product_id'],]);
    }
  }

    public function activated(Request $request){
      $id = $request->id;
      $node = Node::find($id);
      if($node->status == 1){
        $data = Node::where('id', $id)->update(['status' => 0]);
      }
      else{
        $data = Node::where('id', $id)->update(['status' => 1]);
      }

      return response()->json([
        'node_status' => $node['status'],
        'status' => true,
        'message' => 'Thay đổi trạng thái thành công !',
      ]);
    }


    public function destroy(Request $request)
    {
     $node = Node::find($request->id);

     if (!empty($node)) {
      DB::beginTransaction();
      try {
       $node->delete();

       $node_history = new User_History();
       $node_history->user_id = Auth::guard('web')->user()->id;
       $node_history->company_id = Auth::guard('web')->user()->company_id;
       $node_history->content = 'đã xóa node: ' . $node->name ;
       $node_history->product_id = $node->product_id;
       $node_history->save();

       DB::commit();

       return response()->json([
        'error' => false,
        'message' => 'Bước cập nhật '.$node->name.' đã bị xóa',
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
