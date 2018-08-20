<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MissionSxtn;
use App\Models\MissionSxtnValue;
use App\Models\MissionSxtnAttribute;
use App\Models\MissionSxtnAttributeValue;
use App\Models\RoundCollection;
use App\Models\Organization;
use App\Models\Profile;
use Auth;
use DB;
use Datatables;

class AdminMissionSxtnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $round_collections = RoundCollection::where('status', 1)->get();

        return view('backend.admin_mission_sxtn.index', ['round_collections' =>  $round_collections]);

    }

    public function list() {
      $missions = MissionSxtn::orderBy('id','desc')->with(['values','roundCollection','profile']);
      // dd($mission);
        // $organization_name = Profile::select('organizations.name')
        //                             ->  where('companies.id', Auth::guard('profile')->user()->id)
        //                             ->  join('organizations', 'organizations.id', '=', 'companies.organization_id')
        //                             ->  first()->name;

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
              ->editColumn('roundCollection', function($mission){
                  $round_collection = RoundCollection::find($mission->round_collection_id);

                  $str = !empty($round_collection) ? $round_collection['name']." - ".$round_collection['year'] : null;
                  return $str;
              })

                ->editColumn('profile', function($mission) {

                  if (!empty($mission->profile)) {
                    return $mission->profile->organization->name;
                  } else {
                    return "Chưa cập nhật";
                  }
                })

              ->addColumn('action', function($mission) {
                  $string = '';
                 $key = $mission->key;
                 if ($mission->is_filled == 1) {
                        $string =  $string ."<a data-tooltip='tooltip' title='Xem chi tiết' target='_blank' href='".route('admin-mission-sxtns.detail', $key)."' class='btn btn-success btn-xs'><i class='fa fa-eye'></i></a>";
                    }


                  $string = $string . "<a data-tooltip='tooltip' title='Chỉnh sửa' href='".route('admin-mission-sxtns.edit', $key)."' class='btn btn-info btn-xs'><i class='fa fa-pencil'></i></a>";


                $string = $string . '<a data-tooltip="tooltip" class="btn btn-danger btn-xs btn-delete-mission" title="Xóa" data-key="'.$key.'"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';

               return $string;
              })
              ->make(true);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($key)
    {
      // dd($key);

        $mission_sxtns = MissionSxtn::where('key', $key)->get();

      // dd($mission_sxtns->count() <= 0);
      if (!empty($mission_sxtns) && $mission_sxtns->count() <= 0) {
        return redirect('/admin/mission-sxtns');
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

      return view('backend.admin_mission_sxtn.edit',[
        'arr' =>  $arr,
        'key' =>  $key,
        'is_filled' =>  $mission_sxtn->is_filled,
        'check_input_02'  =>  $check_input_02,
        'check_input_01'  =>  $check_input_01,
        'order_evaluation_form_01'  =>  $order_evaluation_form_01,
        'order_evaluation_form_02'  =>  $order_evaluation_form_02,

      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $datas =  $request->only('sxtn_name','expected_funding' ,'formation', 'urgency_importance', 'target', 'main_content', 'claim_result', 'market_demand', 'expected_organize', 'claim_excecution_time', 'plan_mobilizing_resource');

      $mission = MissionSxtn::where('key', $request->get('key'))->first();

      $datas['evaluation_form_01'] = '';
      $datas['evaluation_form_02'] = '';

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

        MissionSxtnAttributeValue::find($attributes_sxtn->id)->update(["value" => $datas[$attributes_sxtn->column] ]);
      }

            // $mission->update(['is_filled'   =>  1]);

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

    public function detail($key) {
      // dd($key);
        $mission_sxtns = MissionSxtn::where('key', $key)->get();
        // dd($mission_sxtns->count() <= 0);
        // dd($mission_sxtns);
        if (!empty($mission_sxtns) && $mission_sxtns->count() <= 0) {

            return redirect('/admin/mission-sxtns');
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

        return view('backend.admin_mission_sxtn.detail', compact('mission_sxtn_detail', 'key'));
    }

    public function delete(Request $request)
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
}
