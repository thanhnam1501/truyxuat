<?php

namespace App\Http\Controllers\Permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Datatables;

class PermissionController extends Controller
{
    public function index()
    {
    	return view('backend.permission.list');
    }

    public function getList()
    {
    	$permissions = Permission::select('name','display_name','description','created_at')->orderBy('id','desc');

    	return Datatables::of($permissions)
    			->addIndexColumn()
    			->editColumn('created_at', function($permission) {

    				$date = date('H:i | d-m-Y', strtotime($permission->created_at));

    				return $date;
    			})
    			->make(true);
    }
}
