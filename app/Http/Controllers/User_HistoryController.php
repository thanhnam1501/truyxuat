<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User_History;
use Datatables;
use Auth;


class User_HistoryController extends Controller
{
	public function index()
	{ 
		return view('admin.history');
	}

    /**
     * Get the list of scientist accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getlist()
    {
    	$history = User_History::where('company_id',Auth::guard('profile')->user()->company_id)->orderBy('id', 'desc');

    	return Datatables::of($history)
    	->addIndexColumn()
      // ->addColumn()           
    	->addColumn('name', function($history) {
    		$name = Profile::find($history['user_id'])->name;
    		return $name;
    	})
    	->make(true);
    }
}
