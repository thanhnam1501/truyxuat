<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Node;
use App\Models\Qrcode;
use App\Models\Qrcode_Product;
use App\Models\Process;

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
        if(!empty($data)){
            $nodes = Node::where('product_id', $data->id)->get();
            $process = Process::where('product_id', $data['id'])->get();
        }else{
            $nodes = null;
            $data = null;
            $process = null;
        }
        
        return view('check',['data' => $data, 'nodes' => $nodes, 'process' => $process]);
        
    }

    public function showBySlug($slug)
    {       
        $data = Product::where('slug', $slug)->first();
        if(!empty($data)){
            $nodes = Node::where('product_id', $data['id'])->get();
            $process = Process::where('product_id', $data['id'])->get();
        }else{
            $nodes = null;
            $data = null;
            $process = null;
        }
        return view('check',['data' => $data, 'nodes' => $nodes, 'process' => $process]);
    }

    public function getDetail(Request $request)
    {       
        $qrcode = Qrcode_Product::where('company_id', $request->id)
        ->where('start', '<=', $request->stt)
        ->where('end','>=', $request->stt )
        ->first();
        
        $data = Product::find($qrcode['product_id']);
        
        if(!empty($data)){
            $nodes = Node::where('product_id', $data['id'])->get();
            $process = Process::where('product_id', $data['id'])->get();
        }else{
            $nodes = null;
            $data = null;
            $process = null;
        }
        return view('check',['data' => $data, 'nodes' => $nodes,'process' => $process]);
        
    }

    
}
