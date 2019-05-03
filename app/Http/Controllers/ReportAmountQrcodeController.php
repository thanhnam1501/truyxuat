<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportAmountQrcode;
use Datatables;
use Auth;
use App\Models\Product;
use App\Models\profile;
use DB;


class ReportAmountQrcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth.profile');
    }

    public function index()
    {

        return view('user.qrcode.reportAmountQrcode');
    }

    public function getList()
    {
        if (Auth::guard('profile')->user()->type == 1) {
            $data = ReportAmountQrcode::where('company_id', Auth::guard('profile')->user()->company_id)->get();

        } else {
            $data = ReportAmountQrcode::where('company_id', Auth::guard('profile')->user()->company_id)->where('user', Auth::guard('profile')->user()->id)->get();

        };


        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($data) {
                if ($data->status == 1) {
                    $string = '<a data-tooltip="tooltip" title="Đã kích hoạt" href="javascript:;" onclick="activated(' . $data->id . ')" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>';
                } else {
                    $string = '<a data-tooltip="tooltip" title="Chưa kích hoạt" href="javascript:;" onclick="activated(' . $data->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></a>';
                }
                return $string;
            })
            ->addColumn('action', function ($data) {
                $string = "";

                if ($data['status'] === 0)
                    $string .= '<a data-tooltip="tooltip" title="Xóa sản phẩm" href="javascript:;" onclick="deleteReport(' . $data->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                return $string;
            })
            ->addColumn('user_name', function ($data) {
                $string = Profile::find($data['user_id'])->name;
                return $string;
            })
            ->addColumn('product_name', function ($data) {
                // $string = Profile::find($data['user_id'])->name;
                $string = $data->product->name;
                return $string;
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('profile')->user()->type == 1) {
            $product = Product::where('company_id', Auth::guard('profile')->user()->company_id)->get();
        } else {
            $product = Product::where('user_id', Auth::guard('profile')->user()->id)->get();
        }
        return view('user.qrcode.formCreateReport', ['products' => $product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_report = new ReportAmountQrcode();
        $new_report['name'] = $request->name;
        $new_report['amount'] = $request->amount;
        $new_report['product_id'] = $request->product_id;
        $new_report['status'] = 0;
        $new_report['user_id'] = Auth::guard('profile')->user()->id;
        $new_report['company_id'] = Auth::guard('profile')->user()->company_id;
        $new_report->save();
        return redirect()->route('user.report.qrcode.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $report = ReportAmountQrcode::find($request->id);

        if (!empty($report)) {
            DB::beginTransaction();
            try {
                $report->delete();

                DB::commit();

                return response()->json([
                    'error' => false,
                    'message' => 'Sản phẩm ' . $report->name . ' đã bị xóa',
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
                'error' => true,
                'message' => 'Không tìm thấy sản phẩm, vui lòng thử lại sau',
            ]);

        }
    }

    public function activated(Request $request)
    {
        $id = $request->id;
        $products = ReportAmountQrcode::find($id);
        if ($products->status == 1) {
            $data = ReportAmountQrcode::find($id)->update(['status' => 0]);
        } else {
            $data = ReportAmountQrcode::find($id)->update(['status' => 1]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Thay đổi trạng thái thành công !',
        ]);
    }

}

