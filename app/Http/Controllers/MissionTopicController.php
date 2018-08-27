<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MissionTopic;
use App\Models\MissionTopicValue;
use App\Models\MissionTopicAttributeValue;
use App\Models\MissionTopicAttribute;
use App\Models\MissionScienceTechnology;
use App\Models\RoundCollection;
use App\Models\ApplyLog;
use Money;
use Auth;
use Entrust;
use DB;
use Carbon\Carbon;
use Datatables;
use Validator;
use Crypt;
use UploadFile;

class MissionTopicController extends Controller
{
  public function __construct()
  {

    $this->middleware('auth.profile');
  }

  public function index()
  {
    $datas = RoundCollection::where('status',1)->get();
    return view('backend.mission_topic.index',[
      'datas' => $datas,
    ]);
  }

  public function getList(Request $request)
  {
    $topics = MissionTopic::orderBy('id','desc')->where('profile_id',Auth::guard('profile')->user()->id)->with(['values','roundCollection']);

    return Datatables::eloquent($topics)
    ->addIndexColumn()
    ->editColumn('values', function(MissionTopic $topic) {

      $attr_id = MissionTopicAttribute::where('column','name')->first()->id;

      foreach ($topic->values as $value) {

        if ($value->mission_topic_attribute_id == $attr_id) {
          if (strlen($value->value) >= 300) {
            return ("<span data-container='body' data-tooltip='tooltip' title='".$value->value."'>".substr($value->value, 0, 300)."..."."</span>");
          } else {
            return ("<span>".$value->value."</span>");
          }
        }
      }
    })
    ->editColumn('created_at', function(MissionTopic $topic) {

      return date('d/m/Y', strtotime($topic->created_at));
    })
    ->editColumn('type', function(MissionTopic $topic) {

      if ($topic->type == 0) {
        return "Đề tài";
      } else {
        return "Đề án";
      }
    })

    ->editColumn('status', function(MissionTopic $topic) {

        $result = MissionScienceTechnology::getStatusMission($topic);

        return $result;
    })
    ->editColumn('roundCollection', function(MissionTopic $topic) {

      if (!empty($topic->roundCollection)) {
        return $topic->roundCollection->name." - ".$topic->roundCollection->year;
      } else {
        return "Chưa cập nhập";
      }
    })
    ->addColumn('action', function(MissionTopic $topic) {

      $string = "";

      if ($topic->status > 0) {

        $string .= "<a data-tooltip='tooltip' title='Chỉnh sửa' href='".route('missionTopic.edit',$topic->key)."' class='btn btn-info  btn-xs'><i class='fa fa-pencil'></i></a>";

      } else {

        $string .= "<a data-tooltip='tooltip' title='Chỉnh sửa' href='".route('missionTopic.edit',$topic->key)."' class='btn btn-info btn-xs'><i class='fa fa-pencil'></i></a><a data-tooltip='tooltip' title='Xóa' data-id='".$topic->id."' href='javascript:;' class='btn btn-danger btn-xs delete-btn'><i class='fa fa-trash-o'></i></a>";

      }

      if ($topic->is_filled == 1) {

        $string = "<a data-tooltip='tooltip' title='Xem chi tiết' href='".route('missionTopic.detail',$topic->key)."' class='btn btn-success  btn-xs'><i class='fa fa-eye'></i></a>".$string;
      }

      return $string;
    })
    ->make(true);
  }

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

      $topic = MissionTopic::create([
        'profile_id'  => Auth::guard('profile')->user()->id,
        'round_collection_id'  => $data['round_collection_id'],
      ]);

      $topic->update([
        'key' => md5($topic->id.$topic->profile_id.Carbon::now()),
      ]);

      unset($data['round_collection_id']);

      $notIn = "";

      foreach ($data as $key => $value) {

        $attribute_id = MissionTopicAttribute::where('column',$key)->first()->id;

        $notIn .= ",'$attribute_id'";

        $attrivuteValue = MissionTopicAttributeValue::create([
          'mission_topic_attribute_id'  =>  $attribute_id,
          'value'  =>  $value,
        ]);

        MissionTopicValue::create([
          'mission_topic_id'  => $topic->id,
          'mission_topic_attribute_value_id'  => $attrivuteValue->id,
        ]);
      }

      $attributeArr = MissionTopicAttribute::whereNotIn('id',[trim($notIn,',')])->get();

      foreach ($attributeArr as $key => $value) {

        $attrivuteValue = MissionTopicAttributeValue::create([
          'mission_topic_attribute_id'  =>  $value->id,
          'value'  =>  null,
        ]);

        MissionTopicValue::create([
          'mission_topic_id'  => $topic->id,
          'mission_topic_attribute_value_id'  => $attrivuteValue->id,
        ]);

      }

      DB::commit();

      return response()->json([
        'error' => false,
        'message' => 'Đăng ký nhiệm vụ thành công!',
        'key' => $topic->key,
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

  public function edit($key)
  {
    $topic = MissionTopic::where('key',$key)->where('profile_id',Auth::guard('profile')->user()->id)->first();

    if (empty($topic) || $topic->count() < 0) {

      abort(404);
    }

    $columns = MissionTopicAttribute::all();

    $data = array();

    if (!$topic->is_submit_ele_copy) {
      foreach ($topic->values as $value) {
        foreach ($columns as $column) {
          if ($value->mission_topic_attribute_id == $column->id && !empty($value->value)) {
            $data[$column->column] = $value->value;
          }
        }
      }
      
      $data['expected_fund'] = (!empty($data['expected_fund']))?Crypt::decrypt($data['expected_fund']):"0";
    } else {
      foreach ($columns as $key => $column) {
        foreach ($topic->values as $value) {
          if ($value->mission_topic_attribute_id == $column->id) {
            if ($column->column == "expected_fund") {
              $value->value = number_format(Crypt::decrypt($value->value)) . " (VNĐ)";
            }
            $data[$key]["order"]  = $column->order;
            $data[$key]["value"]  = $value->value;
            $data[$key]["label"]  = $column->label;
            $data[$key]["column"] = $column->column;
          }
        }
      }
    }

    
    if (!empty($topic)) {

      $status_submit_ele_copy = $topic->is_submit_ele_copy == 1 ? "<p>Hồ sơ đã nộp bản mềm</p>Thời gian nộp: ".date('d-m-Y', strtotime($topic->time_submit_ele_copy)) : "<p class='text-red'>Hồ sơ chưa nộp bản mềm</p>";
      $status_submit_hard_copy = $topic->is_submit_hard_copy == 1 ? "<p>Hồ sơ đã nộp bản cứng</p>" : "<p class='text-red'>Hồ sơ chưa nộp bản cứng</p>";

      $is_submit_ele_copy = $topic->is_submit_ele_copy;
      $is_submit_hard_copy = $topic->is_submit_hard_copy;

      $date = array();

      $date['d'] = date('d',time());
      $date['m'] = date('m',time());
      $date['y'] = date('Y',time());

      return view('backend.mission_topic.edit',[
        'topic' => $topic,
        'data' => $data,
        'status_submit_ele_copy'  =>  $status_submit_ele_copy,
        'status_submit_hard_copy' =>  $status_submit_hard_copy,
        'is_submit_ele_copy'  =>  $is_submit_ele_copy,
        'is_submit_hard_copy' =>  $is_submit_hard_copy,
        'date'  => $date,
      ]);
    }
  }

  public function update(Request $request) {

    $data = $request->only('expected_fund','expected_main_content','expected_result_perform','id','key','name','propose_base','result_target_requirement','target','time_result_requirement','type','urgency');

    $fund = Money::format($data['expected_fund'], 'VNĐ');

    $data['expected_fund'] = Crypt::encrypt($fund);

    // $data['evaluation_form_01'] = '';
    // $data['evaluation_form_02'] = '';

    DB::beginTransaction();
    try {

      $topic = MissionTopic::find($data['id']);

      // $data['evaluation_form_01']  =  UploadFile::getPath('App\Models\MissionTopicAttribute', $topic->id, 'evaluation_form_01', 'mission_topics');

      // $data['evaluation_form_02']  =  UploadFile::getPath('App\Models\MissionTopicAttribute', $topic->id, 'evaluation_form_02', 'mission_topics');

      // if (empty($data['evaluation_form_01']) || empty($data['evaluation_form_02'])) {
      //     return response()->json([
      //       'error' => true,
      //       'message' => 'Vui lòng đính kèm file!'
      //     ]);
      // }

      foreach ($topic->values as $key => $value) {

        $column = MissionTopicAttribute::where('id',$value->mission_topic_attribute_id)
                                    ->first()
                                    ->column;
        if ($column == "evaluation_form_02" || $column == "evaluation_form_01") {
          continue;
        }

        $value->value = $data[$column];

        $value->save();
      }

      $topic->update([
        'is_filled'  => 1,
        'type'  => $data['type'],
      ]);

      DB::commit();

      return response()->json([
        'error' => false,
        'message' => 'Lưu thông tin nhiệm vụ thành công!',
        'key' => $topic->key,
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

  public function detail($key, $print = null)
  {

    $topic = MissionTopic::where('key',$key)->where('profile_id',Auth::guard('profile')->user()->id)->first();

    if (!empty($topic)) {

      $columns = MissionTopicAttribute::all();

      $data = array();
      foreach ($columns as $key => $column) {
        foreach ($topic->values as $value) {
          if ($value->mission_topic_attribute_id == $column->id) {
            if ($column->column == "expected_fund") {
              $value->value = number_format(Crypt::decrypt($value->value)) . " (VNĐ)";
            }
            $data[$key]["order"]  = $column->order;
            $data[$key]["value"]  = $value->value;
            $data[$key]["label"]  = $column->label;
            $data[$key]["column"] = $column->column;
          }
        }
      }

      if ($print != null && $print == "print") {
        $view = "print";
      } else {
        $view = "detail";
      }

      $date = array();

      $date['d'] = date('d',time());
      $date['m'] = date('m',time());
      $date['y'] = date('Y',time());

      return view('backend.mission_topic.'.$view,[
        'data'  => $data,
        'topic'  => $topic,
        'date'  => $date,
      ]);

    } else {

      abort(404);
    }
  }

  public function destroy($id)
  {
    $topic = $topic = MissionTopic::where('id',$id)->where('profile_id',Auth::guard('profile')->user()->id)->first();

    if (!empty($topic)) {

      DB::beginTransaction();
      try {

        $topic->delete();

        DB::commit();

        return response()->json([
          'error' => false,
          'message' => "Xóa nhiệm vụ thành công!",
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
  }

  public function viewFile(Request $request){
      $key = $request->key;
      $link = $request->link;
      $order = $request->order;
      $model_name = "App\Models\MissionTopic";

      $mission = $model_name::where('key', $key)
                  ->where('profile_id', Auth::guard('profile')->user()->id)
                  ->first();

      $data = array();

      foreach ($mission->values as $key => $value) {
        if ($value->mission_topic_attribute_id == $order) {
          $link_sql = $value->value;
        }
      }

      $check  = strcmp($link, $link_sql);

      if ($check == 0) {
        $link = "storage/".$link;
        $link = asset($link);
      }

      return response()->json([
        'error' =>  false,
        'link'  =>  $link
      ]);
  }

    public function uploadFile(Request $request) {

      if ($request->hasFile('file')) {

        $data['file'] = $request->file('file');
        $data['code_form']  = 'A1';
        $data['table']  = 'App\Models\MissionTopic';
        $data['table_attribute']  = 'App\Models\MissionTopicAttribute';
        $data['key']  = $request->get('key');
        $data['order']  = $request->get('order');
        $data['table_name'] = 'mission_topics';

        return UploadFile::upFile($data);
      }
    }

    public function submitEleCopy(Request $request){
      DB::beginTransaction();
      try {

        $key = $request->key;
        $is_submit_ele_copy = $request->is_submit_ele_copy;
        $mission = MissionTopic::where('key', $key)->whereNull('deleted_at')->first();

        if ($mission->is_submit_hard_copy) {
            return response()->json([
              'error' => true,
              'msg' => 'Hồ sơ đã thu bản cứng, không được sửa',
              'reload'  => true,
            ]);
        }

        if (!$mission->is_filled) {
          return response()->json([
            'error' => true,
            'msg' => 'Vui lòng nhập đầy đủ form đăng ký và lưu thông tin trước khi nộp bản mềm',
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

        //$check_is_filled = $mission->is_filled == 1 ? true : false;
        $check_is_submit_ele_copy = $mission->is_submit_ele_copy == 1 ? true : false;

        // if (!$check_is_filled) {
        //   return response()->json([
        //     'error' =>  true,
        //     'msg'   =>  'Not Filled'
        //   ]);
        // }

        // $evaluation_form_01  =  UploadFile::getPath('App\Models\MissionTopicAttribute', $mission->id, 'evaluation_form_01', 'mission_topics');

        // $evaluation_form_02  =  UploadFile::getPath('App\Models\MissionTopicAttribute', $mission->id, 'evaluation_form_02', 'mission_topics');

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
       			'table_name' => 'mission_topics',
       			'record_id'  => $mission->id
       		];

        ApplyLog::createLog($arr);

        DB::commit();

        return response()->json([
          'error'   =>  false,
          'msg'     =>  $content." thành công!",
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
    $topic = MissionTopic::find($id);

    $collectName = collect();

    $error = false;

    if (!empty($topic)) {
        
      foreach ($topic->values as $value) {
          
        if (empty($value->value)) {
          
          if ($value->mission_topic_attribute_id == 10 || $value->mission_topic_attribute_id == 11) {
            continue;
          }

          $column = MissionTopicAttribute::find($value->mission_topic_attribute_id)->label;

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
