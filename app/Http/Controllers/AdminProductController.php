<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use DB;
use Datatables;
use QRCode;


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

    /**
     * Get the list of scientist accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getlist()
    {
      $products = Product::orderBy('id', 'desc');

      return Datatables::of($products)
      ->addIndexColumn()
      // ->addColumn()           
      ->addColumn('action', function($products) {
        $string = "";

        $string .= '<a data-tooltip="tooltip" title="Thêm vai trò" href="'.route('product.edit', $products->id).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>';

        $string .= '<a data-tooltip="tooltip" title="Thêm vai trò" href="javascript:;" onclick="delete('. $products->id .')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';

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

      $product = Product::create($data);

      // $validatedData = $request->validate([
      //   'name' => 'required',
      //   'email' => 'required|string|unique:users,email',
      //   'mobile' => 'required',     
      // ]);

      DB::beginTransaction();
      try { 

        $product = Product::create($data);

        DB::commit();
        \Session::flash('flash_message','Thêm sản phẩm mới thành công !');
        return redirect()->route('product.edit',['id' => $product['id']]);
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
