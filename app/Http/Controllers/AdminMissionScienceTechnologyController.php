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
use App\Models\EvaluationForm;
use App\Models\PositionCouncil;

use Auth;
use DB;
use Crypt;
use Datatables;
use Entrust;
use AdminMission;
use UploadFile;
use Illuminate\Support\Collection;


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
        if (!Entrust::can('mission-science-technology-menu')) {
            abort(404);
        }
        $round_collection = RoundCollection::where('status', 1)->get();
        $group_councils = GroupCouncil::where('status', 1)->get();

        $date = [
          'd' =>  date('d', strtotime(now())),
          'm' =>  date('m', strtotime(now())),
          'y' =>  date('Y', strtotime(now())),
        ];

        $role_user_devolve_file = User::where('type', 3)->get();

        $role_user_handle_file  = User::where('type', 4)->get();

        return view('backend.admins.mission_science_technologies.index', compact('round_collection', 'date', 'role_user_handle_file', 'role_user_devolve_file', 'group_councils'));

    }

    public function getSubmitEleList(Request $request)
    { 
        $topics = MissionScienceTechnology::select('mission_science_technologies.*', 'organizations.name as organization_name')
                ->where('mission_science_technologies.is_submit_ele_copy',1)
                ->join('profiles', 'mission_science_technologies.profile_id', '=', 'profiles.id')
                ->join('organizations', 'organizations.id', '=', 'profiles.organization_id')
                ->where(function ($query) use ($request){
                    if (isset($request->filter) && $request->filter == true) {

                        parse_str($request->data, $search);

                        if ($search['status_submit_hard_copy'] != -1) {
                          $query->where('is_submit_hard_copy', $search['status_submit_hard_copy']);
                        }

                        if ($search['status_submit_is_valid'] != -1) {
                          if ($search['status_submit_is_valid'] == 1) {
                            $query->where('is_valid', 1);
                          }
                          if ($search['status_submit_is_valid'] == 0) {
                            $query->where('is_invalid', 1);
                          }
                          if ($search['status_submit_is_valid'] == -2) {
                            $query->where('is_valid', 0)->where('is_invalid', 0);
                          }
                        }

                        if ($search['status_submit_is_judged'] != -1) {
                          if ($search['status_submit_is_judged'] == 1) {
                            $query->where('is_judged', 1);
                          }
                          if ($search['status_submit_is_judged'] == 0) {
                            $query->where('is_denied', 1);
                          }
                          if ($search['status_submit_is_judged'] == -2) {
                            $query->where('is_judged', 0)->where('is_denied', 0);
                          }
                        }

                        if ($search['status_submit_is_performed'] != -1) {
                          if ($search['status_submit_is_performed'] == 1) {
                            $query->where('is_performed', 1);
                          }
                          if ($search['status_submit_is_performed'] == 0) {
                            $query->where('is_unperformed', 1);
                          }
                          if ($search['status_submit_is_performed'] == -2) {
                            $query->where('is_performed', 0)->where('is_unperformed', 0);
                          }
                        }

                        if ($search['status_submit_is_assign'] != -1) {
                          $query->where('is_assign', $search['status_submit_is_assign']);
                        }

                        if ($search['round_collection'] != -1) {
                          $query->where('round_collection_id', $search['round_collection']);
                        }

                        if ( !empty($search['organization']) ) {
                          $query->where('organizations.name', 'LIKE', '%'.$search['organization'].'%');
                        }
                    }
                })->orderBy('id','desc')->get();

        foreach ($topics as $key => $topic) {
          $topic['mission_name'] = null;

          $attr_id = MissionScienceTechnologyAttribute::where('column','name')->first()->id;

          foreach ($topic->values as $value) {
            if ($value->mission_science_technology_attribute_id == $attr_id) {
              if (strlen($value->value) > 300) {
                  $topic['mission_name'] = "<span data-placement='left' data-tooltip='tooltip' title='".$value->value."'>".mb_substr($value->value, 0, 300)."..."."</span>";
              } else {
                  $topic['mission_name'] = $value->value;
              }
            }
          }

          if (isset($request->filter) && $request->filter == true) {
            parse_str($request->data, $search);

            if (!empty($search['mission_name'])) {
              $pos = strpos((string)$topic['mission_name'], (string)$search['mission_name']);

              if ($pos === false) {
                $topics->forget($key);
              }
            }
          }

        }

        return Datatables::of($topics)
        ->addIndexColumn()
        ->editColumn('values', function(MissionScienceTechnology $topic){
          if (!empty($topic->mission_name)) {
            return $topic->mission_name;
          }
        })
        ->addColumn('status', function(MissionScienceTechnology $topic) {

            if ($topic->is_submit_hard_copy == 1) {
                $str = "<label class='label label-info'>Đã nộp bản cứng</label>";
            } else {
                $str = "<label class='label label-default'>Chưa nộp bản cứng</label>";
            }

            return $str;
        })
        ->addColumn('valid_status', function(MissionScienceTechnology $topic) {

            if ($topic->is_valid == 1) {
                return "<label class='label label-info'>Hợp lệ</label>";
            }

            if ($topic->is_invalid == 1) {
                return "<label class='label label-danger'>Không hợp lệ</label>";
            }

                return "<label class='label label-default'>Chưa cập nhập</label>"; 

        })
        ->addColumn('is_assign', function(MissionScienceTechnology $topic) {

            if ($topic->is_assign == 1) {
                return "<label class='label label-info'>Đã giao</label>";
            } else {
                return "<label class='label label-default'>Chưa giao</label>";
            }
        })
        ->addColumn('is_judged', function(MissionScienceTechnology $topic) {
            // $check = CouncilMissionScienceTechnology::where('mission_id', $topic->id)->count();

            // if ($check == 1) {
            //   return "<label class='label label-default'>Đã chọn hội đồng</label>";
            // }
            if ($topic->is_judged == 1) {
              return "<label class='label label-info'>Được đưa vào HĐ đánh giá</label>";
            }

            if ($topic->is_denied == 1) {
              return "<label class='label label-danger'>Không được đưa vào HĐ</label>";
            }

            return "<label class='label label-default'>Chưa cập nhập</label>";
        })
        ->addColumn('is_perform', function(MissionScienceTechnology $topic) {
            
            if ($topic->is_performed == 1) {
                return "<label class='label label-info'>Được thực hiện</label>";
            }

            if ($topic->is_unperformed == 1) {
                return "<label class='label label-danger'>Không được thực hiện</label>";
            }

            return "<label class='label label-default'>Chưa cập nhập</label>";
        })
        ->editColumn('roundCollection', function(MissionScienceTechnology $topic){
          
          $str = "";
          if (!empty($topic->roundCollection)) {
            $str = $topic->roundCollection->name." - ".$topic->roundCollection->year;
          } else {
            $str = "Chưa cập nhập";
          }

          return $str;
        })
        ->editColumn('profile', function(MissionScienceTechnology $topic) {

          if (!empty($topic->organization_name)) {
            return $topic->organization_name;
          } else {
            return "Chưa cập nhập";
          }
        })
        ->editColumn('type', function(MissionScienceTechnology $topic) {
          return "Dự án KH&CN";
        })
        ->addColumn('action', function(MissionScienceTechnology $topic) {

          $string = "";

          if (Entrust::can('view-detail')) {

            $string .=  "<a data-tooltip='tooltip' title='Xem chi tiết' class='btn btn-success btn-xs' target='_blank' href='".route('admin.mission-science-technologys.detail',$topic->key)."'><i class='fa fa-eye'></i></a>";
          }

          if ($topic->is_submit_ele_copy && !$topic->is_submit_hard_copy && Entrust::can(['receive-hard-copy'])) {
            $string .=  '<a data-name="'.$topic->mission_name.'" data-id="'.$topic->id.'" data-tooltip="tooltip" title="Thu bản cứng" class="btn btn-warning btn-xs submit-hard-copy-btn"><i class="fa fa-bookmark"></i></a>';
          }

          if ($topic->is_submit_hard_copy && !$topic->is_assign && Entrust::can(['return-hard-copy'])) {

            $string .= '<a data-name="'.$topic->mission_name.'" data-id="'.$topic->id.'" data-tooltip="tooltip" title="Trả lại bản cứng" class="btn btn-danger btn-xs btn-give-back-hard-copy"><i class="fa fa-undo"></i></a>';
          }

          if ($topic->is_submit_hard_copy && !$topic->is_assign && Entrust::can(['assign-doc'])) {
            $string .=  "<a data-id='".$topic->id."' data-tooltip='tooltip' title='Giao hồ sơ cho cán bộ xử lý' class='btn btn-warning btn-xs assign-doc'><i class='fa fa-paperclip'></i></a>";
          }

          if ($topic->is_assign && Entrust::can(['valid-doc','invalid-doc']) && !$topic->is_valid && !$topic->is_invalid ) {

            $check = UserHandleFile::where('user_id', Auth::guard('web')->user()->id)
                    ->where('mission_id', $topic->id)
                    ->where('mission_table', 'mission_science_technologies')
                    ->where('is_handle', 0)
                    ->count();

            if ($check > 0) {      
              $string .=  '<a data-name="'.$topic->mission_name.'" data-id="'.$topic->id.'" data-tooltip="tooltip" title="Xác nhận tính hợp lệ" class="btn btn-info btn-xs submit-valid"><i class="fa fa-check-circle-o"></i></a>';
            } 
          }

          if ($topic->is_valid && Entrust::can(['assign-council'])) {

            $check = CouncilMissionScienceTechnology::where('mission_id', $topic->id)->count();

            if ($check == 0) { // chua dc add hoi dong
              $string .=  "<a data-id='".$topic->id."' data-tooltip='tooltip' title='Chọn hội đồng đánh giá' class='btn btn-brown btn-xs add-council-btn'><i class='fa fa-users' aria-hidden='true'></i></a>";
            }
            
          }

          // $flag_1 = false;
          // $flag_2 = false;
          
          // foreach ($topic->council as $council) {
          //     $users = $council->getUsers;
          //     foreach ($users as $user) {
          //         if ($user->id == Auth::id()) {
          //             $flag_1 = true;
          //         }
          //     }
          // }

          // foreach($topic->groupCouncil as $groupCouncil) {
          //     if ($groupCouncil->type == 0) {
          //         $flag_2 = true;
          //     }
          // }

          // if ($flag_1 && $flag_2 && Entrust::can('evaluation-doc') && $topic->is_judged == 0) {
          //       $string .= "<a target='_blank' data-id='".$topic->id."' href='".route('mission-science-technologys.evaluation', $topic->key)."' data-tooltip='tooltip' title='Đánh giá hồ sơ' class='btn btn-primary btn-xs'><i class='fa fa-comments-o' aria-hidden='true'></i></a>";
          //     }

//           $flag = $topic->judgeCouncil->first();

//           if (!empty($flag)) {

//               if ($flag->getJudgeCouncilMembers(Auth::guard('web')->user()->id)->count() > 0 && Entrust::can('evaluation-doc')) {
//                 $string .= "<a data-id='".$topic->id."' href='".route('mission-science-technologys.evaluation', $topic->key)."' data-tooltip='tooltip' title='Đánh giá hồ sơ' class='btn btn-primary btn-xs'><i class='fa fa-comments-o' aria-hidden='true'></i></a>";
//               }
//           }
// =======
//           if (Entrust::can(['evaluation-doc'])) {

//               $string .=  "<a data-id='".$topic->id."' href='".route('mission-science-technologys.evaluation', $topic->key)."' data-tooltip='tooltip' title='Đánh giá hồ sơ' class='btn btn-primary btn-xs'><i class='fa fa-comments-o' aria-hidden='true'></i></a>";
            

//           }

          if (!$topic->is_denied && !$topic->is_judged && Entrust::can(['judged-doc','denied-doc'])) {
            $check = CouncilMissionScienceTechnology::where('mission_id', $topic->id)->count();
            $data['mission_id'] = $topic->id;
            $data['mission']  = 'App\Models\CouncilMissionScienceTechnology';
            $data['table_name'] = 'mission_science_technologies';
            $check_3  = AdminMission::checkEvaluationDone($data);

            if ($check == 1 && $check_3) {
              $string .=  '<a data-name="'.$topic->mission_name.'" data-id="'.$topic->id.'" data-tooltip="tooltip" title="Xác nhận được đánh giá" class="btn btn-violet btn-xs submit-judged"><i class="fa fa-check-square-o"></i></a>';
            }
            
          }    

          if ($topic->is_judged && $topic->is_valid && !$topic->is_denied && !$topic->is_performed && !$topic->is_unperformed && Entrust::can(['approve-doc','unapprove-doc'])) {
          $string .=  '<a data-name="'.$topic->mission_name.'" data-id="'.$topic->id.'" data-toggle="modal" href="#approve-mdl" data-tooltip="tooltip" title="Xác nhận được phê duyệt" class="btn btn-blue btn-xs approve-btn"><i class="fa fa-check-square"></i></a>';
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
      $data = $request->only('id', 'mission_name');

      $data['table_name'] = 'mission_science_technologies';
      $data['form'] = 'A3';

      $result = AdminMission::submitHardCopy($data);

      return response()->json($result);
    }

    public function submitValid(Request $request){
      $data = $request->only('status', 'checkbox', 'reason', 'id', 'mission_name');

      $data['table_name'] = 'mission_science_technologies';
      $data['form'] = 'A3';

      $result = AdminMission::submitValid($data);

      return response()->json($result);
    }

    public function submitJudged(Request $request){
      $data = $request->only('status', 'checkbox', 'reason', 'id', 'mission_name');

      $data['table_name'] = 'mission_science_technologies';
      $data['form'] = 'A3';

      $result = AdminMission::submitJudged($data);

      return response()->json($result);
    }

    public function approveMission(Request $request)
    {

      $data = $request->only('id','is_performed','is_unperformed_reason','approve_type','is_send_email', 'mission_name');

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
        ->addColumn('action', function($council) {

          return "<a data-tooltip='tooltip' data-toggle='modal' title='Xem thành viên' id='viewListMember' class='btn btn-success btn-xs' href='#listMemberCouncil' data-id='".$council->id."'><i class='fa fa-eye'></i></a>";
        })

        ->addColumn('choose', function($council) use ($mission) {

          return '<input type="radio" name="council_id" id="council_id" value="'.$council->id.'">';
        })
        ->make(true);
      }
    }
    
    public function submitAssign(Request $request) {
      $data = $request->only('admin_id', 'user_id', 'deadline', 'note', 'mission_id');
      $data['mission_table']  = 'mission_science_technologies';
      $data['model'] = 'App\Models\MissionScienceTechnology';
      $result = AdminMission::submitAssign($data);

      return $result;


    }

    public function addCouncil(Request $request) {

      $data['council_id'] =  $request->get('council_id');

      $data['mission_id'] =  $request->get('mission_science_technology_id');
      
      $data['mission_council']  = 'App\Models\CouncilMissionScienceTechnology';

      $data['group_council_id'] = $request->get('group_council_id');

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

    public function giveBackHardCopy(Request $request){
      $data = $request->only('id');
      $data['mission_table']  = 'mission_science_technologies';
      $data['model'] = 'App\Models\MissionScienceTechnology';
      $result = AdminMission::giveBackHardCopy($data);

      return $result;
    }

    public function evaluation($key){
        $mission = MissionScienceTechnology::where('key', $key)->first();

        $date['d'] = date('d',strtotime(now()));
        $date['m'] = date('m',strtotime(now()));
        $date['y'] = date('Y',strtotime(now()));

        $stechs = MissionScienceTechnology::select([
                    'mission_science_technology_attributes.column',
                    'mission_science_technology_attribute_values.value'
                  ])
                  ->  where('mission_science_technologies.key', $key)
                  ->  where('mission_science_technology_attributes.column', 'name')
                  ->  join('mission_science_technology_values', 'mission_science_technology_values.mission_science_technology_id', '=', 'mission_science_technologies.id')
                  ->  join('mission_science_technology_attribute_values', 'mission_science_technology_attribute_values.id', '=', 'mission_science_technology_values.mission_science_technology_attribute_value_id')
                  ->  join('mission_science_technology_attributes', 'mission_science_technology_attributes.id', 'mission_science_technology_attribute_values.mission_science_technology_attribute_id')
                  ->  get()->first();

        $mission_name = $stechs->value;

        $content = "";
      $evaluation_form = EvaluationForm::where('user_id', Auth::id())
                    ->where('mission_id', $mission->id)
                    ->where('table_name', 'mission_science_technologies')->orderBy('id', 'Desc')->first();

      if ($evaluation_form !== null && $evaluation_form->count() >= 1) {
        $content = $evaluation_form->content;
      }

        // dd($content);

       return view('backend.admins.mission_science_technologies.evaluation-form', compact('mission', 'date', 'mission_name', 'content'));
    }

    public function storeEvaluation(Request $request) {

      $mission_id = $request->get('mission_id');
 
      $table_name = 'mission_science_technologies';

      $user_id = Auth::id();

      $data = $request->all();

      if ($data['urgency_target_note'] == null || $data['urgency_target_rate'] == null || $data['necessity_note'] == null || $data['necessity_rate'] == null || $data['possibility_note'] == null || $data['urgency_target_note'] == null || $data['suggest_perform'] == null) {
        return response()->json([
            'error' =>  true,
            'message' =>  'Vui lòng nhập đầy đủ thông tin',
        ]);
      }
      else {
        $is_perform = 0;
        $is_unperform = 0;
        $data['project_name'] = "";
        $data['project_result'] = "";
        $data['project_target'] = "";

        if ($data['suggest_perform'] == 0) {
          $is_perform = 1;
        }

        if ($data['suggest_perform'] == 1) {
          $is_unperform = 1;
        }

        if (null !==  $request->get('project_name')) {
          $data['project_name'] = $request->get('project_name');
        }

        if (null !== $request->get('project_result')) {
          $data['project_result'] = $request->get('project_result');
        }

        if (null !== $request->get('project_target')) {
          $data['project_target'] = $request->get('project_target');
        }

        $content = array(
          'comment_evaluation'  => array(
                                      'urgency_target' =>  array(
                                           'note' =>  $data['urgency_target_note'],
                                           'rate' =>  $data['urgency_target_rate'],
                                      ),

                                      'necessity' =>  array(
                                           'note' =>  $data['necessity_note'],
                                           'rate' =>  $data['necessity_rate'],
                                      ),

                                      'possibility' =>  array(
                                           'note' =>  $data['possibility_note'],
                                           'rate' =>  $data['possibility_rate'],
                                      ),
                                  ),

          'expert_opinions'  => array(
                                      'is_perform' =>  $is_perform,
                                      'is_unperform' =>  $is_unperform,
                                      'request' =>  array(
                                          'name'  =>  $data['project_name'],
                                          'target'  =>  $data['project_target'],
                                          'result'  =>  $data['project_result'],
                                      ),
                                     
                                  ),
        ); 
      }
      
      $datas['mission_id'] = $mission_id;
      $datas['table_name']  = $table_name;
      $datas['user_id'] = $user_id;
      $datas['content'] = $content;

      $result = AdminMission::evaluationDoc($datas);

      return response()->json($result);

    
       
    }

    public function listMemberCouncil($id) {

      $council = Council::find($id);

      $userCouncils = $council->users;

      return Datatables::of($userCouncils)
      ->addIndexColumn()
      ->editColumn('name', function($userCouncil) {
        return $userCouncil->name;
      })
      ->editColumn('email', function($userCouncil) {
        return '<a href="mailto:'.$userCouncil->email.'">'.$userCouncil->email.'</a>';
      })
      ->addColumn('mobile', function($userCouncil) {
        return '<a href="tel:'.$userCouncil->moblie.'">'.$userCouncil->mobile.'</a>';
      })
      ->addColumn('position', function($userCouncil) {
        return PositionCouncil::find($userCouncil->pivot->position_council_id)->name;
      })
      ->make(true);
    }

    public function listEvaluation() {
      return view('backend.admins.evaluation.mission_science_technologies.index');
    }

    public function getListEvaluation(Request $request) {
        $topics = MissionScienceTechnology::select('mission_science_technologies.*', 'organizations.name as organization_name')
                ->where('mission_science_technologies.is_submit_ele_copy',1)
                ->join('profiles', 'mission_science_technologies.profile_id', '=', 'profiles.id')
                ->join('organizations', 'organizations.id', '=', 'profiles.organization_id')
                ->where(function ($query) use ($request){
                    if (isset($request->filter) && $request->filter == true) {

                        parse_str($request->data, $search);

                        if ($search['status_submit_hard_copy'] != -1) {
                          $query->where('is_submit_hard_copy', $search['status_submit_hard_copy']);
                        }

                        if ($search['status_submit_is_valid'] != -1) {
                          if ($search['status_submit_is_valid'] == 1) {
                            $query->where('is_valid', 1);
                          }
                          if ($search['status_submit_is_valid'] == 0) {
                            $query->where('is_invalid', 1);
                          }
                          if ($search['status_submit_is_valid'] == -2) {
                            $query->where('is_valid', 0)->where('is_invalid', 0);
                          }
                        }

                        if ($search['status_submit_is_judged'] != -1) {
                          if ($search['status_submit_is_judged'] == 1) {
                            $query->where('is_judged', 1);
                          }
                          if ($search['status_submit_is_judged'] == 0) {
                            $query->where('is_denied', 1);
                          }
                          if ($search['status_submit_is_judged'] == -2) {
                            $query->where('is_judged', 0)->where('is_denied', 0);
                          }
                        }

                        if ($search['status_submit_is_performed'] != -1) {
                          if ($search['status_submit_is_performed'] == 1) {
                            $query->where('is_performed', 1);
                          }
                          if ($search['status_submit_is_performed'] == 0) {
                            $query->where('is_unperformed', 1);
                          }
                          if ($search['status_submit_is_performed'] == -2) {
                            $query->where('is_performed', 0)->where('is_unperformed', 0);
                          }
                        }

                        if ($search['status_submit_is_assign'] != -1) {
                          $query->where('is_assign', $search['status_submit_is_assign']);
                        }

                        if ($search['round_collection'] != -1) {
                          $query->where('round_collection_id', $search['round_collection']);
                        }

                        if ( !empty($search['organization']) ) {
                          $query->where('organizations.name', 'LIKE', '%'.$search['organization'].'%');
                        }
                    }
                })->orderBy('id','desc')->get();

        foreach ($topics as $key => $topic) {
          $topic['mission_name'] = null;

          $attr_id = MissionScienceTechnologyAttribute::where('column','name')->first()->id;

          foreach ($topic->values as $value) {
            if ($value->mission_science_technology_attribute_id == $attr_id) {
              if (strlen($value->value) > 300) {
                  $topic['mission_name'] = "<span data-placement='left' data-tooltip='tooltip' title='".$value->value."'>".mb_substr($value->value, 0, 300)."..."."</span>";
              } else {
                  $topic['mission_name'] = $value->value;
              }
            }
          }

          if (isset($request->filter) && $request->filter == true) {
            parse_str($request->data, $search);

            if (!empty($search['mission_name'])) {
              $pos = strpos((string)$topic['mission_name'], (string)$search['mission_name']);

              if ($pos === false) {
                $topics->forget($key);
              }
            }
          }

        }

        foreach ($topics as $key => $topic) {
          
          
          $flag_1 = false;
          $flag_2 = false;
          
          foreach ($topic->council as $council) {
              $users = $council->getUsers;
              foreach ($users as $user) {
                  if ($user->id == Auth::id()) {
                      $flag_1 = true;
                  }
              }
          }

          foreach($topic->groupCouncil as $groupCouncil) {
              if ($groupCouncil->type == 0) {
                  $flag_2 = true;
              }
          }

          if (!($flag_1 && $flag_2)) {
              $topics->forget($key);
          }
        }

        return Datatables::of($topics)
        ->addIndexColumn()
        ->editColumn('values', function(MissionScienceTechnology $topic){
          if (!empty($topic->mission_name)) {
            return $topic->mission_name;
          }
        })
        ->addColumn('status', function(MissionScienceTechnology $topic) {

            if ($topic->is_submit_hard_copy == 0) {
              return "<label class='label label-default'>Chưa nộp bản cứng</label>";
            }
            else {
              if ($topic->is_assign == 0) {
                return "<label class='label label-info'>Đã nộp bản cứng</label>";
              }
              else{
                if ($topic->is_valid == 0 && $topic->is_invalid == 0) {
                  return "<label class='label label-info'>Đã giao</label>";
                }
                elseif ($topic->is_invalid == 1) {
                  return "<label class='label label-danger'>Không hợp lệ</label>";
                }
                elseif($topic->is_valid == 1) {
                  if ($topic->is_judged == 0 && $topic->is_denied == 0) {
                    return "<label class='label label-info'>Được đưa vào HĐ đánh giá</label>";
                  }
                  elseif($topic->is_judged == 1) {
                    if ($topic->is_performed == 0 && $topic->is_unperformed == 0) {
                      return "<label class='label label-info'>Hồ sơ được đánh giá</label>"; 
                    }
                    elseif ($topic->is_unperformed == 1) {
                      return "<label class='label label-danger'>Không được thực hiện</label>";
                    }
                    elseif ($topic->is_performed == 1) {
                      return "<label class='label label-info'>Được thực hiện</label> </br>";
                    }
                  }  
                }
              }
            }
     
        })
        
        ->editColumn('roundCollection', function(MissionScienceTechnology $topic){
          
          $str = "";
          if (!empty($topic->roundCollection)) {
            $str = $topic->roundCollection->name." - ".$topic->roundCollection->year;
          } else {
            $str = "Chưa cập nhập";
          }

          return $str;
        })
        ->editColumn('profile', function(MissionScienceTechnology $topic) {

          if (!empty($topic->organization_name)) {
            return $topic->organization_name;
          } else {
            return "Chưa cập nhập";
          }
        })

        

        ->addColumn('action', function(MissionScienceTechnology $topic) {
          $flag_1 = false;
          $flag_2 = false;
          foreach ($topic->council as $council) {
              $users = $council->getUsers;
              foreach ($users as $user) {
                  if ($user->id == Auth::id()) {
                      $flag_1 = true;
                  }
              }
          }

          foreach($topic->groupCouncil as $groupCouncil) {
              if ($groupCouncil->type == 0) {
                  $flag_2 = true;
              }
          }

          $string = "";
          if (Entrust::can('view-detail')) {

            $string .=  "<a data-tooltip='tooltip' title='Xem chi tiết' class='btn btn-success btn-xs' target='_blank' href='".route('admin.mission-science-technologys.detail',$topic->key)."'><i class='fa fa-eye'></i></a>";
          }

          if ($flag_1 && $flag_2 && Entrust::can('evaluation-doc') && $topic->is_judged == 0 && $topic->is_valid == 1) {
            $string .= "<a target='_blank' data-id='".$topic->id."' href='".route('mission-science-technologys.evaluation', $topic->key)."' data-tooltip='tooltip' title='Đánh giá hồ sơ' class='btn btn-primary btn-xs'><i class='fa fa-comments-o' aria-hidden='true'></i></a>";
          }


          return $string;
        })
        ->make(true);

    }
}
