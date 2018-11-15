<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Models\Node;
use DB;
use Datatables;
use QrCode;
use Auth;
use App\Models\Imageupload;
use App\Models\User_History;
use App\Models\Profile;

class ProductController extends Controller
{
  public function __construct()
  {
   $this->middleware('auth.profile');
 }
 public function getFormCreate (){
  $limit = Product::where('company_id',Auth::guard('profile')->user()->company_id)->count();

  $company = Company::find(Auth::guard('profile')->user()->company_id);

  $user = Profile::where('company_id',Auth::guard('profile')->user()->company_id)->get();

  if($limit >= $company->product_limit){
    $message = 'Đã đặt mức giới hạn sản phẩm là: ' . $company->product_limit;
    return view('user.product.index',['messageError' => $message]);
  }else{
    return view('user.product.AddProduct',['user' => $user]);
  }
}

public function index()
{ 
  return view('user.product.index');
}

public function show($id)
{ 
  $product = Product::find($id);
  $nodes = Node::where('product_id', $product->id)->get();
  
  return view('user.product.showProduct', ['product' => $product, 'nodes' => $nodes]);
}
    /**
     * Get the list of scientist accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getlist()
    {
      $products = Product::where('company_id', Auth::guard('profile')->user()->company_id)->orderBy('id', 'desc');

      return Datatables::of($products)
      ->addIndexColumn()
      // ->addColumn()           
      ->addColumn('action', function($products) {
        $string = "";
        $string .= '<a data-tooltip="tooltip" title="Xem chi tiết" href="'.route('user.product.show', $products->id).'" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>';

        $string .= '<a data-tooltip="tooltip" title="Chỉnh sửa" href="'.route('user.product.edit', $products->id).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>';

        $string .= '<a data-tooltip="tooltip" title="Xóa sản phẩm" href="javascript:;" onclick="deleteProduct('. $products->id .')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';

        return $string;
      })
      ->make(true);
    }


    public function store(Request $request)
    {

     $data = $request->all();

     $data['company_id'] = Auth::guard('profile')->user()->company_id;


     if($request->hasFile('image')){
      $path = $request->file('image')->store('image');
      $data['image'] = $path;
    };

    $product = Product::create($data);

    $data['slug'] = str_slug($data['name']);

    if(Product::where('slug', $data['slug'])){
      $data['slug'] = $data['slug'] .'-'. $product->id;
    }
    $check = Product::find($product->id)->update(['slug' => $data['slug']]);
    
    if($check == true){
      $user_history = new User_History();
      $user_history->user_id = Auth::guard('profile')->user()->id;
      $user_history->company_id = Auth::guard('profile')->user()->company_id;
      $user_history->content = 'Thêm mới sản phẩm: ' . $product->name;
      $user_history->save();
    }

    if($request->hasFile('image')){
      $image = new Imageupload();
      $image->content_id = $product->id;
      $image->path = $data['image'];
      $image->save();
    };
    if($data['node'] == 0){
      return redirect()->route('user.product.edit',['id' => $product['id']]);
    } 
    else{
      return redirect()->route('user.node.ShowFormCreate', ['node' => $data['node'], 'product_id' =>  $product['id']]);
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
      $data = Product::find($id);
      $companies = Company::get();
      $url = url("/check/{$data->id}");
      $user = Profile::where('company_id',Auth::guard('profile')->user()->company_id)->get();
      
      return view('user.product.EditProduct', ['data' => $data, 'companies' => $companies, 'url' => $url, 'user' => $user]);
    }
    
    public function update(Request $request)
    {
      $data = $request->all();

      $product = Product::where('id', $data['id'])->first();
      if($request->hasFile('image_update')){
        $path = $request->file('image_update')->store('image');
        $data['image'] = $path;
        $image = new Imageupload();
        $image->content_id = $product->id;
        $image->path = $data['image'];
        $image->save();
      };

      if (!empty($product)) {
        DB::beginTransaction();
        try {
          
          $product->update($data);
          $user_history = new User_History();
          $user_history->user_id = Auth::guard('profile')->user()->id;
          $user_history->company_id = Auth::guard('profile')->user()->company_id;
          $user_history->content = 'Cập nhật sản phẩm: ' . $product->name;
          $user_history->save();
          DB::commit();
          return redirect()->route('user.product.edit',['id' => $product['id']]);        

        } catch (Exception $e) {
          DB::rollback();

          Log::info($e->getMessage());

          return redirect()->route('user.product.edit',['id' => $product['id']]);
        }
      } else {

       return redirect()->route('user.product.edit',['id' => $product['id']]);
     }
   }

   public function destroy(Request $request)
   {
    $product = Product::find($request->id);

    if (!empty($product)) {
      DB::beginTransaction();
      try {
        $product->delete();

        DB::commit();

        return response()->json([
          'error' => false,
          'message' => 'Sản phẩm '.$product->name.' đã bị xóa',
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
