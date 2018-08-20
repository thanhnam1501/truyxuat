<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scientist;
use DB;
use Datatables;

class ScientistController extends Controller
{
    public function __construct(){

        $this->middleware('revalidate');

        $this->middleware('auth.profile');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.scientists.dashboard');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
