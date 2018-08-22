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
use App\Models\MissionTopic;
use App\Models\MissionTopicAttribute;
use App\Models\GroupCouncil;
use App\Models\Council;
use App\Models\CouncilUser;

use App\Models\User;
use App\Models\RoleUser;
use App\Models\Role;
use App\Models\UserHandleFile;
use App\Models\ApplyLog;
use App\Models\CouncilMissionScienceTechnology;

use Auth;
use DB;
use Crypt;
use Datatables;
use Entrust;
use AdminMission;
use UploadFile;

class AdminMissionScienceTechnologyController extends Controller
{
    public function __construct() {
      $this->middleware('auth');
    }
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

        $role_user_devolve_file = User::select('users.*')
            ->  join('role_users', 'role_users.user_id', '=', 'users.id')
            ->  join('roles', 'roles.id', '=', 'role_users.role_id')
            ->  where('role_users.role_id', 4)
            ->  get();

        $role_user_handle_file = User::select('users.*')
            ->  join('role_users', 'role_users.user_id', '=', 'users.id')
            ->  join('roles', 'roles.id', '=', 'role_users.role_id')
            ->  where('role_users.role_id', 5)
            ->  get();

        return view('backend.admins.mission_science_technologies.index', compact('round_collection', 'date', 'role_user_handle_file', 'role_user_devolve_file', 'group_councils'));

    }

    public function getSubmitEleList()
    {
        $topics = MissionScienceTechnology::where('is_submit_ele_copy',1)->orderBy('id','desc')->with(['values','roundCollection','profile']);

        return Datatables::eloquent($topics)
        ->addIndexColumn()
        ->editColumn('values', function(MissionScienceTechnology $topic) {

          $attr_id = MissionScienceTechnologyAttribute::where('column','name')->first()->id;

          foreach ($topic->values as $value) {

            if ($value->mission_science_technology_attribute_id == $attr_id) {
              if (strlen($value->value) > 300) {
                  return "<span data-placement='left' data-tooltip='tooltip' title='".$value->value."'>".substr($value->value, 0, 300)."..."."</span>";
              } else {
                  return $value->value;
              }
            }
          }
        })
        ->addColumn('status', function(MissionScienceTechnology $topic) {

            if ($topic->is_submit_hard_copy == 1) {

                return "<label class='label label-info'>Đã nộp bản cứng</label>";
            } else {

                return "<label class='label label-default'>Chưa nộp bản cứng</label>";
            }
        })
        ->addColumn('valid_status', function(MissionScienceTechnology $topic) {
            $str = "<label class='label label-default'>Chưa cập nhập</label>";

            if ($topic->is_valid == 1) {
                $str = "<label class='label label-info'>Hợp lệ</label>";
            }

            if ($topic->is_invalid == 1) {
                $str = "<label class='label label-danger'>Không hợp lệ</label>";
            }

            return $str;
        })
        ->addColumn('is_assign', function(MissionScienceTechnology $topic) {

            if ($topic->is_assign == 1) {

                return "<label class='label label-info'>Đã giao</label>";
            } else {

                return "<label class='label label-default'>Chưa giao</label>";
            }
        })
        ->addColumn('is_judged', function(MissionScienceTechnology $topic) {
            $str = "<label class='label label-default'>Chưa cập nhập</label>";

            if ($topic->is_judged == 1) {
                $str = "<label class='label label-info'>Được đưa vào HĐ đánh giá</label>";
            }

            if ($topic->is_denied == 1) {
                $str = "<label class='label label-danger'>Không được đưa vào HĐ</label>";
            }

            return $str;
        })
        ->addColumn('is_perform', function(MissionScienceTechnology $topic) {

            if ($topic->is_perform == 1) {

                return "<label class='label label-info'>Được thực hiện</label>";
            } else if ($topic->is_unperformed == 1) {

                return "<label class='label label-danger'>Không được thực hiện</label>";
            } else {
                return "<label class='label label-default'>Chưa cập nhập</label>";
            }
        })
        ->editColumn('roundCollection', function(MissionScienceTechnology $topic) {

          if (!empty($topic->roundCollection)) {
            return $topic->roundCollection->name." - ".$topic->roundCollection->year;
          } else {
            return "Chưa cập nhập";
          }
        })
        ->editColumn('profile', function(MissionScienceTechnology $topic) {

          if (!empty($topic->profile->organization)) {
            return $topic->profile->organization->name;
          } else {
            return "Chưa cập nhập";
          }
        })
        ->editColumn('type', function(MissionScienceTechnology $topic) {
          return "Dự án khoa học và công nghệ";
        })
        ->addColumn('action', function(MissionScienceTechnology $topic) {

          $string = "";

          if (Entrust::can('view-detail')) {
            $string .=  "<a data-tooltip='tooltip' title='Xem chi tiết' class='btn btn-success btn-xs' href='".route('admin.mission-science-technologys.detail',$topic->key)."' target='_blank'><i class='fa fa-eye'></i></a>";
          }

          if ($topic->is_submit_ele_copy && !$topic->is_submit_hard_copy && Entrust::can(['receive-hard-copy'])) {
            $string .=  "<a data-id='".$topic->id."' data-tooltip='tooltip' title='Thu bản cứng' class='btn btn-warning btn-xs submit-hard-copy-btn'><i class='fa fa-bookmark'></i></a>";
          }


          $string .=  "<a data-id='".$topic->id."' data-tooltip='tooltip' title='Chọn hội đồng đánh giá' class='btn btn-brown btn-xs add-council-btn'><i class='fa fa-users' aria-hidden='true'></i></a>";

          if ($topic->is_submit_hard_copy && !$topic->is_assign && Entrust::can(['return-hard-copy'])) {

            $string .= "<a data-id='".$topic->id."' data-tooltip='tooltip' title='Trả lại bản cứng' class='btn btn-danger btn-xs'><i class='fa fa-undo'></i></a>";
          }

          if ($topic->is_submit_hard_copy && !$topic->is_assign && Entrust::can(['assign-doc'])) {
            $string .=  "<a data-id='".$topic->id."' data-tooltip='tooltip' title='Giao hồ sơ cho cán bộ xử lý' class='btn btn-warning btn-xs assign-doc'><i class='fa fa-paperclip'></i></a>";
          }

          if ($topic->is_assign && Entrust::can(['valid-doc','invalid-doc']) && !$topic->is_valid && !$topic->is_invalid) {
            $string .=  "<a data-id='".$topic->id."' data-tooltip='tooltip' title='Xác nhận tính hợp lệ' class='btn btn-info btn-xs submit-valid'><i class='fa fa-check-circle-o'></i></a>";
          }

          if ($topic->is_valid && Entrust::can(['assign-council'])) {
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function submitHardCopy(Request $request) {
      $data = $request->only('id');

      $data['table_name'] = 'mission_science_technologies';
      $data['form'] = 'A3';

      $result = AdminMission::submitHardCopy($data);

      return response()->json($result);
    }

    public function submitValid(Request $request){
      $data = $request->only('status', 'checkbox', 'reason', 'id');

      $data['table_name'] = 'mission_science_technologies';
      $data['form'] = 'A3';

      $result = AdminMission::submitValid($data);

      return response()->json($result);
    }

    public function submitJudged(Request $request){
      $data = $request->only('status', 'checkbox', 'reason', 'id');

      $data['table_name'] = 'mission_science_technologies';
      $data['form'] = 'A3';

      $result = AdminMission::submitJudged($data);

      return response()->json($result);
    }

    public function approveMission(Request $request)
    {

      $data = $request->only('id','is_performed','is_unperformed_reason','approve_type','is_send_email');

      $data['table_name'] = 'mission_science_technologies';

      $result = AdminMission::approveMission($data);

      return response()->json($result);
    }

    public function uploadListCategories(Request $request)
    {
      $data = $request->only('id','file');

      $data['table_name'] = 'mission_science_technologies';

      $result = UploadFile::uploadListCategories($data);

      return response()->json($result);
    }

    public function viewDetail(Request $request){
      $data = $request->only('id');
      $data['model'] = 'App\Models\MissionScienceTechnology';
      $data['form'] = 'A3';

      $result = AdminMission::viewDetail($data);

      return $result;
    }

    public function getRoundCollection($id) {
      $mission = MissionScienceTechnology::find($id);

      return RoundCollection::find($mission->round_collection_id);
    }


    public function getListCouncil(Request $request) {
      $mission = MissionScienceTechnology::find($request->get('mission_id'));
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
    
    public function submitAssign(Request $request) {
      $data = $request->only('admin_id', 'user_id', 'deadline', 'note', 'mission_id');
      $data['mission_table']  = 'mission_science_technologies';

      $result = AdminMission::submitAssign($data);

      return $result;


    }

    public function addCouncil(Request $request) {

      $data['council_id'] =  $request->get('council_id');

      $data['mission_id'] =  $request->get('mission_science_technology_id');
      
      $data['mission_council']  = 'App\Models\CouncilMissionScienceTechnology';

      $result = AdminMission::addCouncil($data);

      return response()->json($result);

    }

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

        return view('backend.admins.mission_science_technologies.detail', compact('is_submit_hard_copy', 'is_submit_ele_copy', 'data', 'key', 'st_key','date', 'is_filled'));
    }
}
