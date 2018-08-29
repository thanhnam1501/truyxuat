<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MissionScienceTechnology;
use App\Models\MissionScienceTechnologyAttribute;
use App\Models\MissionScienceTechnologyAttributeValue;
use App\Models\MissionScienceTechnologyValue;
use App\Models\Profile;
use App\Models\Organization;
use App\Models\RoundCollection;
use App\Models\MissionScienceTechnologyFile;
use App\Models\CouncilMissionScienceTechnology;
use App\Models\ApplyLog;

use Money;
use Auth;
use Entrust;
use DB;
use Carbon\Carbon;
use Datatables;
use Validator;
use Crypt;
use Log;
use UploadFile;
use Illuminate\Support\Facades\Storage;
use File;
use PDF;

class MissionScienceTechnologyController extends Controller
{
    public function __construct() {
        $this->middleware('auth.profile');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = RoundCollection::where('status',1)->get();

        return view('backend.mission_science_technology.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $data = $request->only('round_collection_id');

        if (empty($data['round_collection_id'])) {
            return response()->json([
                'error'   =>  true,
                'message' =>  'Vui lòng điền đầy đủ thông tin yêu cầu!'
            ]);
        }

        DB::beginTransaction();
        try {

            $topic = MissionScienceTechnology::create([
                        'profile_id'            => Auth::guard('profile')->user()->id,
                        'round_collection_id'   => $data['round_collection_id'],
                    ]);

            $topic->update([
                'key' => md5($topic->id.$topic->profile_id.Carbon::now()),
            ]);

            unset($data['round_collection_id']);

            $columns = MissionScienceTechnologyAttribute::all();

            foreach ($columns as $key => $value) {

              $result = null;

              $attrivuteValue = MissionScienceTechnologyAttributeValue::create([
                'mission_science_technology_attribute_id' =>  $value->id,
                'value'                                   =>  $result,
              ]);

              MissionScienceTechnologyValue::create([
                  'mission_science_technology_id'  => $topic->id,
                  'mission_science_technology_attribute_value_id'  => $attrivuteValue->id,
              ]);
            }

            DB::commit();

            return response()->json([
                'error'   => false,
                'message' => 'Đăng ký nhiệm vụ thành công !',
                'key'     => $topic->key,
            ]);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage(),
            ]);
        }
   }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($key)
    {   $st_key = $key;
        $mission = MissionScienceTechnology::where('key', $key)->first();

        $columns = MissionScienceTechnologyAttribute::all();

        $data = array();

        foreach ($columns as $key => $column) {
          foreach ($mission->values as $value) {
            if ($value->mission_science_technology_attribute_id == $column->id) {
              if ($column->column == 'expected_fund') {
                // if (!empty($value->value)) {
                    $value->value = (!empty($value->value))? number_format(Crypt::decrypt($value->value))." VNĐ" :"0 VNĐ";
                // }

              }
              $data[$key]['order']  = $column->order;
              $data[$key]['value']  = $value->value;
              $data[$key]['label']  = $column->label;
              $data[$key]['column'] = $column->column;
              $data[$key]['parent_attribute_id'] = $column->parent_attribute_id;
            }
          }
        }

        $date = array();

        $date['d'] = date('d',strtotime(now()));
        $date['m'] = date('m',strtotime(now()));
        $date['y'] = date('Y',strtotime(now()));

        $is_filled = $mission->is_filled == 1 ? true : false;

        $is_submit_ele_copy = $mission->is_submit_ele_copy;
        $is_submit_hard_copy = $mission->is_submit_hard_copy;

        return view('backend.mission_science_technology.detail', compact('is_submit_hard_copy', 'is_submit_ele_copy', 'data', 'key', 'st_key','date', 'is_filled'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($key)
    {
 
      $st_key = $key;

        $result = MissionScienceTechnology::where('key', $key)->first();

        $id = $result->id;
        $is_filled = $result->is_filled;

        $stechs = MissionScienceTechnology::select([
                    'mission_science_technology_attributes.column',
                    'mission_science_technology_attribute_values.value'
                  ])
                  ->  where('mission_science_technologies.key', $key)
                  ->  where('mission_science_technologies.profile_id',Auth::guard('profile')->user()->id)
                  ->  join('mission_science_technology_values', 'mission_science_technology_values.mission_science_technology_id', '=', 'mission_science_technologies.id')
                  ->  join('mission_science_technology_attribute_values', 'mission_science_technology_attribute_values.id', '=', 'mission_science_technology_values.mission_science_technology_attribute_value_id')
                  ->  join('mission_science_technology_attributes', 'mission_science_technology_attributes.id', 'mission_science_technology_attribute_values.mission_science_technology_attribute_id')
                  ->  get();

        $columns = MissionScienceTechnologyAttribute::all();

        $data = array();

        foreach ($columns as $key => $value) {
          $data[$value->column] = null;
        }

        foreach ($stechs as $value) {
          foreach ($columns as $key => $column) {
            if ($value->column == $column->column && !empty($value->value)) {
              $data[$column->column] = $value->value;
            }
          }
        }

        if (!empty($data['expected_fund'])) {
          $data['expected_fund'] = Crypt::decrypt($data['expected_fund']);
        }

        $check_input_01 = $data['evaluation_form_01'] != null ? true : false;
        $check_input_02 = $data['evaluation_form_02'] != null ? true : false;
        $order_evaluation_form_01 = 15;
        $order_evaluation_form_02 = 16;

        $status_submit_ele_copy = $result->is_submit_ele_copy == 1 ? "<p>Hồ sơ đã nộp bản mềm</p>Thời gian nộp: ".date('d-m-Y', strtotime($result->time_submit_ele_copy)) : "<p class='text-red'>Hồ sơ chưa nộp bản mềm</p>";
        $status_submit_hard_copy = $result->is_submit_hard_copy == 1 ? "<p>Hồ sơ đã nộp bản cứng</p>Thời gian nộp: ".date('d-m-Y', strtotime($result->time_submit_hard_copy)) : "<p class='text-red'>Hồ sơ chưa nộp bản cứng</p>";

        $is_submit_ele_copy = $result->is_submit_ele_copy;
        $is_submit_hard_copy = $result->is_submit_hard_copy;

        $doc_status = "";

        if ($result->is_assign) {
            $doc_status = "<p>Hồ sơ đã được giao cho cán bộ xử lý</p>";
        }

        if ($result->is_valid) {
            
            $doc_status = "<p>Hồ sơ hợp lệ</p>";
        } else if ($result->is_invalid) {

            $doc_status = "<p class'error'>Hồ sơ không hợp lệ</p>";
        }

        if (CouncilMissionScienceTechnology::where('mission_id', $result->id)->count() > 0) {
            
            $doc_status = "<p>Hồ sơ đã được giao cho hội đồng đánh giá</p>";
        }

        //
        $mission = MissionScienceTechnology::where('key', $st_key)->first();

        $columns = MissionScienceTechnologyAttribute::all();

        $arr = array();

        foreach ($columns as $key => $column) {
          foreach ($mission->values as $value) {
            if ($value->mission_science_technology_attribute_id == $column->id) {
              if ($column->column == 'expected_fund') {
                // if (!empty($value->value)) {
                    $value->value = (!empty($value->value))? number_format(Crypt::decrypt($value->value))." VNĐ" :"0 VNĐ";
                // }

              }
              $arr[$key]['order']  = $column->order;
              $arr[$key]['value']  = $value->value;
              $arr[$key]['label']  = $column->label;
              $arr[$key]['column'] = $column->column;
              $arr[$key]['parent_attribute_id'] = $column->parent_attribute_id;
            }
          }
        }

        $date = array();

        $date['d'] = date('d',strtotime(now()));
        $date['m'] = date('m',strtotime(now()));
        $date['y'] = date('Y',strtotime(now()));

        if (!empty($data)) {
          return view("backend.mission_science_technology.edit", compact('arr','data', 'st_key', 'id', 'is_filled', 'check_input_01', 'check_input_02', 'order_evaluation_form_01', 'order_evaluation_form_02', 'status_submit_ele_copy', 'status_submit_hard_copy','is_submit_ele_copy', 'is_submit_hard_copy', 'date', 'doc_status'));
        }
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
        DB::beginTransaction();

        try {
            $data = $request->all();
            $fund = Money::format($data['expected_fund'], 'VNĐ');
            $data['expected_fund'] = Crypt::encrypt($fund);

            $data['evaluation_form_01'] = '';
            $data['evaluation_form_02'] = '';

            $mission = MissionScienceTechnology::where('key', $request->get('key'))->first();

            $data['evaluation_form_01']  =  UploadFile::getPath('App\Models\MissionScienceTechnologyAttribute', $mission->id, 'evaluation_form_01', 'mission_science_technologies');
            $data['evaluation_form_02']  =  UploadFile::getPath('App\Models\MissionScienceTechnologyAttribute', $mission->id, 'evaluation_form_02', 'mission_science_technologies');

            // if (empty($data['evaluation_form_01']) || empty($data['evaluation_form_02'])) {
            //     return response()->json([
            //       'error' => true,
            //       'message' => 'Vui lòng đính kèm file!'
            //     ]);
            // }

            $stechs = MissionScienceTechnology::find($data['id']);
            $columns = MissionScienceTechnologyAttribute::all();

            $ids = [12];
            $files = [15, 16];

            $arr = array();

            foreach ($stechs->values as $key => $row) {
              foreach ($columns as $key => $column) {
                if ($column->id == $row->mission_science_technology_attribute_id) {
                  if (!in_array($row->mission_science_technology_attribute_id, $ids)) {
                    $record = MissionScienceTechnologyAttributeValue::find($row->id)
                                ->update(['value' => $data[$column->column]]);
                  }

                 // if ($row->mission_science_technology_attribute_id == 15) {
                 //    $file_01 = $row->id;
                 //  }
                 //
                 //  if ($row->mission_science_technology_attribute_id == 16) {
                 //    $file_02 = $row->id;
                 //  }
                }
              }
            }

            $stechs->update([
                'is_filled'  => 1,
            ]);

            // upload file
            // $round_collection = RoundCollection::find($stechs->round_collection_id);
            // $round_collection_name = $round_collection->year .'_' . $round_collection->name;
            // $uploadFile['round_collection_name']  = str_slug($round_collection_name);
            //
            // if ($request->hasFile('evaluation_form_01')) {
            //   $uploadFile['number_input'] = 1;
            //   $uploadFile['file'] = $request->file('evaluation_form_01');
            //   $uploadFile['code_form']  = 'A3';
            //   $uploadFile['parent_id']  = $stechs->id;
            //   $path = UploadFile::storeFile($uploadFile);
            //   MissionScienceTechnologyAttributeValue::find($file_01)
            //   ->update(['value' => $path]);
            // }
            //
            // if ($request->hasFile('evaluation_form_02')) {
            //   $uploadFile['number_input'] = 2;
            //   $uploadFile['file'] = $request->file('evaluation_form_02');
            //   $uploadFile['code_form']  = 'A3';
            //   $uploadFile['parent_id']  = $stechs->id;
            //   $path = UploadFile::storeFile($uploadFile);
            //   MissionScienceTechnologyAttributeValue::find($file_02)
            //   ->update(['value' => $path]);
            // }
            // end

            DB::commit();
            return response()->json([
                'error'   => false,
                'message' => 'Lưu thông tin nhiệm vụ thành công !',
            ]);

        } catch (Exception $e) {

            DB::rollback();
            Log::info($e->getMessage());
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $key = $request->key;

        DB::beginTransaction();

        try {
          $mission = MissionScienceTechnology::where('key', $key)->first();

          foreach ($mission->values as $key => $value) {
            $value->delete();
          }

          MissionScienceTechnologyValue::where('mission_science_technology_id', $mission->id)->delete();

          $mission->delete();
          $mission->save();

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

    public function getList(Request $request) {
        $missions = MissionScienceTechnology::where('profile_id',Auth::guard('profile')->user()->id)->with(['values','roundCollection'])->orderBy('id', 'desc');

        // $organization_name = Profile::select('organizations.name')
        //                             ->  where('profiles.id', Auth::guard('profile')->user()->id)
        //                             ->  join('organizations', 'organizations.id', '=', 'profiles.organization_id')
        //                             ->  first()->name;

        return Datatables::eloquent($missions)
              ->addIndexColumn()
              ->editColumn('code', function($mission){
                return $mission->code;
              })
              ->addColumn('values', function($mission) {

                  $str = "";
                  $attr_id = MissionScienceTechnologyAttribute::where('column','name')->first()->id;

                  foreach ($mission->values as $key => $value) {
                      if ($value->mission_science_technology_attribute_id == $attr_id) {

                        if (strlen($value->value) >= 300) {
                          return ("<span data-container='body' data-tooltip='tooltip' title='".$value->value."'>".mb_substr($value->value, 0, 300)."..."."</span>");

                        } else {
                          return ("<span>".$value->value."</span>");
                        }
                      }
                  }
              })
              ->editColumn('type', function($mission){
                  return "Dự án KH&CN";
              })
              ->editColumn('created_at', function($mission) {

                  return date('d/m/Y', strtotime($mission->created_at));
              })

              ->editColumn('status', function($mission) {
                  $result = MissionScienceTechnology::getStatusMission($mission);

                  return $result;
              })
              ->editColumn('roundCollection', function($mission){
                  $round_collection = RoundCollection::find($mission->round_collection_id);

                  $str = !empty($round_collection) ? $round_collection['name']." - ".$round_collection['year'] : null;
                  return $str;
              })
              ->addColumn('action', function($mission) {
                  $str = ""; $string = "";

                  if ($mission->is_filled == 1) {
                    $string .=  "<a data-tooltip='tooltip' title='Xem chi tiết' href='".route('missionScienceTechnology.show',$mission->key)."' class='btn btn-success btn-xs'><i class='fa fa-eye'></i></a>";
                  }

                  $string .=  "<a data-tooltip='tooltip' title='Chỉnh sửa' href='".route('missionScienceTechnology.edit',$mission->key)."' class='btn btn-info btn-xs'><i class='fa fa-pencil'></i></a>";

                  $string .= '<a data-tooltip="tooltip" class="btn btn-danger btn-xs btn-Call btn-delete-mission" title="Xóa" data-id="" data-key="'.$mission->key.'"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';

                  return $string;
              })
              ->make(true);
    }

    public function print($key){
      $mission = MissionScienceTechnology::where('key', $key)->first();

      $columns = MissionScienceTechnologyAttribute::all();

      $data = array();

      foreach ($columns as $key => $column) {
        foreach ($mission->values as $value) {
          if ($value->mission_science_technology_attribute_id == $column->id) {
            if ($column->column == 'expected_fund') {
              $value->value = (!empty($value->value))? number_format(Crypt::decrypt($value->value))." VNĐ" :"0 VNĐ";
            }
            $data[$column->column]  = $value->value;
          }
        }
      }

      $date = array();

      $date['d'] = date('d',strtotime(now()));
      $date['m'] = date('m',strtotime(now()));
      $date['y'] = date('Y',strtotime(now()));

      return view('backend.mission_science_technology.print', compact('data', 'key','date'));
    }

    public function viewFile(Request $request){
      $key = $request->key;
      $link = $request->link;
      $order = $request->order;
      $model_name = "App\Models\MissionScienceTechnology";

      $mission = $model_name::where('key', $key)
                  ->where('profile_id', Auth::guard('profile')->user()->id)
                  ->first();

      $data = array();

      foreach ($mission->values as $key => $value) {
        if ($value->mission_science_technology_attribute_id == $order) {
          $link_sql = $value->value;
        }
      }

      $check  = strcmp($link, $link_sql);
      $link_final = null ;

      if ($check == 0) {
        $link = "storage/".$link;
        $link_final = asset($link);
        $error = false;
      } else {
        $error = true;
      }

      return response()->json([
        'error' =>  $error,
        'link'  =>  $link_final
      ]);
    }

    public function uploadFile(Request $request) {


      if ($request->hasFile('file')) {

        $data['file'] = $request->file('file');
        $data['code_form']  = 'A3';
        $data['table']  = 'App\Models\MissionScienceTechnology';
        $data['table_attribute']  = 'App\Models\MissionScienceTechnologyAttribute';
        $data['key']  = $request->get('key');
        $data['order']  = $request->get('order');
        $data['table_name'] = 'mission_science_technologies';

        return UploadFile::upFile($data);
    }
  }

  public function submitEleCopy(Request $request){
    DB::beginTransaction();
    try {

      $key = $request->key;
      $is_submit_ele_copy = $request->is_submit_ele_copy;
      $mission = MissionScienceTechnology::where('key', $key)->whereNull('deleted_at')->first();

      if ($mission->is_submit_hard_copy == 1) {
          return response()->json([
            'error' => true,
            'msg' => 'Hồ sơ đã nộp bản cứng, không được sửa.',
            'reload'  =>  true
          ]);
      }
      // 
      $check_is_filled = $mission->is_filled == 1 ? true : false;
      $check_is_submit_ele_copy = $mission->is_submit_ele_copy == 1 ? true : false;

      if ($check_is_filled == false) {
        return response()->json([
          'error' =>  true,
          'msg'   =>  'Not Filled'
        ]);
      }

      $checkBeforeSubmitEle = Self::checkBeforeSubmitEle($mission->id);

      if ($checkBeforeSubmitEle['error']) {
          return response()->json([
            'error' => true,
            'collectName' => $checkBeforeSubmitEle['collectName'],
            'modal'  => true,
          ]);
      }

      // $evaluation_form_01  =  UploadFile::getPath('App\Models\MissionScienceTechnologyAttribute', $mission->id, 'evaluation_form_01', 'mission_science_technologies');

      // $evaluation_form_02  =  UploadFile::getPath('App\Models\MissionScienceTechnologyAttribute', $mission->id, 'evaluation_form_02', 'mission_science_technologies');

      // if (empty($evaluation_form_01) || empty($evaluation_form_02)) {
      //     return response()->json([
      //       'error' => true,
      //       'message' => 'Vui lòng đính kèm file!'
      //     ]);
      // }

      $old_data = $mission;

      $mission->update([
        'is_submit_ele_copy'  =>  $is_submit_ele_copy,
        'time_submit_ele_copy'  =>  now()
      ]);

      $mission->save();

      if ($is_submit_ele_copy) {
          $content = "Nộp hồ sơ bản mềm";
      } else {
          $content = "Mở lại hồ sơ bản mềm";
      }

      //* Create logs *//
      $arr = [
          'profile_id' => Auth::guard('profile')->user()->id,
          'content'    => $content,
          'old_data'   => json_encode($old_data),
          'new_data'   => json_encode($mission),
          'table_name' => 'mission_science_technologies',
          'record_id'  => $mission->id
        ];

      ApplyLog::createLog($arr);

      DB::commit();

      return response()->json([
        'error'   =>  false,
        'msg'     =>  $content. " thành công !"
      ]);

    } catch (\Exception $e) {
      return response()->json([
        'error' =>  true,
        'msg'   =>  $e->getMessage()
      ]);
    }

  }

  public function checkBeforeSubmitEle($id)
  { 
    $topic = MissionScienceTechnology::find($id);

    $collectName = collect();

    $error = false;

    if (!empty($topic)) {
        
      foreach ($topic->values as $value) {
          
        if (empty($value->value)) {
          
          if ($value->mission_science_technology_attribute_id == 15 || $value->mission_science_technology_attribute_id == 16 || $value->mission_science_technology_attribute_id == 12) {
            continue;
          }

          $column = MissionScienceTechnologyAttribute::find($value->mission_science_technology_attribute_id)->label;

          $collectName->push($column);

          $error = true;
        }
      }
    }

    return [
      'error' => $error,
      'collectName' => $collectName,
    ];
  }
}
