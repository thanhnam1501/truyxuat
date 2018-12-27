<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
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
use Carbon;

class QuotesController extends Controller
{
	public function __construct(){

		$this->middleware('auth');
	}

	public function index(){
		return view('admin.quotes.quotes');
	}

	public function getList(){
		$products = Quote::get();

		return Datatables::of($products)
		->editColumn('status', function($products){
			$string = "";
			if($products->status == 1){
				$string = '<a data-tooltip="tooltip" title="Đã kích hoạt" href="javascript:;" onclick="activated('. $products->id .')" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>';
			}
			else{
				$string = '<a data-tooltip="tooltip" title="Chưa kích hoạt" href="javascript:;" onclick="activated('. $products->id .')" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></a>';
			}
			return $string;      
		})
		->addIndexColumn()
      // ->addColumn()           
		->addColumn('action', function($products) {
			$string = "";
			// $string .= '<a data-tooltip="tooltip" title="Xem chi tiết" target="_blank" href="'.route('showBySlug', $products->slug).'" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>';

			$string .= '<a data-tooltip="tooltip" title="Chỉnh sửa" href="'.route('quotes.edit', $products->id).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>';


			$string .= '<a data-tooltip="tooltip" title="Xóa sản phẩm" href="javascript:;" onclick="deleteProduct('. $products->id .')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';

			return $string;
		})
		->make(true);
	}

	public function getFormCreate (){
		return view('admin.quotes.AddQuotes');
	}

	public function store(Request $request){
		$data = $request->all();

      // $validatedData = $request->validate([
      //   'name' => 'required',
      //   'email' => 'required|string|unique:profiles,email',
      //   'mobile' => 'required',     
      // ]);

      DB::beginTransaction();
      try {
        $user = Quote::where('time_limit', $data['time_limit'])->first();

        if (!empty($user)) {

          $user->update([
            'name'    => $data['name'],
            'product_limit'    => $data['product_limit'],
            'account_limit'    => $data['account_limit'],
            'status'  => 1,
            'price' => $data['price'] 
          ]);
        } else {
          $user = Quote::create($data);
        }

        DB::commit();
        \Session::flash('flash_message','Thêm báo giá thành công !');
        return view('admin.quotes.quotes');
      } catch (Exception $e) {
        DB::rollback();

        Log::info($e->getMessage());

        return response()->json([
          'error' => true,
          'message' => $e->getMessage()
        ]);
      }
	}

	
}
