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


class AdminProductController extends Controller
{
  public function getFormCreate (){
    $companies = Company::get();
    return view('admin.product.AddProduct',['companies' => $companies]);
  }

  public function index()
  { 
    return view('admin.product.index');
  }

  public function show($id)
{ 
  $product = Product::find($id);
  $nodes = Node::where('product_id', $product->id)->get();
  
  return view('admin.product.showProduct', ['product' => $product, 'nodes' => $nodes]);
}

    /**
     * Get the list of scientist accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getlist()
    {
      $products = DB::table('products')
      ->join('companies', 'companies.id', '=', 'products.company_id')
      ->select('products.*', 'companies.name as company_name')
      ->get();

      return Datatables::of($products)
      ->addIndexColumn()
      // ->addColumn()           
      ->addColumn('action', function($products) {
        $string = "";

        $string .= '<a data-tooltip="tooltip" title="Xem chi tiết" href="'.route('product.show', $products->id).'" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>';


        $string .= '<a data-tooltip="tooltip" title="Chỉnh sửa" href="'.route('product.edit', $products->id).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>';


        $string .= '<a data-tooltip="tooltip" title="Xóa" href="javascript:;" onclick="delete('. $products->id .')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';

        return $string;
      })
      ->make(true);
    }

    public function edit($id)
    {
      $data = Product::find($id);
      $companies = Company::get();
      $url = url("san-pham/{$data->id}");
      return view('admin.product.EditProduct', ['data' => $data, 'companies' => $companies, 'url' => $url,]);
    }

    public function store(Request $request)
    {
     $data = $request->all();

     if($request->hasFile('image')){
      $path = $request->file('image')->store('image');
      $data['image'] = $path;
    };

    $product = Product::create($data);

    $data['slug'] = str_slug($data['name']);

    if(Product::where('slug', $data['slug'])){
      $data['slug'] = $data['slug'] .'-'. $product->id;
    }
    Product::find($product->id)->update(['slug' => $data['slug']]);
    if($request->hasFile('image')){
      $image = new Imageupload();
      $image->content_id = $product->id;
      $image->path = $data['image'];
      $image->save();
    };

    if($data['node'] == 0){
    return redirect()->route('product.edit',['id' => $product['id']]);
  } 
    else{
      return redirect()->route('node.ShowFormCreate', ['node' => $data['node'], 'product_id' =>  $product['id'], 'company_id' => $product['company_id'],]);
    }

  }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $data = $request->all();

      $product = Product::where('id', $data['id'])->first();

      if (!empty($product)) {
        DB::beginTransaction();
        try {
          $product->update($data);

          DB::commit();

          return redirect()->route('product.edit',['id' => $product['id']]);
        } catch (Exception $e) {
          DB::rollback();

          Log::info($e->getMessage());

          return redirect()->route('product.edit',['id' => $product['id']]);
        }
      } else {

       return redirect()->route('product.edit',['id' => $product['id']]);
     }
   }

 }
