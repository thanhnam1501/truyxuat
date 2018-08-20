<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;

class ApplyLog extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'apply_logs';

    protected $fillable = ['profile_id', 'content', 'old_data','new_data', 'table_name', 'record_id', 'admin_id'];

    //* Begin function create logs *//
    //*
   	//	$data = [
   	//		'profile_id',
   	//		'content',
   	//		'old_data', --> json
   	//		'new_data', -->	json
   	//		'table_name',
   	//		'record_id'
   	//	];
    //*

    public static function createLog($data){
    	DB::beginTransaction();

    	try {

    		self::create($data);

    		DB::commit();

    		return response()->json([
    			'error'		=>	false,
    			'msg'		=>	'Create Success'
    		]);

    	} catch (Exception $e) {

    		return response()->json([
    			'error'		=>	true,
    			'msg'		=>	$e->getMessage()
    		]);
    	}
    }

    //* End *//

}
