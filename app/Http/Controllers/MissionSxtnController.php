<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MissionSxtn;
use App\Models\MissionSxtnValue;
use App\Models\MissionSxtnAttribute;
use App\Models\MissionSxtnAttributeValue;
use App\Models\RoundCollection;
use App\Models\Organization;
use App\Models\Company;
use App\Models\MissionFile;
use Auth;
use DB;
use Response;
use Money;
use Crypt;
use Carbon\Carbon;
use Datatables;
use Log;
use UploadFile;

class MissionSxtnController extends Controller
{

    public function __construct() {
        $this->middleware('auth.company');
    }
    public function index() {

    	$round_collections = RoundCollection::where('status', 1)->get();

    	return view('backend.mission_sxtns.index', ['round_collections'	=>	$round_collections]);

    }


   //  public function getList() {

   //  	$mission_sxtns = MissionSxtn::where('company_id', Auth::guard('company')->id())->orderBy('id', 'desc')->get();

   //    $organization_name = Company::select('organizations.name')
   //                                  ->  where('companies.id', Auth::guard('company')->user()->id)
   //                                  ->  join('organizations', 'organizations.id', '=', 'companies.organization_id')
   //                                  ->  first()->name;


   //  	return Datatables::of($mission_sxtns)
   //  	->addColumn('sxtn_name', function($mission) {
   //  		$sxtn_name = '';
   //  		$mission_sxtn_detail = DB::table('mission_sxtn_values')
			// ->join('mission_sxtns', 'mission_sxtn_values.mission_sxtn_id', '=', 'mission_sxtns.id')
			// ->join('mission_sxtn_attribute_values', 'mission_sxtn_attribute_values.id', '=', 'mission_sxtn_values.mission_sxtn_attribute_value_id')
			// ->join('mission_sxtn_attributes', 'mission_sxtn_attributes.id', '=', 'mission_sxtn_attribute_values.mission_sxtn_attribute_id')
			// ->where('mission_sxtn_values.mission_sxtn_id', $mission->id)
			// ->where('mission_sxtn_attributes.column', 'sxtn_name')
			// ->select( 'mission_sxtn_attribute_values.value as value')
			// ->first();
   //          if (isset($mission_sxtn_detail->value) && $mission_sxtn_detail->value != null) {
   //             $sxtn_name = $sxtn_name . $mission_sxtn_detail->value;
   //          }

			// return $sxtn_name;
   //  	})
   //  	->addColumn('created_at', function($mission) {
   //  		return date('d-m-Y',strtotime($mission->created_at));
   //  	})
   //  	->addColumn('status', function($mission)  {
   //  		$str = '';
   //  		if ($mission->status == 0){
   //              $str = $str . '<span class="label label-default">Hồ sơ mới tạo</span>';
   //  		}
   //          elseif ($mission->status == 1){
   //              $str = $str . '<span class="label label-primary">đã nộp bản mềm</span>';
   //          }
   //          elseif ($mission->status == 2){
   //              if ($mission->checked_status == 0){
   //                  $str = $str .'<span class="label label-success">đã nộp bản cứng</span>';
   //              }
   //              elseif ($mission->checked_status == 1){
   //                  $str = $str .'<span class="label label-warning">đã giao cho cán bộ xử lý</span>';
   //              }
   //              elseif ($mission->checked_status == 2){
   //                    if ($mission->process_status == 0){
   //                        $str = $str .'<span class="label label-primary">hồ sơ được duyệt</span>';
   //                    }
   //                    elseif ($mission->process_status == 1) {
   //                        $str = $str .'<span class="label label-warning">đang thực hiện</span>';
   //                    }
   //                    elseif ($mission->process_status == 2){
   //                        $str = $str .'<span class="label label-danger">dừng thực hiện</span>';
   //                    }
   //                    elseif ($mission->process_status == 3){
   //                        $str = $str .'<span class="label label-success">đã hoàn thành</span>';
   //                    }
   //              }
   //              elseif ($mission->checked_status == 3){
   //                  $str = $str .'<span class="label label-danger">hồ sơ không được duyệt</span>';
   //              }
   //        	}

   //        	return $str;
   //  	})
   //    ->addColumn('round_collection', function($mission) {
   //      $round_collection = RoundCollection::find($mission->round_collection_id);
   //      return $round_collection->year . '-' . $round_collection->name;
   //    })
   //  	->addColumn('action', function($mission) {
   //  		$string = '';
   //  		$key = $mission->key;
   //  	        if ($mission->is_filled == 1) {
   //                  $string =  $string ."<a data-tooltip='tooltip' title='Xem chi tiết' href='".route('mission-sxtn.detail', $key)."' class='btn btn-success btn-xs'><i class='fa fa-eye'></i></a>";
   //              }

   //  			$string = $string . "<a data-tooltip='tooltip' title='Chỉnh sửa' href='".route('mission-sxtn.edit', $key)."' class='btn btn-info btn-xs'><i class='fa fa-pencil'></i></a>";


   //        		$string = $string . '<a data-tooltip="tooltip" class="btn btn-danger btn-xs btn-delete-mission" title="Xóa" data-key="'.$key.'"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';

   //        	return $string;
   //  	})
   //  	->addIndexColumn()
   //  	->make(true);
   //  }
   //  
    public function getList() {
      $missions = MissionSxtn::where('company_id',Auth::guard('company')->user()->id)->with(['values','roundCollection'])->orderBy('id', 'desc');

        $organization_name = Company::select('organizations.name')
                                    ->  where('companies.id', Auth::guard('company')->user()->id)
                                    ->  join('organizations', 'organizations.id', '=', 'companies.organization_id')
                                    ->  first()->name;

        return Datatables::eloquent($missions)
              ->addIndexColumn()
              ->addColumn('code', function($mission){
                return $mission->code;
              })
              ->addColumn('values', function($mission) {

                  $attr_id = MissionSxtnAttribute::where('column','sxtn_name')->first()->id;

                  foreach ($mission->values as $key => $value) {
                      if ($value->mission_sxtn_attribute_id == $attr_id) {
                        return $value->value;
                      }
                  }

              })
              ->editColumn('created_at', function($mission) {

                  return date('d/m/Y', strtotime($mission->created_at));
              })
              ->filterColumn('created_at', function ($query, $keyword) {
                  $query->whereRaw("DATE_FORMAT(created_at,'%d-%m-%Y') like ?", ["%$keyword%"]);
              })
              ->editColumn('status', function($mission) {
                  $result = MissionSxtn::getStatusMission($mission);

                  return $result;
              })
              ->editColumn('roundCollection', function($mission) use ($organization_name){
                  $round_collection = RoundCollection::find($mission->round_collection_id);

                  $str = !empty($round_collection) ? $round_collection['name']." - ".$round_collection['year'] : null;
                  return $str;
              })
              ->addColumn('action', function($mission) {
                  $string = '';
                 $key = $mission->key;
                 if ($mission->is_filled == 1) {
                        $string =  $string ."<a data-tooltip='tooltip' title='Xem chi tiết' target='_blank' href='".route('mission-sxtn.detail', $key)."' class='btn btn-success btn-xs'><i class='fa fa-eye'></i></a>";
                    }

                  $string = $string . "<a data-tooltip='tooltip' title='Chỉnh sửa' href='".route('mission-sxtn.edit', $key)."' class='btn btn-info btn-xs'><i class='fa fa-pencil'></i></a>";


                $string = $string . '<a data-tooltip="tooltip" class="btn btn-danger btn-xs btn-delete-mission" title="Xóa" data-key="'.$key.'"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';

               return $string;
              })
              ->make(true);
    }

    public function store(Request $request)
    {
    	$company_id =  Auth::guard('company')->id();
    	$data =  $request->only(['sxtn_name', 'round_collection_id']);

        if (empty($data['sxtn_name']) || empty($data['round_collection_id'])) {

           return Response::json([
               'error'   =>  true,
               'message' =>  'Vui lòng điền đầy đủ thông tin yêu cầu!'
           ]);
        }


    	DB::beginTransaction();
        try {

        	$result = MissionSxtn::create(['company_id' => $company_id, 'round_collection_id' => $data['round_collection_id']]);

	    	// dd($result);
	    	$attributes = MissionSxtnAttribute::get();

    		foreach ($attributes as $attribute) {
    			$val = '';
    			foreach ($data as $key => $value) {
    				if ($key == $attribute->column) {
	    				$val = $value;

	    			}
    			}
    			$value = MissionSxtnAttributeValue::create([
	               'mission_sxtn_attribute_id'  =>  $attribute->id,
	               'value'  =>  $val,
	           	]);

	           	MissionSxtnValue::create([
	               'mission_sxtn_id'  => $result->id,
	               'mission_sxtn_attribute_value_id'  => $value->id,
	            ]);
    		}


	    	$key = $this->addKey(Auth::id() , $result->id);

		    DB::commit();

		    return response()->json([
	           'error' => false,
	           'message' => 'Đăng ký nhiệm vụ thành công',
	           'key' => $key,
	       ]);

        } catch(Exception $e) {
            Log::info('Can not update hard Copy submit: Mission_SXTN_id = ' .$result->id );
            DB::rollack();
            return response()->json([
                'error' => true,
                'message' => 'Internal Server Error:'. $e->getMessage() . 'OK'
            ], 500);
        }

    }

    public function addKey($company_id, $id) {
    	$mission_sxtn = MissionSxtn::find($id);
    	$key = md5($id . $company_id . Carbon::now());
    	$mission_sxtn->key = $key;
    	$mission_sxtn->save();
    	return $key;
    }

    public function edit($key) {

    	$mission_sxtns = MissionSxtn::where('key', $key)->where('company_id', Auth::guard('company')->id())->get();

    	// dd($mission_sxtns->count() <= 0);
    	if (!empty($mission_sxtns) && $mission_sxtns->count() <= 0) {
    		return redirect('/mission-sxtn');
    	}
    	else {
    		$mission_sxtn = $mission_sxtns->first();
    		$mission_sxtn_detail = DB::table('mission_sxtn_values')
			->join('mission_sxtns', 'mission_sxtn_values.mission_sxtn_id', '=', 'mission_sxtns.id')
			->join('mission_sxtn_attribute_values', 'mission_sxtn_attribute_values.id', '=', 'mission_sxtn_values.mission_sxtn_attribute_value_id')
			->join('mission_sxtn_attributes', 'mission_sxtn_attributes.id', '=', 'mission_sxtn_attribute_values.mission_sxtn_attribute_id')
			->where('mission_sxtn_values.mission_sxtn_id', $mission_sxtn->id)
			->select( 'mission_sxtn_attribute_values.value as value', 'mission_sxtn_attributes.column', 'mission_sxtn_attributes.order')
			->get();
    	}

    	$arr = array();
    	foreach ($mission_sxtn_detail as $value) {
    		$arr[$value->column] = $value->value;
        if ($value->column == 'evaluation_form_01') {
          $order_evaluation_form_01 = $value->order;
        }

        if ($value->column == 'evaluation_form_02') {
          $order_evaluation_form_02 = $value->order;
        }
    	}
     //  dd($order_evaluation_form_01);
    	// dd($arr);
      $check_input_01 = $arr['evaluation_form_01'] != null ? true : false;
      $check_input_02 = $arr['evaluation_form_02'] != null ? true : false;

    	return view('backend.mission_sxtns.edit',[
    		'arr'	=>	$arr,
    		'key'	=>	$key,
        'is_filled' =>  $mission_sxtn->is_filled,
        'check_input_02'  =>  $check_input_02,
        'check_input_01'  =>  $check_input_01,
        'order_evaluation_form_01'  =>  $order_evaluation_form_01,
        'order_evaluation_form_02'  =>  $order_evaluation_form_02,

    	]);
    }

    public function update(Request $request) {


    	$datas =  $request->only('sxtn_name','expected_funding' ,'formation', 'urgency_importance', 'target', 'main_content', 'claim_result', 'market_demand', 'expected_organize', 'claim_excecution_time', 'plan_mobilizing_resource');

    	$mission = MissionSxtn::where('key', $request->get('key'))->first();

      // $uploadFile['parent_id'] = $mission->id;

      // $round_collection = RoundCollection::find($mission->round_collection_id);

      // $round_collection_name = $round_collection->year .'_' . $round_collection->name;

      // $uploadFile['round_collection_name']  = str_slug($round_collection_name);

      $datas['evaluation_form_01'] = '';
      $datas['evaluation_form_02'] = '';

      // if ($request->hasFile('evaluation_form_01')) {

      //   $uploadFile['number_input'] = 1;
      //   $uploadFile['file'] = $request->file('evaluation_form_01');
      //   $uploadFile['code_form']  = 'A2';
      //   $path_1 = UploadFile::storeFile($uploadFile);
      //   $datas['evaluation_form_01'] = $path_1;
      // }

      // if ($request->hasFile('evaluation_form_02')) {

      //   $uploadFile['number_input'] = 2;
      //   $uploadFile['file'] = $request->file('evaluation_form_02');
      //   $uploadFile['code_form']  = 'A2';
      //   $path_2 = UploadFile::storeFile($uploadFile);
      //   $datas['evaluation_form_02'] = $path_2;
      // }
      // 
      $datas['evaluation_form_01']  =  UploadFile::getPath('App\Models\MissionSxtnAttribute', $mission->id, 'evaluation_form_01', 'mission_sxtns');

      $datas['evaluation_form_02']  =  UploadFile::getPath('App\Models\MissionSxtnAttribute', $mission->id, 'evaluation_form_02', 'mission_sxtns');

    	$datas['expected_funding'] = Money::format($datas['expected_funding'], 'VNĐ');
    	$datas['expected_funding'] = Crypt::encrypt($datas['expected_funding']);

    	DB::beginTransaction();
        try {

        	$attributes_sxtns = DB::table('mission_sxtn_values')
			->join('mission_sxtns', 'mission_sxtn_values.mission_sxtn_id', '=', 'mission_sxtns.id')
			->join('mission_sxtn_attribute_values', 'mission_sxtn_attribute_values.id', '=', 'mission_sxtn_values.mission_sxtn_attribute_value_id')
			->join('mission_sxtn_attributes', 'mission_sxtn_attributes.id', '=', 'mission_sxtn_attribute_values.mission_sxtn_attribute_id')
			->where('mission_sxtn_values.mission_sxtn_id', $mission->id)
			->select('mission_sxtn_attribute_values.id', 'mission_sxtn_attributes.column')->get();


			foreach ($attributes_sxtns as $key => $attributes_sxtn) {

        // if ($attributes_sxtn->column == "evaluation_form_01") {
        //   $evaluation_form_01 = MissionSxtnAttributeValue::find($attributes_sxtn->id)->value;
        //   if ($evaluation_form_01 != '') {
        //     $datas['evaluation_form_01']  = $evaluation_form_01;
        //   }

        // }

        // if ($attributes_sxtn->column == "evaluation_form_02") {
        //   $evaluation_form_02 = MissionSxtnAttributeValue::find($attributes_sxtn->id)->value;
        //   if ($evaluation_form_02 != '') {
        //     $datas['evaluation_form_02']  = $evaluation_form_02;
        //   }

        // }

				MissionSxtnAttributeValue::find($attributes_sxtn->id)->update(["value" => $datas[$attributes_sxtn->column] ]);
			}

            $mission->update(['is_filled'   =>  1]);

		    DB::commit();

		    return response()->json([
	           'error' => false,
	           'message' => 'Lưu thông tin nhiệm vụ thành công',
	       ]);

        } catch(Exception $e) {
            Log::info('Can not update hard Copy submit: Mission_SXTN_id = ' .$result->id );
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => 'Internal Server Error:'. $e->getMessage() . 'OK'
            ], 500);
        }

    }

    public function detail($key) {
        $mission_sxtns = MissionSxtn::where('key', $key)->where('company_id', Auth::guard('company')->id())->get();
        // dd($mission_sxtns->count() <= 0);
        if (!empty($mission_sxtns) && $mission_sxtns->count() <= 0) {
            return redirect('/mission-sxtn');
        }
        else {
        $mission_sxtn = $mission_sxtns->first();
            $mission_sxtn_detail = DB::table('mission_sxtn_values')
            ->join('mission_sxtns', 'mission_sxtn_values.mission_sxtn_id', '=', 'mission_sxtns.id')
            ->join('mission_sxtn_attribute_values', 'mission_sxtn_attribute_values.id', '=', 'mission_sxtn_values.mission_sxtn_attribute_value_id')
            ->join('mission_sxtn_attributes', 'mission_sxtn_attributes.id', '=', 'mission_sxtn_attribute_values.mission_sxtn_attribute_id')
            ->where('mission_sxtn_values.mission_sxtn_id', $mission_sxtn->id)
            ->select( 'mission_sxtn_attribute_values.value as value', 'mission_sxtn_attributes.column', 'mission_sxtn_attributes.order', 'mission_sxtn_attributes.label')
            ->get();
        }

        $mission_sxtn_detail = $mission_sxtn_detail->toArray();
        // dd($mission_sxtn_detail);
        foreach ($mission_sxtn_detail as $index => $mission_sxtn) {

          if ($mission_sxtn->column == 'evaluation_form_01' || $mission_sxtn->column == 'evaluation_form_02') {
            
            unset($mission_sxtn_detail[$index]);  
          }
          
          
        }

        return view('backend.mission_sxtns.detail', compact('mission_sxtn_detail', 'key'));
    }

    public function print($key) {
        $mission_sxtns = MissionSxtn::where('key', $key)->where('company_id', Auth::guard('company')->id())->get();
        // dd($mission_sxtns->count() <= 0);
        if (!empty($mission_sxtns) && $mission_sxtns->count() <= 0) {
            return redirect('/mission-sxtn');
        }
        else {
        $mission_sxtn = $mission_sxtns->first();
            $mission_sxtn_detail = DB::table('mission_sxtn_values')
            ->join('mission_sxtns', 'mission_sxtn_values.mission_sxtn_id', '=', 'mission_sxtns.id')
            ->join('mission_sxtn_attribute_values', 'mission_sxtn_attribute_values.id', '=', 'mission_sxtn_values.mission_sxtn_attribute_value_id')
            ->join('mission_sxtn_attributes', 'mission_sxtn_attributes.id', '=', 'mission_sxtn_attribute_values.mission_sxtn_attribute_id')
            ->where('mission_sxtn_values.mission_sxtn_id', $mission_sxtn->id)
            ->select( 'mission_sxtn_attribute_values.value as value', 'mission_sxtn_attributes.column', 'mission_sxtn_attributes.order', 'mission_sxtn_attributes.label')
            ->get();
        }

        $mission_sxtn_detail = $mission_sxtn_detail->toArray();
        // dd($mission_sxtn_detail);
        foreach ($mission_sxtn_detail as $index => $mission_sxtn) {

          if ($mission_sxtn->column == 'evaluation_form_01' || $mission_sxtn->column == 'evaluation_form_02') {
            
            unset($mission_sxtn_detail[$index]);  
          }
          
          
        }

        return view('backend.mission_sxtns.print', compact('mission_sxtn_detail'));
    }


    public function destroy(Request $request)
    {
        $key = $request->key;

        DB::beginTransaction();

        try {

          $mission = MissionSxtn::where('key', $key)->first();

          $values = $mission->values;

          foreach ($values as $value) {
              $value->delete();
          }
          $missionValues = MissionSxtnValue::where('mission_sxtn_id', $mission->id)->get();
          foreach ($missionValues as $missionValue) {
              $missionValue->delete();

          }
          // return response()->json(['values'=>$values]);
          $mission->delete();




          DB::commit();

          return response()->json([
              'error' => false,
              'message' => 'Xóa nhiệm vụ thành công !'
          ]);
        } catch (\Exception $e) {
          DB::rollback();

          Log::info($e->getMessage());

          return response()->json([
              'error' => true,
              'message' => $e->getMessage()
          ]);
        }

    }

    public function viewFile(Request $request){
      $key = $request->key;
      $link = $request->link;
      $order = $request->order;
      $model_name = "App\Models\MissionSxtn";

      $mission = $model_name::where('key', $key)
                  ->where('company_id', Auth::guard('company')->user()->id)
                  ->first();

      $data = array();

      foreach ($mission->values as $key => $value) {
        if ($value->mission_sxtn_attribute_id == $order) {
          $link_sql = $value->value;
        }
      }

      $check  = strcmp($link, $link_sql);

      if ($check==0) {

        $link = "storage/".$link;
        $link = asset($link);

        

        return response()->json([
          'error' =>  false,
          'link'  =>  $link,
        ]);
        # code...
      }
     
    }

    public function uploadFile(Request $request) {

     
      if ($request->hasFile('file')) {

        $data['file'] = $request->file('file');
        $data['code_form']  = 'A2';
        $data['table']  = 'App\Models\MissionSxtn';
        $data['table_attribute']  = 'App\Models\MissionSxtnAttribute';
        $data['key']  = $request->get('key');
        $data['order']  = $request->get('order');
        $data['table_name'] = 'mission_sxtns';

        return UploadFile::upFile($data);
    }

  }

}