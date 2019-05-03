<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Node;
use App\Models\Process;
use App\Models\Product;
use App\Models\Qrcode_Product;
use App\Models\QrcodeHistory;
use App\Models\SpProduct;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = Product::find($id);

        // kiểm tra hạn
        $company = Company::find($data->company_id);
        $created_at = $company->created_at;
        $date = $created_at->addMonths($company->time_limit);
        $now = date('Y-m-d H:i:s');
        // End

        if (!empty($data) && $now < $date) {
            $this->transferWebsite($data);
            $nodes = Node::where('product_id', $data->id)->get();
            $process = Process::where('product_id', $data['id'])->get();
            $type = 0;
        } else {
            $nodes = null;
            $data = null;
            $process = null;
            $type = 0;
        }

        return view('check', ['data' => $data, 'nodes' => $nodes, 'process' => $process, 'type' => $type]);

    }

    public function showBySlug($slug)
    {

        $data = Product::where('slug', $slug)->first();
        if (!empty($data)) {
            $this->transferWebsite($data);
            $nodes = Node::where('product_id', $data['id'])->get();
            $process = Process::where('product_id', $data['id'])->get();
            $type = 0;
        } else {
            $nodes = null;
            $data = null;
            $process = null;
            $type = 0;
        }
        return view('check', ['data' => $data, 'nodes' => $nodes, 'process' => $process, 'type' => $type]);
    }

    public function getDetail(Request $request)
    {

        $qrcode = Qrcode_Product::where('company_id', $request->id)
            ->where('start', '<=', $request->stt)
            ->where('end', '>=', $request->stt)
            ->first();

        $company = Company::find($request->id);
        $created_at = $company->created_at;
        $date = $created_at->addMonths($company->time_limit);
        $now = date('Y-m-d H:i:s');
        $data = Product::find($qrcode['product_id']);

        if (!empty($data) && $now < $date) {
            QrcodeHistory::create(['company_id' => $request->id, 'stt' => $request->stt]);
            $check = QrcodeHistory::where('company_id', $request->id)->where('stt', $request->stt)->count();

            if ($qrcode->time_scans == 0 || $check <= $qrcode->time_scans) {
                $this->transferWebsite($data);
                $nodes = Node::where('product_id', $data['id'])->get();
                $process = Process::where('product_id', $data['id'])->get();
                $time_scans = $check;
                $type = $qrcode->type;
            } else {
                return view('admin.qrcode.errorTimes');
            }

        } else {
            $nodes = null;
            $data = null;
            $process = null;
            $time_scans = null;
            $type = 0;
        }

        return view('check', ['data' => $data, 'nodes' => $nodes, 'process' => $process, 'serial' => $request->stt, 'time_scans' => $time_scans, 'type' => $type]);
    }


    public function getViewPrint(Request $request)
    {
        $data = $request->all();
        return view('print', ['data' => $data]);
    }

    public function transferWebsite($data)
    {
        if ($data['link_product'] != null) {
            header("Location: " . $data['link_product']);
            die();
        }
    }

    public function getProductBySpProduct(Request $request)
    {
        $data = SpProduct::select()
            ->join('products', 'products.id', '=', 'sp_products.product_id')
            ->where('sp_products.id', $request->spProduct_id)
            ->get();
        $nodes = Node::where('product_id', $data['0']['product_id'])->get();
        return view('check2', ['data' => $data['0'], 'nodes' => $nodes]);
    }

}
