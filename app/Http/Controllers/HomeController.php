<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Node;


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
        }else{
            $nodes = null;
            $data = null;
        }
        return view('check',['data' => $data, 'nodes' => $nodes]);
    }

    public function showBySlug($slug)
    {       
        $data = Product::whereSlug($slug)->firstOrFail();
        if(!empty($data)){
            $nodes = Node::where('product_id', $data[''])->get();
        }else{
            $nodes = null;
             $data = null;
        }
        return view('check',['data' => $data, 'nodes' => $nodes]);
    }

    
}
