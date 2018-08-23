<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MissionTopic;
use App\Models\MissionTopicValue;
use App\Models\MissionTopicAttributeValue;
use App\Models\MissionTopicAttribute;
use App\Models\RoundCollection;
use App\Models\GroupCouncil;
use App\Models\Council;
use App\Models\CouncilUser;
use App\Models\User;
use App\Models\CouncilMissionTopic;
use App\Models\UserHandleFile;
use Money;
use Auth;
use Entrust;
use DB;
use Crypt;
use AdminMission;
use UploadFile;
use Datatables;

class AdminMissionTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $round_collection = RoundCollection::where('status', 1)->get();
        $group_councils = GroupCouncil::where('status', 1)->get();

        $date = [
          'd' =>  date('d', strtotime(now())),
          'm' =>  date('m', strtotime(now())),
          'y' =>  date('Y', strtotime(now())),
        ];
        //     
        $role_user_devolve_file = User::where('type', 3)->get();

        $role_user_handle_file  = User::where('type', 4)->get();

        return view('backend.admins.mission_topics.index',[
          'round_collection' => $round_collection,
          'group_councils' => $group_councils,
          'date' => $date,
          'role_user_devolve_file' => $role_user_devolve_file,
          'role_user_handle_file' => $role_user_handle_file,
        ]);
    }

    public function getSubmitEleList()
    {
        $topics = MissionTopic::where('is_submit_ele_copy',1)->orderBy('id','desc')->with(['values','roundCollection','profile']);

        return Datatables::eloquent($topics)
        ->addIndexColumn()
        ->editColumn('values', function(MissionTopic $topic) {

          $attr_id = MissionTopicAttribute::where('column','name')->first()->id;

          foreach ($topic->values as $value) {

            if ($value->mission_topic_attribute_id == $attr_id) {
              if (strlen($value->value) > 150) {
                  return "<span data-container='body' data-placement='left' data-tooltip='tooltip' title='".$value->value."'>".substr($value->value, 0, 150)."..."."</span>";
              } else {
                  return $value->value;
              }
            }
          }

        })
        ->addColumn('status', function(MissionTopic $topic) {

            if ($topic->is_submit_hard_copy == 1) {

                return "<label class='label label-info'>Đã nộp bản cứng</label>";
            } else {

                return "<label class='label label-default'>Chưa nộp bản cứng</label>";
            }
        })
        ->addColumn('valid_status', function(MissionTopic $topic) {

            if ($topic->is_valid == 1) {

                return "<label class='label label-info'>Hợp lệ</label>";
            } else if ($topic->is_invalid == 1) {

                return "<label class='label label-danger'>Không hợp lệ</label>";
            } else {

                return "<label class='label label-default'>Chưa cập nhập</label>";
            }
        })
        ->addColumn('is_assign', function(MissionTopic $topic) {

            if ($topic->is_assign == 1) {

                return "<label class='label label-info'>Đã giao</label>";
            } else {

                return "<label class='label label-default'>Chưa giao</label>";
            }
        })
        ->addColumn('is_judged', function(MissionTopic $topic) {
            $check = CouncilMissionTopic::where('mission_id', $topic->id)->count();

            if ($check == 1) {
              return $str = "<label class='label label-info'>Đã chọn hội đồng</label>";
            }
            if ($topic->is_judged == 1) {

                return "<label class='label label-info'>Được đưa vào HĐ đánh giá</label>";
            } else if ($topic->is_denied == 1) {

                return "<label class='label label-danger'>Không được đưa vào HĐ</label>";
            } else {
                return "<label class='label label-default'>Chưa cập nhập</label>";
            }
        })
        ->addColumn('is_perform', function(MissionTopic $topic) {

            if ($topic->is_performed == 1) {

                return "<label class='label label-info'>Được thực hiện</label>";
            } else if ($topic->is_unperformed == 1) {

                return "<label class='label label-danger'>Không được thực hiện</label>";
            } else {
                return "<label class='label label-default'>Chưa cập nhập</label>";
            }
        })
        ->editColumn('roundCollection', function(MissionTopic $topic) {

          if (!empty($topic->roundCollection)) {
            return $topic->roundCollection->name." - ".$topic->roundCollection->year;
          } else {
            return "Chưa cập nhập";
          }
        })
        ->editColumn('profile', function(MissionTopic $topic) {

          if (!empty($topic->profile->organization)) {
            return $topic->profile->organization->name;
          } else {
            return "Chưa cập nhập";
          }
        })
        ->editColumn('type', function(MissionTopic $topic) {

          if ($topic->type == 0) {
              return "Đề tài";
          } else {
             return "Đề án";
          }
        })
        ->addColumn('action', function(MissionTopic $topic) {

          $string = "";

          if (Entrust::can('view-detail')) {

            $string .=  "<a data-tooltip='tooltip' title='Xem chi tiết' class='btn btn-success btn-xs' target='_blank' href='".route('admin.mission-topics.detail',$topic->key)."'><i class='fa fa-eye'></i></a>";
          }

          if ($topic->is_submit_ele_copy && !$topic->is_submit_hard_copy && Entrust::can(['receive-hard-copy'])) {
            $string .=  "<a data-id='".$topic->id."' data-tooltip='tooltip' title='Thu bản cứng' class='btn btn-warning btn-xs submit-hard-copy-btn'><i class='fa fa-bookmark'></i></a>";
          }

          if ($topic->is_submit_hard_copy && !$topic->is_assign && Entrust::can(['return-hard-copy'])) {

            $string .= "<a data-id='".$topic->id."' data-tooltip='tooltip' title='Trả lại bản cứng' class='btn btn-danger btn-xs'><i class='fa fa-undo'></i></a>";
          }

          if ($topic->is_submit_hard_copy && !$topic->is_assign && Entrust::can(['assign-doc'])) {
            $string .=  "<a data-id='".$topic->id."' data-tooltip='tooltip' title='Giao hồ sơ cho cán bộ xử lý' class='btn btn-warning btn-xs assign-doc'><i class='fa fa-paperclip'></i></a>";
          }

          if ($topic->is_assign && Entrust::can(['valid-doc','invalid-doc']) && !$topic->is_valid && !$topic->is_invalid ) {

            $check = UserHandleFile::where('user_id', Auth::guard('web')->user()->id)
                    ->where('mission_id', $topic->id)
                    ->where('mission_table', 'mission_topics')
                    ->where('is_handle', 0)
                    ->count();

            if ($check > 0) {      
              $string .=  "<a data-id='".$topic->id."' data-tooltip='tooltip' title='Xác nhận tính hợp lệ' class='btn btn-info btn-xs submit-valid'><i class='fa fa-check-circle-o'></i></a>";
            } 
          }

          if ($topic->is_valid && Entrust::can(['assign-council'])) {

            $check = CouncilMissionTopic::where('mission_id', $topic->id)->count();

            if ($check == 0) { // chua dc add hoi dong
              $string .=  "<a data-id='".$topic->id."' data-tooltip='tooltip' title='Chọn hội đồng đánh giá' class='btn btn-brown btn-xs add-council-btn'><i class='fa fa-users' aria-hidden='true'></i></a>";
            }
            
          }

          if (!empty($topic->council_id) && !$topic->is_judged && Entrust::can(['judged-doc','denied-doc'])) {
            $string .=  "<a data-id='".$topic->id."' data-tooltip='tooltip' title='Xác nhận được đánh giá' class='btn btn-violet btn-xs submit-judged'><i class='fa fa-check-square-o'></i></a>";
          }    

          if ($topic->is_judged && Entrust::can(['approve-doc','unapprove-doc'])) {
          $string .=  "<a data-id='".$topic->id."' data-toggle='modal' href='#approve-mdl' data-tooltip='tooltip' title='Xác nhận được phê duyệt' class='btn btn-blue btn-xs approve-btn'><i class='fa fa-check-square'></i></a>";

          }

          return $string;
        })
        ->make(true);
    }

    public function submitHardCopy(Request $request)
    {
        $data = $request->only('id');

        $data['table_name'] = 'mission_topics';

        $data['form'] = 'A1';

        $result = AdminMission::submitHardCopy($data);

        return response()->json($result);
    }

    public function approveMission(Request $request)
    {

      $data = $request->only('id','is_performed','is_unperformed_reason','approve_type','is_send_email');

      $data['table_name'] = 'mission_topics';

      $result = AdminMission::approveMission($data);

      return response()->json($result);
    }

    public function uploadListCategories(Request $request)
    {
      $data = $request->only('id','file');

      $data['table_name'] = 'mission_topics';

      $result = UploadFile::uploadListCategories($data);

      return response()->json($result);
    }

    public function submitValid(Request $request){
      $data = $request->only('status', 'checkbox', 'reason', 'id');

      $data['table_name'] = 'mission_topics';
      $data['form'] = 'A1';

      $result = AdminMission::submitValid($data);

      return response()->json($result);
    }

    public function submitJudged(Request $request){
      $data = $request->only('status', 'checkbox', 'reason', 'id');

      $data['table_name'] = 'mission_topics';
      $data['form'] = 'A1';

      $result = AdminMission::submitJudged($data);

      return response()->json($result);
    }

  public function detail($key, $print = null)
  {
    $topic = MissionTopic::where('key',$key)->first();

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

      $date = array();

      $date['d'] = date('d',time());
      $date['m'] = date('m',time());
      $date['y'] = date('Y',time());

      return view('backend.admins.mission_topics.detail',[
        'data'  => $data,
        'topic'  => $topic,
        'date'  => $date,
      ]);

    } else {

      abort(404);
    }
  }

  public function submitAssign(Request $request) {
    $data = $request->only('admin_id', 'user_id', 'deadline', 'note', 'mission_id');
    $data['mission_table']  = 'mission_topics';
    $data['model'] = 'App\Models\MissionTopic';
    $result = AdminMission::submitAssign($data);

    return $result;
  }

  public function getRoundCollection($id) {
    $mission = MissionTopic::find($id);

    return RoundCollection::find($mission->round_collection_id);
  }


  public function getListCouncil(Request $request) {
    $mission = MissionTopic::find($request->get('mission_id'));
    // dd($request->get('round_collection_id') . '-' . $request->get('group_council_id'));
    if (null != $request->get('round_collection_id') && null != $request->get('group_council_id')) {

      $round_collection_id = $request->get('round_collection_id');

      $group_council_id = $request->get('group_council_id');

      $councils = Council::where('round_collection_id', $round_collection_id)
                  ->where('group_council_id', $group_council_id)
                  ->where('status', 1)->get();

      return Datatables::of($councils)
      ->addIndexColumn()
      ->addColumn('name', function($council) {
        return $council->name;
      })
      ->addColumn('chairman_name', function($council) {
        $userCouncil = CouncilUser::where('position_council_id', 1)->where('council_id', $council->id)->orderBy('id', 'DESC')->first();

        if ($userCouncil != null) {
          return User::find($userCouncil->user_id)->name;
        }
        else {
          return 'Chưa cập nhật';
        }
        
      })

      ->addColumn('group_council', function($council) use ($group_council_id) {
        return GroupCouncil::find($group_council_id)->name;
      })


      ->addColumn('round_collection', function($council) use ($round_collection_id) {

        $round_collection =  RoundCollection::find($round_collection_id);

        return $round_collection->year . '-' . $round_collection->name;
      })
      ->addColumn('action', function($council) use ($mission) {
        // $council_mission = $mission->council->first();
        // if ($council_mission != null) {
        //   $id_council = $council_mission->council_id;
        //   if ($council->id == $id_council) {
        //     return '<input type="radio" name="council_id" id="council_id" value="'.$council->id.'" checked>';
        //   }
        // }
        return '<input type="radio" name="council_id" id="council_id" value="'.$council->id.'">';
      })
      ->make(true);
    }
  }

  public function addCouncil(Request $request) {

    $data['council_id'] =  $request->get('council_id');

    $data['mission_id'] =  $request->get('mission_topic_id');
    
    $data['mission_council']  = 'App\Models\CouncilMissionTopic';

    $result = AdminMission::addCouncil($data);

    return response()->json($result);

  }
}
