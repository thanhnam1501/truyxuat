<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use DB;
use Datatables;
use QrCode;
use Auth;
use App\Models\Imageupload;

class ProductController extends Controller
{
  public function __construct()
  {
   $this->middleware('auth.profile');
 }
 public function getFormCreate (){
  $companies = Company::get();
  return view('user.product.AddProduct',['companies' => $companies]);
}

public function index()
{ 
  return view('user.product.index');
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

        $string .= '<a data-tooltip="tooltip" title="Thêm vai trò" href="'.route('user.product.edit', $products->id).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>';

        $string .= '<a data-tooltip="tooltip" title="Thêm vai trò" href="javascript:;" onclick="deleteProduct('. $products->id .')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';

        return $string;
      })
      ->make(true);
    }


    public function store(Request $request)
    {

     $data = $request->all();

     $data['slug'] = str_slug($data['name']);

     $data['company_id'] = Auth::guard('profile')->user()->company_id;


     if($request->hasFile('image')){
      $path = $request->file('image')->store('image');
      $data['image'] = $path;
    };

    $product = Product::create($data);

    if($request->hasFile('image')){
      $image = new Imageupload();
      $image->content_id = $product->id;
      $image->path = $data['image'];
      $image->save();
    };

    return redirect()->route('user.product.edit',['id' => $product['id']]);

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
      return view('user.product.EditProduct', ['data' => $data, 'companies' => $companies, 'url' => $url,]);
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
