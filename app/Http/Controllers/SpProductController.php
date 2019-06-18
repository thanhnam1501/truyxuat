<?php

namespace App\Http\Controllers;

use App\Models\ReportAmountQrcode;
use App\Models\SpProduct;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Datatables;

class SpProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.profile');
    }

    public function index(Request $request)
    {
        return view('user.product.spProductIndex',['id' => $request->id]);
    }

    public function store(Request $request)
    {
        $spProduct_id = SpProduct::create([
            'product_id' => $request->product_id,
            'harvest_date' => $request->harvest_date,
            'expiration_date' => $request->expiration_date,
        ])->id;

        ReportAmountQrcode::create([
            'name' => $request->namePrint,
            'amount' => $request->amount,
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'company_id' => $request->company_id,
            'status' => 1,
        ]);
        $url = url("/view?spProduct_id=" . $spProduct_id);
        return response()->json([
            'status' => true,
            'data' => $url,
        ]);
    }

    public function getlist(Request $request)
    {
        $spProducts = SpProduct::select('sp_products.*', 'products.name as product_name')
            ->join('products', 'sp_products.product_id', '=', 'products.id')
            ->where('product_id', $request->id)
            ->orderBy('id', 'desc')
            ->get();

        return Datatables::of($spProducts)
            ->addIndexColumn()
            // ->addColumn()
            ->addColumn('action', function ($spProducts) {
                $string = "";
                $string .= '<a data-tooltip="tooltip" title="In Qr-Code" href="' . route('print.qrcode', $spProducts->id) . '" class="btn btn-info btn-xs"><i class="fa fa-qrcode"></i></a>';
                return $string;
            })
            ->make(true);
    }

    public function printQrcode($id)
    {
        $url = url("/view/$id");
       return view('user.product.printQrcode',['url' => $url]);
    }
}
