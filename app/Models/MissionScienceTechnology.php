<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionScienceTechnology extends Model
{
  use SoftDeletes;

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
   protected $dates = ['deleted_at'];
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $table="mission_science_technologies";

  protected $fillable = [
    'status','checked_status','process_status','time_submit_ele_copy','time_submit_hard_copy','report_time_submit_ele','report_time_submit_hard','profile_id', 'key', 'code', 'round_collection_id', 'is_filled', 'is_submit_ele_copy', 'is_submit_hard_copy', 'order_submit_hard_copy',
    'is_assign', 'is_valid', 'is_invalid', 'is_judged', 'is_denied', 'is_invalid_reason', 'is_denied_reason', 'is_performed', 'is_unperformed','approve_type','is_unperformed_reason','list_categories', 'attachment_file_judged'
  ];

  public function values()
  {
    return $this->belongsToMany('App\Models\MissionScienceTechnologyAttributeValue','mission_science_technology_values','mission_science_technology_id','mission_science_technology_attribute_value_id');
  }

  public static function getStatusMission($mission){
    $str = '';

    $str = $mission->is_filled == 0 ? '<span class="label label-default">Hồ sơ mới tạo</span>' : '<span class="label label-success">Đã nhập đủ thông tin</span>';

    $str = $mission->is_submit_ele_copy == 0 ? $str : '<span class="label label-success">Đã nộp bản mềm</span>';

    $str = $mission->is_submit_hard_copy == 0 ? $str : '<span class="label label-success">Đã nộp bản cứng</span>';

    $str = $mission->is_assign == 0 ? $str : '<span class="label label-success">Đã được giao</span>';

    $str = $mission->is_valid == 0 ? $str : '<span class="label label-success">Hồ sơ hợp lệ</span>';

    $str = $mission->is_invalid == 0 ? $str : '<span class="label label-danger">Hồ sơ không hợp lệ</span>';

    $str = $mission->is_judged == 0 ? $str : '<span class="label label-success">Hồ sơ được đánh giá</span>';

    $str = $mission->is_denied == 0 ? $str : '<span class="label label-danger">Hồ sơ không hợp lệ</span>';

    $str = $mission->is_performed == 0 ? $str : '<span class="label label-success">Hồ sơ đã được thực hiện</span>';

    $str = $mission->is_unperformed == 0 ? $str : '<span class="label label-danger">Hồ sơ không được thực hiện</span>';

    return $str;
  }

  public function roundCollection()
  {
    return $this->belongsTo('App\Models\RoundCollection','round_collection_id');
  }
  public function profile()
  {
    return $this->belongsTo('App\Models\Profile','profile_id');
  }

  public function council () {
    return $this->belongsToMany('App\Models\Council', 'council_mission_science_technologies', 'mission_id', 'council_id');
  }

  public function groupCouncil () {
    return $this->belongsToMany('App\Models\GroupCouncil', 'council_mission_science_technologies', 'mission_id', 'group_council_id');
  }

  public function judgeCouncil()
  {

      return $this->belongsToMany('App\Models\Council','council_mission_science_technologies','mission_id','council_id')->wherePivot('group_council_id', 1);
  }
}
