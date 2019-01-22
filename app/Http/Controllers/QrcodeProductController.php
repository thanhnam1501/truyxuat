<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Product;
use App\Models\Qrcode_Product;
use Validator;
use Auth;
use DB;
use Datatables;
use App\Models\Qrcode;
use Maatwebsite\Excel\Facades\Excel;



class QrcodeProductController extends Controller
{
	public function __construct(){

		$this->middleware('auth');
	}


    /**
     * Get the list of scientist accounts.
     *
     * @return \Illuminate\Http\Response
     */


    public function getFormCreate(Request $request){
        $id= $request->id;
        $block = Qrcode::find($id);

        $listProductAdd = Product::where('products.company_id', $block->company_id)->get();

        $list_product = Product::select('products.id', 'products.name', 'qrcode_products.start', 'qrcode_products.end', 'qrcode_products.amount', 'qrcode_products.protected_time_of_tem','qrcode_products.qrcode_id')
        ->join('qrcode_products', function($join) use ($id){
            $join->on('products.id', '=', 'qrcode_products.product_id');
            $join->where('qrcode_products.qrcode_id', $id);
        })
        ->where('products.company_id', $block->company_id)
        ->orderBy('qrcode_products.start', 'ASC')
        ->get();
        if (count($list_product) == 0) {
            $list_product = Product::select('products.id', 'products.name', \DB::raw('\'\' as start, \'\' as end, \'\' as amount'))
            ->where('products.company_id', $block->company_id)
            ->orderBy('products.id', 'ASC')
            ->get();
        }




        return view('admin.qrcode.block', ['block' => $block,'listProduct' => $list_product,'listProductAdd' => $listProductAdd]);

    }

    public function saveBlockProduct(Request $request) {
        $data_insert = [];
        try {
            if($request->has('product')) {
                foreach ($request->product as $id => $product) {
                    if($product['start'] != '' && $product['end'] != '' && $product['amount'] != '') {
                        $insert_item = [];
                        $insert_item['qrcode_id'] = $request->guid;
                        $insert_item['company_id'] = $request->company_id;
                        $insert_item['product_id'] = $id;
                        $insert_item['start'] = $product['start'];
                        $insert_item['amount'] = $product['amount'];
                        $insert_item['end'] = $product['end'];
                        $insert_item['protected_time_of_tem'] = $product['protected_time_of_tem'];
                        $insert_item['user_id'] = Auth::user()->id;
                        $insert_item['created_at'] = date('Y-m-d H:i:s');
                        $insert_item['updated_at'] = date('Y-m-d H:i:s');
                        $data_insert[] = $insert_item;
                    }
                }
            }
            Qrcode_Product::where('company_id', $request->company_id)
            ->where('qrcode_id', $request->guid)
            ->delete();
            if(count($data_insert) > 0) {
                \DB::table('qrcode_products')->insert($data_insert);
            }
            return response()->json(['msg' => 'Lưu thành công!']);
        } catch(Exception $e) {
            return response()->json(['msg' => 'Có lỗi xảy ra!']);
        }
    }

    public function addProduct(Request $request){
        try {
            $data_insert['qrcode_id'] = $request->id;
            $data_insert['company_id'] = $request->company_id;
            $data_insert['user_id'] = Auth::user()->id;
            $data_insert['product_id'] = $request->product_id;

            $data = Qrcode_Product::create($data_insert);
            return response()->json(['data' => $data]);
        } catch (Exception $e) {
           return response()->json(['msg' => 'Có lỗi xảy ra!']);
       }
   }
}
