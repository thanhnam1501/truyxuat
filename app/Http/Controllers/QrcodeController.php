<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User_History;
use App\Models\QrcodeHistory;
use App\Models\Qrcode_Product;
use Datatables;
use Auth;
use DB;
use App\Models\Company;
use App\Models\Qrcode;
use App\Models\Product;
use Validator;


class QrcodeController extends Controller
{
    public function __construct(){

       $this->middleware('auth');
   }
   public function index()
   { 
      return view('admin.qrcode.index');
  }

    /**
     * Get the list of scientist accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getlist()
    {   
        $data =  DB::table('qr_codes')
        ->join('users', 'qr_codes.user_id', '=', 'users.id') 
        ->join('companies', 'qr_codes.company_id', '=', 'companies.id')             
        ->select('qr_codes.*', 'users.name as user_name','companies.name as company_name' )
        ->orderBy('qr_codes.created_at', 'desc')
        ->get();

        return Datatables::of($data)
        ->addIndexColumn()
        ->editColumn('end', function($data){
            return number_format($data->end);
        })       
        ->addColumn('action', function($data) {
         $str = "";
         $str .= '<a data-tooltip="tooltip" title="Xuất file Excel" target="_blank" href="'.route('qrcode.exportQrcode', $data->id).'" class="btn btn-success btn-xs"><i class="fa fa-file-excel-o"></i></a>';

         $str .= '<a data-tooltip="tooltip" title="Chỉnh sửa" target="_blank" href="'.route('qrcode.block', $data->id).'" class="btn btn-warning btn-xs"><i class="fa fa-gear"></i></a>';
         return $str; 
     })   
        ->make(true);
    }

    public function getFormCreate(){
        $company = Company::get();
        return view('admin.qrcode.AddQrcode', ['company' => $company]);

    }

    public function store(Request $request){
        if($request->isMethod('post')) {
            /*validate data request*/
            Validator::make($request->all(), [
                'company_id' => 'required | integer',
                'start' => 'required | integer',
                'end' => 'required|integer'             
            ])->setAttributeNames([
                'company_id' => 'Chọn doanh nghiệp',
                'start' => 'Serial đầu',
                'end' => 'Serial cuối'
            ])->validate();
            $check_start = Qrcode::checkStart($request->company_id, $request->start);
            if($check_start != '') {
                return redirect()->route('qrcode.ShowFormCreate')->withErrors($check_start);
            }
            $qrcode = new Qrcode;
            $qrcode->company_id = $request->company_id;
            $qrcode->start = $request->start;
            $qrcode->end = $request->end;
            $qrcode->note = $request->note;
            $qrcode->user_id = Auth::user()->id;
            $qrcode->save();
            \Session::flash('msg_qrcode', "Thêm mới thành công");
            return redirect()->route('qrcode.index');
        }
        /*get all company*/
        $data['listCompany'] = Company::getListDropdown(); 
        return view('qrcode.add', $data);
    }

    public function checkStart(Request $request) 
    {
        if($request->has('type')) {
            return response()->json([
                '_start' => Qrcode::checkStart($request->company_id, 0, 'get'),
                'products' => Product::where('company_id', $request->company_id)->get(),
            ]);
        } else {
            return response()->json([
                'msg' => Qrcode::checkStart($request->company_id, $request->start)
            ]);
        }
    }

    public function exportQrcode ($id) {
        set_time_limit(3600);
        ob_end_clean();
        ob_start();
        $qrcode = Qrcode::find($id);
        if($qrcode) {
            /*$data[] = [
                'STT',
                'Serial',
                'Value QR Code'
            ];*/ 
            $data = [];
            $stt = 1;
            /* type = 1: xacthuc.smartcheck, type = 2: open*/

            for ($i = $qrcode->start; $i <= $qrcode->end; $i++) {
                $url = url("truy-xuat?id=".$qrcode->company_id."&stt=".str_pad($i, 10, '0', STR_PAD_LEFT));
                $data[] = [
                    $stt,
                    str_pad($i, 10, '0', STR_PAD_LEFT),
                    $url,
                ];
                $stt++;
            }
           
            return view('admin.qrcode.exportQrcode', ['data' => $data, 'guid' => $id, 'name' => $qrcode->company->name]);
        } else {
            return redirect()->route('qrcode.index', ['errorCode'=>404, 'msg'=>"Not found request!"]);
        }
    }

     public function getForm($type, $company_id, $guid) {    
            $data['guid'] = $guid;
            $data['company_id'] = $company_id;
            $data['listProduct'] = Product::where('company_id', $company_id)->get();
            $view = view('admin.qrcode.AddProduct', $data)->render();
        return response()->json(['html' => $view]);
    }

    public function getFormRestore(){
        $company = Company::get();
        return view('admin.qrcode.restore',['companies' => $company]);
    }

    public function restore(Request $request){
        try {
           $serial = str_pad($request->serial, 10, '0', STR_PAD_LEFT);
           QrcodeHistory::where('company_id', $request->company_id)
           ->where('stt', $serial)
           ->delete();
           return redirect()->route('qrcode.getRestore')->with('messageSuccess' , 'Khôi phục thành công!');
        } catch (Exception $e) {
            return view('errors.500')->withErrors();
        }
    }

    public function getHistory(){
        return view('admin.qrcode.historyQrcode');
    }

     public function getListHistory(Request $request){
        $data =  QrcodeHistory::orderBy('created_at', 'desc')->get();

        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('company_name', function($data) {
        $str = $data->company->name;
         return $str; 
     })   
        ->make(true);
    }

    
}
