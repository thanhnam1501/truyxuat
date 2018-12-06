<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User_History;
use Datatables;
use Auth;
use DB;


class User_HistoryController extends Controller
{
    public function __construct(){

     $this->middleware('auth.profile');
  }
	public function index()
	{ 
		return view('user.index_history');
	}

    /**
     * Get the list of scientist accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getlist()
    {   
        $history =  DB::table('user_histories')
            ->join('profiles', 'user_histories.user_id', '=', 'profiles.id')       
            ->select('user_histories.*', 'profiles.name as user_name')
            ->orderBy('user_histories.created_at', 'desc')
            ->get();
    
    	return Datatables::of($history)
    	->addIndexColumn()
      // ->addColumn()           
    	->make(true);
    }
}
