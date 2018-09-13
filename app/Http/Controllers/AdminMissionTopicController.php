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
use App\Models\EvaluationForm;
use App\Models\PositionCouncil;
use App\Models\Organization;
use App\Models\Profile;
use Money;
use Auth;
use Entrust;
use DB;
use Crypt;
use AdminMission;
use UploadFile;
use Datatables;
use Excel;
use ExportExcel;

class AdminMissionTopicController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      
    public function getNameMissions() {
      $missionsValue = MissionTopicAttributeValue::where('mission_topic_attribute_id', 1)->where('value', '<>', null)->orderBy('id','DESC')->get();
      foreach ($missionsValue as $value) {
        $arr_results[] = $value->value;
      }
      return response()->json(['arr_results' => $arr_results]);
    }

    public function edit($key) {
      $topic = MissionTopic::where('key',$key)->first();

    if (empty($topic) || $topic->count() < 0) {

      abort(404);
    }


    $columns = MissionTopicAttribute::all();

    $data = array();

    if (true) {
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
      $status_submit_hard_copy = $topic->is_submit_hard_copy == 1 ? "<p>Hồ sơ đã nộp bản cứng</p>Thời gian nộp: ".date('d-m-Y', strtotime($topic->time_submit_hard_copy)) : "<p class='text-red'>Hồ sơ chưa nộp bản cứng</p>";

      $doc_status = "";

      if ($topic->is_assign) {
          $doc_status = "<p>Hồ sơ đã được giao cho cán bộ xử lý</p>";
      }

      if ($topic->is_valid) {
          
          $doc_status = "<p>Hồ sơ hợp lệ</p>";
      } else if ($topic->is_invalid) {

          $doc_status = "<p class'error'>Hồ sơ không hợp lệ</p>";
      }

      if (CouncilMissionTopic::where('mission_id', $topic->id)->count() > 0) {
          
          $doc_status = "<p>Hồ sơ đã được giao cho hội đồng đánh giá</p>";
      }

      $is_submit_ele_copy = $topic->is_submit_ele_copy;
      $is_submit_hard_copy = $topic->is_submit_hard_copy;

      $date = array();

      $date['d'] = date('d',time());
      $date['m'] = date('m',time());
      $date['y'] = date('Y',time());

      return view('backend.admins.mission_topics.edit',[
        'topic' => $topic,
        'data' => $data,
        'status_submit_ele_copy'  =>  $status_submit_ele_copy,
        'status_submit_hard_copy' =>  $status_submit_hard_copy,
        'is_submit_ele_copy'  =>  $is_submit_ele_copy,
        'is_submit_hard_copy' =>  $is_submit_hard_copy,
        'date'  => $date,
        'doc_status'  => $doc_status,
      ]);
    }

    }

    public function update(Request $request) {

    $data = $request->only('expected_fund','expected_main_content','expected_result_perform','id','key','name','propose_base','result_target_requirement','target','time_result_requirement','type','urgency');

    $fund = Money::format($data['expected_fund'], 'VNĐ');

    if ($fund < 100000) {
      return response()->json(['error' => true, 'message' =>  'Dự kiến nhu cầu kinh phí phải lớn hơn 100,000 VNĐ']);
    }

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


    public function index()
    {

        if (!Entrust::can('mission-topics-menu')) {
            abort(404);
        }

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

    public function getSubmitEleList(Request $request)
    {
        $topics = MissionTopic::select('mission_topics.*', 'profiles.organization_id')
                ->where('mission_topics.is_submit_ele_copy',1)
                ->join('profiles', 'mission_topics.profile_id', '=', 'profiles.id')
                // ->join('organizations', 'organizations.id', '=', 'profiles.organization_id')
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
                          $query->where('profiles.representative', 'LIKE', '%'.$search['organization'].'%');
                        }
                    }
                })->orderBy('id','desc')->get();

        foreach ($topics as $key => $topic) {
          $topic['mission_name'] = null;

          $attr_id = MissionTopicAttribute::where('column','name')->first()->id;

          foreach ($topic->values as $value) {
            if ($value->mission_topic_attribute_id == $attr_id) {
              if (strlen($value->value) > 300) {
                  $topic['mission_name'] = "<span data-placement='left' data-tooltip='tooltip' title='".$value->value."'>".mb_substr($value->value, 0, 300)."..."."</span>";
              } else {
                  $topic['mission_name'] = $value->value;
              }
            }
          }

          $attr_time_result_requirement_id = MissionTopicAttribute::where('column','time_result_requirement')->first()->id;

          foreach ($topic->values as $value) {
            if ($value->mission_topic_attribute_id == $attr_time_result_requirement_id) {
              if (strlen($value->value) > 300) {
                  $topic['time_result_requirement'] = "<span data-placement='left' data-tooltip='tooltip' title='".$value->value."'>".mb_substr($value->value, 0, 300)."..."."</span>";
              } else {
                  $topic['time_result_requirement'] = $value->value;
              }
            }
          }

          $attr_target_id = MissionTopicAttribute::where('column','target')->first()->id;

          foreach ($topic->values as $value) {
            if ($value->mission_topic_attribute_id == $attr_target_id) {
              if (strlen($value->value) > 300) {
                  $topic['target'] = "<span data-placement='left' data-tooltip='tooltip' title='".$value->value."'>".mb_substr($value->value, 0, 300)."..."."</span>";
              } else {
                  $topic['target'] = $value->value;
              }
            }
          }

          $attr_result_target_requirement_id = MissionTopicAttribute::where('column','result_target_requirement')->first()->id;

          foreach ($topic->values as $value) {

            if ($value->mission_topic_attribute_id == $attr_result_target_requirement_id) {

              if (strlen($value->value) > 300) {
                  $topic['result_target_requirement'] = "<span data-placement='left' data-tooltip='tooltip' title='".$value->value."'>".mb_substr($value->value, 0, 300)."..."."</span>";
              } else {
                  $topic['result_target_requirement'] = $value->value;
              }
            }
          }

          $attr_expected_fund_id = MissionTopicAttribute::where('column','expected_fund')->first()->id;

          foreach ($topic->values as $value) {
            if ($value->mission_topic_attribute_id == $attr_expected_fund_id) {
              
              $topic['expected_fund'] = $value->value;
              
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
        ->editColumn('values', function(MissionTopic $topic) {

          if (!empty($topic->mission_name)) {
            return $topic->mission_name;
          }

        })
        ->addColumn('status', function(MissionTopic $topic) {

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
                    return "<label class='label label-info'>Hồ sơ hợp lệ</label>";
                  }
                  elseif($topic->is_judged == 1) {
                    if ($topic->is_performed == 0 && $topic->is_unperformed == 0) {
                      return "<label class='label label-info'>Hồ sơ được đưa vào HĐ đánh giá</label>"; 
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
        
        ->addColumn('profile', function(MissionTopic $topic){                    
          $profile = Profile::find($topic->profile_id);
          return $profile->representative . '-' . $profile->mobile;
        })

        ->editColumn('organization', function(MissionTopic $topic) {

          $organization = Organization::find($topic->organization_id);

          return !is_null($organization) ? $organization->name : null;
        })

        ->addColumn('request_time',function(MissionTopic $topic) {
          return $topic->time_result_requirement;
        })

        ->addColumn('target', function(MissionTopic $topic) {
          return $topic->target;
        })
        ->addColumn('request_result', function(MissionTopic $topic) {
          return $topic->result_target_requirement;
        })
        ->addColumn('expected_fund', function(MissionTopic $topic) {
          return number_format(Crypt::decrypt($topic->expected_fund)) . " VNĐ";
        })
        ->addColumn('action', function(MissionTopic $topic) {

          $string = "";

          if (Entrust::can('view-detail')) {

            $string .=  "<a data-tooltip='tooltip' title='Xem chi tiết' class='btn btn-success btn-xs' target='_blank' href='".route('admin.mission-topics.detail',$topic->key)."'><i class='fa fa-eye'></i></a>";
          }

          if (Entrust::can('update-doc')) {

            $string .= "<a data-tooltip='tooltip' title='Chỉnh sửa' href='".route('admin.mission-topics.edit',$topic->key)."' class='btn btn-info  btn-xs'><i class='fa fa-pencil'></i></a>";

          }

          if ($topic->is_submit_ele_copy && !$topic->is_submit_hard_copy && Entrust::can(['receive-hard-copy'])) {
            $string .=  '<a data-name="'.$topic->mission_name.'" data-id="'.$topic->id.'" data-tooltip="tooltip" title="Thu bản cứng" class="btn btn-warning btn-xs submit-hard-copy-btn"><i class="fa fa-bookmark"></i></a>';
          }

          if ($topic->is_submit_hard_copy && !$topic->is_assign && Entrust::can(['return-hard-copy'])) {

            $string .= '<a data-id="'.$topic->id.'" data-tooltip="tooltip" title="Trả lại bản cứng" class="btn btn-danger btn-xs btn-give-back-hard-copy"><i class="fa fa-undo"></i></a>';
          }

          if ($topic->is_submit_hard_copy && !$topic->is_assign && Entrust::can(['assign-doc'])) {
            $string .=  '<a data-id="'.$topic->id.'" data-tooltip="tooltip" title="Giao hồ sơ cho cán bộ xử lý" class="btn btn-warning btn-xs assign-doc"><i class="fa fa-paperclip"></i></a>';
          }

          // if ($topic->is_assign && Entrust::can(['valid-doc','invalid-doc']) && !$topic->is_valid && !$topic->is_invalid ) {

          //   $check = UserHandleFile::where('user_id', Auth::guard('web')->user()->id)
          //           ->where('mission_id', $topic->id)
          //           ->where('mission_table', 'mission_topics')
          //           ->where('is_handle', 0)
          //           ->count();

          //   if ($check > 0) {      
          //     $string .=  '<a data-name="'.$topic->mission_name.'" data-id="'.$topic->id.'" data-tooltip="tooltip" title="Xác nhận tính hợp lệ" class="btn btn-info btn-xs submit-valid"><i class="fa fa-check-circle-o"></i></a>';
          //   } 
          // }

          if ($topic->is_valid && Entrust::can(['assign-council'])) {
            $check = CouncilMissionTopic::where('mission_id', $topic->id)->count();

            if ($check == 0) { // chua dc add hoi dong
              $string .=  '<a data-id="'.$topic->id.'" data-tooltip="tooltip" title="Chọn hội đồng đánh giá" class="btn btn-brown btn-xs add-council-btn"><i class="fa fa-users" aria-hidden="true"></i></a>';
            }
          }
     
          $data['mission_id'] = $topic->id;
          $data['mission']  = 'App\Models\CouncilMissionTopic';
          $data['table_name'] = 'mission_topics';
          $check  = AdminMission::checkEvaluationDone($data);

          if ($topic->is_judged && $check && $topic->is_valid && !$topic->is_denied && !$topic->is_performed && !$topic->is_unperformed && Entrust::can(['approve-doc','unapprove-doc'])) {
          $string .=  '<a data-name="'.$topic->mission_name.'" data-id="'.$topic->id.'" data-toggle="modal" href="#approve-mdl" data-tooltip="tooltip" title="Xác nhận được phê duyệt" class="btn btn-blue btn-xs approve-btn"><i class="fa fa-check-square"></i></a>';
          }

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

          if ($flag_1 && $flag_2 && Entrust::can('evaluation-doc') && $topic->is_judged == 0) {
            $string .=  "<a target='_blank' data-id='".$topic->id."' href='".route('admin.mission-topics.judged', $topic->key)."' data-tooltip='tooltip' title='Đánh giá hồ sơ' class='btn btn-primary btn-xs'><i class='fa fa-comments-o' aria-hidden='true'></i></a>";
          }
          //     
          // $flag = $topic->judgeCouncil->first();

          // if (!empty($flag)) {
          //     if ($flag->getJudgeCouncilMembers(Auth::guard('web')->user()->id)->count() > 0 && Entrust::can('evaluation-doc')) {
          //       $string .=  "<a target='_blank' data-id='".$topic->id."' href='".route('admin.mission-topics.judged', $topic->key)."' data-tooltip='tooltip' title='Đánh giá hồ sơ' class='btn btn-primary btn-xs'><i class='fa fa-comments-o' aria-hidden='true'></i></a>";
          //     }
          // }

          return $string;
        })
        ->make(true);
    }

    public function getInvalidTopic(Request $request)
    {
        $topics = MissionTopic::select('mission_topics.*', 'profiles.organization_id')
                ->where('mission_topics.is_submit_ele_copy',1)
                ->join('profiles', 'mission_topics.profile_id', '=', 'profiles.id')
                ->join('organizations', 'organizations.id', '=', 'profiles.organization_id')
                ->where('mission_topics.is_valid', 1)
                ->where('mission_topics.is_invalid', 0)
                ->where('mission_topics.is_denied', 0)
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

          $attr_id = MissionTopicAttribute::where('column','name')->first()->id;

          foreach ($topic->values as $value) {
            if ($value->mission_topic_attribute_id == $attr_id) {
              if (strlen($value->value) > 300) {
                  $topic['mission_name'] = "<span data-placement='left' data-tooltip='tooltip' title='".$value->value."'>".mb_substr($value->value, 0, 300)."..."."</span>";
              } else {
                  $topic['mission_name'] = $value->value;
              }
            }
          }

          $attr_time_result_requirement_id = MissionTopicAttribute::where('column','time_result_requirement')->first()->id;

          foreach ($topic->values as $value) {
            if ($value->mission_topic_attribute_id == $attr_time_result_requirement_id) {
              if (strlen($value->value) > 300) {
                  $topic['time_result_requirement'] = "<span data-placement='left' data-tooltip='tooltip' title='".$value->value."'>".mb_substr($value->value, 0, 300)."..."."</span>";
              } else {
                  $topic['time_result_requirement'] = $value->value;
              }
            }
          }

          $attr_target_id = MissionTopicAttribute::where('column','target')->first()->id;

          foreach ($topic->values as $value) {
            if ($value->mission_topic_attribute_id == $attr_target_id) {
              if (strlen($value->value) > 300) {
                  $topic['target'] = "<span data-placement='left' data-tooltip='tooltip' title='".$value->value."'>".mb_substr($value->value, 0, 300)."..."."</span>";
              } else {
                  $topic['target'] = $value->value;
              }
            }
          }

          $attr_result_target_requirement_id = MissionTopicAttribute::where('column','result_target_requirement')->first()->id;

          foreach ($topic->values as $value) {

            if ($value->mission_topic_attribute_id == $attr_result_target_requirement_id) {

              if (strlen($value->value) > 300) {
                  $topic['result_target_requirement'] = "<span data-placement='left' data-tooltip='tooltip' title='".$value->value."'>".mb_substr($value->value, 0, 300)."..."."</span>";
              } else {
                  $topic['result_target_requirement'] = $value->value;
              }
            }
          }

          $attr_expected_fund_id = MissionTopicAttribute::where('column','expected_fund')->first()->id;

          foreach ($topic->values as $value) {
            if ($value->mission_topic_attribute_id == $attr_expected_fund_id) {
              
              $topic['expected_fund'] = $value->value;
              
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
        ->editColumn('values', function(MissionTopic $topic) {

          if (!empty($topic->mission_name)) {
            return $topic->mission_name;
          }

        })
        ->addColumn('status', function(MissionTopic $topic) {

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
                    return "<label class='label label-info'>Hồ sơ hợp lệ</label>";
                  }
                  elseif($topic->is_judged == 1) {
                    if ($topic->is_performed == 0 && $topic->is_unperformed == 0) {
                      return "<label class='label label-info'>Hồ sơ được đưa vào HĐ đánh giá</label>"; 
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
        
        ->addColumn('profile', function(MissionTopic $topic){                    
          $profile = Profile::find($topic->profile_id);
          return $profile->representative . '-' . $profile->mobile;
        })

        ->editColumn('organization', function(MissionTopic $topic) {

          $organization = Organization::find($topic->organization_id);

          return !is_null($organization) ? $organization->name : null;
        })

        ->addColumn('request_time',function(MissionTopic $topic) {
          return $topic->time_result_requirement;
        })

        ->addColumn('target', function(MissionTopic $topic) {
          return $topic->target;
        })
        ->addColumn('request_result', function(MissionTopic $topic) {
          return $topic->result_target_requirement;
        })
        ->addColumn('expected_fund', function(MissionTopic $topic) {
          return number_format(Crypt::decrypt($topic->expected_fund)) . " VNĐ";
        })
        ->addColumn('action', function(MissionTopic $topic) {

          $string = "";

          if (Entrust::can('view-detail')) {

            $string .=  "<a data-tooltip='tooltip' title='Xem chi tiết' class='btn btn-success btn-xs' target='_blank' href='".route('admin.mission-topics.detail',$topic->key)."'><i class='fa fa-eye'></i></a>";
          }

          // if ($topic->is_assign && Entrust::can(['valid-doc','invalid-doc']) && !$topic->is_valid && !$topic->is_invalid ) {

          //   $check = UserHandleFile::where('user_id', Auth::guard('web')->user()->id)
          //           ->where('mission_id', $topic->id)
          //           ->where('mission_table', 'mission_topics')
          //           ->where('is_handle', 0)
          //           ->count();

          //   if ($check > 0) {      
          //     $string .=  '<a data-name="'.$topic->mission_name.'" data-id="'.$topic->id.'" data-tooltip="tooltip" title="Xác nhận tính hợp lệ" class="btn btn-info btn-xs submit-valid"><i class="fa fa-check-circle-o"></i></a>';
          //   } 
          // }
          
          if (!$topic->is_denied && !$topic->is_judged && Entrust::can(['judged-doc','denied-doc'])) {
            // $check = CouncilMissionTopic::where('mission_id', $topic->id)->count();

            // $data['mission_id'] = $topic->id;
            // $data['mission']  = 'App\Models\CouncilMissionTopic';
            // $data['table_name'] = 'mission_topics';
            // $check_3  = AdminMission::checkEvaluationDone($data);

            // if ($check == 1) {
              $string .=  '<a data-name="'.$topic->mission_name.'" data-id="'.$topic->id.'" data-tooltip="tooltip" title="Xác nhận được đánh giá" class="btn btn-violet btn-xs submit-judged"><i class="fa fa-check-square-o"></i></a>';
            // }
            
          }   

          // if ($topic->is_judged && $topic->is_valid && !$topic->is_denied && !$topic->is_performed && !$topic->is_unperformed && Entrust::can(['approve-doc','unapprove-doc'])) {
          // $string .=  '<a data-name="'.$topic->mission_name.'" data-id="'.$topic->id.'" data-toggle="modal" href="#approve-mdl" data-tooltip="tooltip" title="Xác nhận được phê duyệt" class="btn btn-blue btn-xs approve-btn"><i class="fa fa-check-square"></i></a>';
          // }

          return $string;
        })
        ->make(true);
    }

    public function getSubmitHardList(Request $request)
    {
        $topics = MissionTopic::select('mission_topics.*', 'profiles.organization_id')
                ->where('mission_topics.is_submit_ele_copy',1)
                ->join('profiles', 'mission_topics.profile_id', '=', 'profiles.id')
                ->join('organizations', 'organizations.id', '=', 'profiles.organization_id')
                ->join('user_handle_files', 'mission_topics.id', '=', 'user_handle_files.mission_id')
                ->where('mission_table', 'mission_topics')
                ->where('user_id', Auth::guard('web')->user()->id)
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

          $attr_id = MissionTopicAttribute::where('column','name')->first()->id;

          foreach ($topic->values as $value) {
            if ($value->mission_topic_attribute_id == $attr_id) {
              if (strlen($value->value) > 300) {
                  $topic['mission_name'] = "<span data-placement='left' data-tooltip='tooltip' title='".$value->value."'>".mb_substr($value->value, 0, 300)."..."."</span>";
              } else {
                  $topic['mission_name'] = $value->value;
              }
            }
          }

          $attr_time_result_requirement_id = MissionTopicAttribute::where('column','time_result_requirement')->first()->id;

          foreach ($topic->values as $value) {
            if ($value->mission_topic_attribute_id == $attr_time_result_requirement_id) {
              if (strlen($value->value) > 300) {
                  $topic['time_result_requirement'] = "<span data-placement='left' data-tooltip='tooltip' title='".$value->value."'>".mb_substr($value->value, 0, 300)."..."."</span>";
              } else {
                  $topic['time_result_requirement'] = $value->value;
              }
            }
          }

          $attr_target_id = MissionTopicAttribute::where('column','target')->first()->id;

          foreach ($topic->values as $value) {
            if ($value->mission_topic_attribute_id == $attr_target_id) {
              if (strlen($value->value) > 300) {
                  $topic['target'] = "<span data-placement='left' data-tooltip='tooltip' title='".$value->value."'>".mb_substr($value->value, 0, 300)."..."."</span>";
              } else {
                  $topic['target'] = $value->value;
              }
            }
          }

          $attr_result_target_requirement_id = MissionTopicAttribute::where('column','result_target_requirement')->first()->id;

          foreach ($topic->values as $value) {

            if ($value->mission_topic_attribute_id == $attr_result_target_requirement_id) {

              if (strlen($value->value) > 300) {
                  $topic['result_target_requirement'] = "<span data-placement='left' data-tooltip='tooltip' title='".$value->value."'>".mb_substr($value->value, 0, 300)."..."."</span>";
              } else {
                  $topic['result_target_requirement'] = $value->value;
              }
            }
          }

          $attr_expected_fund_id = MissionTopicAttribute::where('column','expected_fund')->first()->id;

          foreach ($topic->values as $value) {
            if ($value->mission_topic_attribute_id == $attr_expected_fund_id) {
              
              $topic['expected_fund'] = $value->value;
              
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
        ->editColumn('values', function(MissionTopic $topic) {

          if (!empty($topic->mission_name)) {
            return $topic->mission_name;
          }

        })
        ->addColumn('status', function(MissionTopic $topic) {

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
                    return "<label class='label label-info'>Hồ sơ hợp lệ</label>";
                  }
                  elseif($topic->is_judged == 1) {
                    if ($topic->is_performed == 0 && $topic->is_unperformed == 0) {
                      return "<label class='label label-info'>Hồ sơ được đưa vào HĐ đánh giá</label>"; 
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
        
        // ->addColumn('profile', function(MissionTopic $topic){                    
        //   $profile = Profile::find($topic->profile_id);
        //   return $profile->representative . '-' . $profile->mobile;
        // })

        // ->editColumn('organization', function(MissionTopic $topic) {

        //   $organization = Organization::find($topic->organization_id);

        //   return !is_null($organization) ? $organization->name : null;
        // })

        ->addColumn('request_time',function(MissionTopic $topic) {
          return $topic->time_result_requirement;
        })

        ->addColumn('target', function(MissionTopic $topic) {
          return $topic->target;
        })
        ->addColumn('request_result', function(MissionTopic $topic) {
          return $topic->result_target_requirement;
        })
        ->addColumn('expected_fund', function(MissionTopic $topic) {
          return number_format(Crypt::decrypt($topic->expected_fund)) . " VNĐ";
        })
        ->addColumn('action', function(MissionTopic $topic) {

          $string = "";

          if (Entrust::can('view-detail')) {

            $string .=  "<a data-tooltip='tooltip' title='Xem chi tiết' class='btn btn-success btn-xs' target='_blank' href='".route('admin.mission-topics.detail',$topic->key)."'><i class='fa fa-eye'></i></a>";
          }

          if ($topic->is_assign && Entrust::can(['valid-doc','invalid-doc']) && !$topic->is_valid && !$topic->is_invalid ) {

            $check = UserHandleFile::where('user_id', Auth::guard('web')->user()->id)
                    ->where('mission_id', $topic->id)
                    ->where('mission_table', 'mission_topics')
                    ->where('is_handle', 0)
                    ->count();

            if ($check > 0) {      
              $string .=  '<a data-name="'.$topic->mission_name.'" data-id="'.$topic->id.'" data-tooltip="tooltip" title="Xác nhận tính hợp lệ" class="btn btn-info btn-xs submit-valid"><i class="fa fa-check-circle-o"></i></a>';
            } 
          }
      

          if ($topic->is_judged && $topic->is_valid && !$topic->is_denied && !$topic->is_performed && !$topic->is_unperformed && Entrust::can(['approve-doc','unapprove-doc'])) {
          $string .=  '<a data-name="'.$topic->mission_name.'" data-id="'.$topic->id.'" data-toggle="modal" href="#approve-mdl" data-tooltip="tooltip" title="Xác nhận được phê duyệt" class="btn btn-blue btn-xs approve-btn"><i class="fa fa-check-square"></i></a>';
          }

          return $string;
        })
        ->make(true);
    }

    public function submitHardCopy(Request $request)
    {
        $data = $request->only('id','mission_name');

        $data['table_name'] = 'mission_topics';

        $data['form'] = 'A1';

        $result = AdminMission::submitHardCopy($data);

        return response()->json($result);
    }

    public function approveMission(Request $request)
    {

      $data = $request->only('id','is_performed','is_unperformed_reason','approve_type','is_send_email', 'mission_name');

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
      $data = $request->only('status', 'checkbox', 'reason', 'id', 'mission_name');

      $data['table_name'] = 'mission_topics';
      $data['form'] = 'A1';

      $result = AdminMission::submitValid($data);

      return response()->json($result);
    }

    public function submitJudged(Request $request){
      $data = $request->only('status', 'checkbox', 'reason', 'id', 'mission_name');

      if ($request->hasFile('attachment_file_judged')) {
        
        $data['attachment_file_judged'] = $request->file('attachment_file_judged');
      }

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
      ->addColumn('action', function($council) {

        return "<a data-tooltip='tooltip' data-toggle='modal' title='Xem thành viên' id='viewListMember' class='btn btn-success btn-xs' href='#listMemberCouncil' data-id='".$council->id."'><i class='fa fa-eye'></i></a>";
      })

      ->addColumn('choose', function($council) use ($mission) {

        return '<input type="radio" name="council_id" id="council_id" value="'.$council->id.'">';
      })
      ->make(true);
    }
  }

  public function addCouncil(Request $request) {

    $data['council_id'] =  $request->get('council_id');

    $data['mission_id'] =  $request->get('mission_topic_id');
    
    $data['group_council_id'] = $request->get('group_council_id');

    $data['mission_council']  = 'App\Models\CouncilMissionTopic';

    $result = AdminMission::addCouncil($data);

    return response()->json($result);

  }


  public function judgeCouncilView($key)
  {
    $topic = MissionTopic::where('key', $key)->first();

    if (!empty($topic)) {
      
      $name = $topic->values()->where('mission_topic_attribute_id',1)->first()->value;

      if ($topic->type) {
        $view = "judge-b2";
      } else {
        $view = "judge-b1";
      }
    } 

    $comment_evaluation = '';
    $expert_opinions = '';

    if (!empty($topic->evaluationForm()->where('user_id',Auth::guard('web')->user()->id)->first())) {
        
        $data = $topic->evaluationForm()->where('user_id',Auth::guard('web')->user()->id)->first()->content;

      $comment_evaluation = $data['comment_evaluation'];

      $expert_opinions = $data['expert_opinions'];
    }

    $date = array();

    $date['d'] = date('d',time());
    $date['m'] = date('m',time());
    $date['y'] = date('Y',time());

    return view('backend.admins.mission_topics.'.$view, compact('name','date','topic','comment_evaluation','expert_opinions'));
  }

  public function judgeCouncilDetail($key)
  {
    $topic = MissionTopic::where('key', $key)->first();

    if (!empty($topic)) {
      
      $name = $topic->values()->where('mission_topic_attribute_id',1)->first()->value;

      if ($topic->type) {
        $view = "judge-b2-detail";
      } else {
        $view = "judge-b1-detail";
      }
    } 

    $comment_evaluation = '';
    $expert_opinions = '';

    if (!empty($topic->evaluationForm()->where('user_id',Auth::guard('web')->user()->id)->first())) {
        
        $data = $topic->evaluationForm()->where('user_id',Auth::guard('web')->user()->id)->first()->content;

      $comment_evaluation = $data['comment_evaluation'];

      $expert_opinions = $data['expert_opinions'];
    }

    $date = array();

    $key= $topic->key;
    $date['d'] = date('d',time());
    $date['m'] = date('m',time());
    $date['y'] = date('Y',time());

    return view('backend.admins.mission_topics.'.$view, compact('name','date','topic','comment_evaluation','expert_opinions', 'key'));
  }

  public function judgeCouncilPrint($key)
  {

    $topic = MissionTopic::where('key', $key)->first();

    if (!empty($topic)) {
      
      $name = $topic->values()->where('mission_topic_attribute_id',1)->first()->value;

      if ($topic->type) {
        $view = "judge-b2-print";
      } else {
        $view = "judge-b1-print";
      }
    } 

    $comment_evaluation = '';
    $expert_opinions = '';

    if (!empty($topic->evaluationForm()->where('user_id',Auth::guard('web')->user()->id)->first())) {
        
        $data = $topic->evaluationForm()->where('user_id',Auth::guard('web')->user()->id)->first()->content;

      $comment_evaluation = $data['comment_evaluation'];

      $expert_opinions = $data['expert_opinions'];
    }

    $date = array();

    $date['d'] = date('d',time());
    $date['m'] = date('m',time());
    $date['y'] = date('Y',time());

    return view('backend.admins.mission_topics.'.$view, compact('name','date','topic','comment_evaluation','expert_opinions', 'key'));
  }


  public function judgeCouncilStore(Request $request)
  {
    $type = MissionTopic::find($request->id)->type;

    if ($type) {

      $data = $request->only('id','necessity_note','afftect_note','necessary_note','perform_name','perform_target','perform_result','necessity_qualified','afftect_qualified','necessary_qualified','is_perform', 'is_filled');
    } else {

      $data = $request->only('id','necessity_note','important_note','unique_note','natinal_resources_note','fund_note','perform_name','perform_target','perform_result','necessity_qualified','important_qualified','unique_qualified','natinal_resources_qualified','fund_qualified','is_perform', 'is_filled');
    }

    $is_unperform = "0";

    $is_perform_with_cond = "0";

    if ($data['is_perform'] == 0) {

      $is_unperform = 1;

    } else if ($data['is_perform'] == 2) {

      $data['is_perform'] = "0";

      $is_perform_with_cond = [
        'perform_name'  => $data['perform_name'],
        'perform_target'  => $data['perform_target'],
        'perform_result'  => $data['perform_result'],
      ];
    }
    $dataStore = [
      'mission_id'  => $data['id'],
      'user_id'     => Auth::guard('web')->user()->id,
      'table_name'  => 'mission_topics',
    ];

    if ($type) {
      $dataStore['content'] = [
      'comment_evaluation'  => [
        'necessity' => [
          'note'  => $data['necessity_note'],
          'qualified'  => $data['necessity_qualified'],
        ],
        'afftect' => [
          'note'  => $data['afftect_note'],
          'qualified'  => $data['afftect_qualified'],
        ],
        'necessary' => [
          'note'  => $data['necessary_note'],
          'qualified'  => $data['necessary_qualified'],
        ],
      ],
      'expert_opinions' => [
        'is_perform'  => $data['is_perform'],
        'is_unperform'  => $is_unperform,
        'is_perform_with_cond'  => $is_perform_with_cond,
      ]
    ];
    } else {
      $dataStore['content'] = [
      'comment_evaluation'  => [
        'necessity' => [
          'note'  => $data['necessity_note'],
          'qualified'  => $data['necessity_qualified'],
        ],
        'important' => [
          'note'  => $data['important_note'],
          'qualified'  => $data['important_qualified'],
        ],
        'unique' => [
          'note'  => $data['unique_note'],
          'qualified'  => $data['unique_qualified'],
        ],
        'natinal_resources' => [
          'note'  => $data['natinal_resources_note'],
          'qualified'  => $data['natinal_resources_qualified'],
        ],
        'fund' => [
          'note'  => $data['fund_note'],
          'qualified'  => $data['fund_qualified'],
        ],
      ],
      'expert_opinions' => [
        'is_perform'  => $data['is_perform'],
        'is_unperform'  => $is_unperform,
        'is_perform_with_cond'  => $is_perform_with_cond,
      ]
    ];
    }

    $dataStore['is_filled'] = $data['is_filled'];

    $result = AdminMission::evaluationDoc($dataStore);

    return response()->json($result);
  }

  public function giveBackHardCopy(Request $request) {
    $data = $request->only('id');
    $data['mission_table']  = 'mission_topics';
    $data['model'] = 'App\Models\MissionTopic';
    $result = AdminMission::giveBackHardCopy($data);

    return $result;
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
    return view('backend.admins.evaluation.mission_topics.index');
  }

  public function getListEvaluation(Request $request)
    {
        $topics = MissionTopic::select('mission_topics.*', 'profiles.organization_id')
                ->where('mission_topics.is_submit_ele_copy',1)
                ->join('profiles', 'mission_topics.profile_id', '=', 'profiles.id')
                // ->join('organizations', 'organizations.id', '=', 'profiles.organization_id')
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

          $attr_id = MissionTopicAttribute::where('column','name')->first()->id;

          foreach ($topic->values as $value) {
            if ($value->mission_topic_attribute_id == $attr_id) {
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
        ->editColumn('values', function(MissionTopic $topic) {

          if (!empty($topic->mission_name)) {
            return $topic->mission_name;
          }

        })
        ->addColumn('status', function(MissionTopic $topic) {

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
        
        ->editColumn('roundCollection', function(MissionTopic $topic) {

          $str = "";
          if (!empty($topic->roundCollection)) {
            $str = $topic->roundCollection->name." - ".$topic->roundCollection->year;
          } else {
            $str = "Chưa cập nhập";
          }

          return $str;
        })
        ->editColumn('profile', function(MissionTopic $topic) {

          $organization = Organization::find($topic->organization_id);
          return !is_null($organization) ? $organization->name : null;

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

          $is_filled = false;
          $evaluation_form = EvaluationForm::where('user_id', Auth::user()->id)
                    ->where('mission_id', $topic->id)
                    ->where('table_name', 'mission_topics')->orderBy('id', 'Desc')->get(); 

          if ($evaluation_form->count() > 0) {
            $evaluation_form = $evaluation_form->first();
            if ($evaluation_form->is_filled == 1) {
              $is_filled = true;
            }
          }

          if ($flag_1 && $flag_2 && $is_filled == false && Entrust::can('evaluation-doc') && $topic->is_judged == 1 && $topic->is_valid == 1) {
            $string .=  "<a target='_blank' data-id='".$topic->id."' href='".route('admin.mission-topics.judged', $topic->key)."' data-tooltip='tooltip' title='Đánh giá hồ sơ' class='btn btn-primary btn-xs'><i class='fa fa-comments-o' aria-hidden='true'></i></a>";
          }
          
          if ($flag_1 && $flag_2 && $is_filled && Entrust::can('view-evaluation-doc') && $topic->is_judged == 1 && $topic->is_valid == 1) {
            $string .= "<a target='_blank' data-id='".$topic->id."' href='".route('admin.mission-topics.judged-detail', $topic->key)."' data-tooltip='tooltip' title='Xem phiếu đánh giá' class='btn btn-warning btn-xs'><i class='fa fa-info-circle' aria-hidden='true'></i></a>";
          }

          // $flag = $topic->judgeCouncil->first();

          // if (!empty($flag)) {
          //     if ($flag->getJudgeCouncilMembers(Auth::guard('web')->user()->id)->count() > 0 && Entrust::can('evaluation-doc')) {
          //       $string .=  "<a target='_blank' data-id='".$topic->id."' href='".route('admin.mission-topics.judged', $topic->key)."' data-tooltip='tooltip' title='Đánh giá hồ sơ' class='btn btn-primary btn-xs'><i class='fa fa-comments-o' aria-hidden='true'></i></a>";
          //     }
          // }

          return $string;
        })
        ->make(true);
    }

    public function exportExcelGetData()
    {
      $topics = MissionTopic::select('mission_topics.id','mission_topics.profile_id', 'profiles.organization_id','profiles.representative','profiles.mobile')
              ->where('mission_topics.is_submit_ele_copy',1)
              ->join('profiles', 'mission_topics.profile_id', '=', 'profiles.id')
              // ->join('organizations', 'organizations.id', '=', 'profiles.organization_id')
              ->orderBy('id','desc')->get();

      $attributes = MissionTopicAttribute::select('id','label','column')->where('status',1)->whereNotIn('id',[10,11])->get();

      foreach ($topics as $key => $topic) {

        $organization = Organization::find($topic->organization_id);
        
        $topic->organization = !is_null($organization) ? $organization->name : null;

        $topic->register = $topic->representative . " - " . $topic->mobile;

        foreach ($attributes as $attribute) {
          foreach ($topic->values as $value) {
            if ($attribute->id == $value->mission_topic_attribute_id) {
              if ($attribute->column == 'expected_fund' && !empty($value->value)) {
                $topic[$attribute->column] = number_format(Crypt::decrypt($value->value)) . " VNĐ";
              } else {
                $topic[$attribute->column] = $value->value;
              }
            }
          }
        }
      }
      
      $now = date('Ymd_Hi', strtotime(now()));

      $properties['filename'] = "2075_Natec_ĐTĐA_$now";

      $properties['view'] = 'mission_topics';

      $properties['sheet'] = 'Đề tài hoặc đề án';

      $properties['lastRow'] = $topics->count() + 1;

      $properties['lastColumn'] = chr(ord('A') + $attributes->count() + 2);

      $export = ExportExcel::exportExcel($topics, $attributes, $properties);

      return true;
    }
}
