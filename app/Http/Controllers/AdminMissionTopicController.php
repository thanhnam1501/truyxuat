<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MissionTopic;
use App\Models\MissionTopicValue;
use App\Models\MissionTopicAttributeValue;
use App\Models\MissionTopicAttribute;
use App\Models\RoundCollection;
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
        if (!Entrust::can('mission-topics-menu')) {
            abort(404);
        }
        $round_collection = RoundCollection::where('status',1)->get();

        return view('backend.admins.mission_topics.index',[
          'round_collection' => $round_collection,
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
              if (strlen($value->value) > 300) {
                  return "<span data-container='body' data-tooltip='tooltip' title='".$value->value."'>".substr($value->value, 0, 300)."..."."</span>";
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

          if ($topic->is_assign && Entrust::can(['valid-doc','invalid-doc']) && !$topic->is_valid && !$topic->is_invalid) {
            $string .=  "<a data-id='".$topic->id."' data-tooltip='tooltip' title='Xác nhận tính hợp lệ' class='btn btn-info btn-xs submit-valid'><i class='fa fa-check-circle-o'></i></a>";
          }

          if ($topic->is_valid && empty($topic->council_id) && Entrust::can(['assign-council'])) {
            $string .=  "<a data-id='".$topic->id."' data-tooltip='tooltip' title='Chọn hội đồng đánh giá' class='btn btn-brown btn-xs submit-hard-copy-btn'><i class='fa fa-users' aria-hidden='true'></i></a>";
          }

          if (!empty($topic->council_id) && !$topic->is_judged && Entrust::can(['judged-doc','denied-doc'])) {
            $string .=  "<a data-id='".$topic->id."' data-tooltip='tooltip' title='Xác nhận được đánh giá' class='btn btn-violet btn-xs submit-judged'><i class='fa fa-check-square-o'></i></a>";
          }    

          if ($topic->is_judged && Entrust::can(['approve-doc','unapprove-doc'])) {
          $string .=  "<a data-id='".$topic->id."' data-toggle='modal' href='#approve-mdl' data-tooltip='tooltip' title='Xác nhận được phê duyệt' class='btn btn-blue btn-xs approve-btn'><i class='fa fa-check-square'></i></a>";

               // $string .= "<i data-tooltip='tooltip' title='Xác nhận được phê duyệt' class='fa fa-check-square ico-info ico'></i>";
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
}
