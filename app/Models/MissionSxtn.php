<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionSxtn extends Model
{
	use SoftDeletes;

	protected $date = ['deleted_at'];

    protected $table = 'mission_sxtns';

    protected $fillable = ['key', 'code', 'status', 'checked_status', 'process_status', 'report_status', 'time_submit_ele_copy', 'time_submit_hard_copy', 'report_time_submit_ele', 'report_time_submit_hard', 'company_id', 'round_collection_id', 'is_filled'];

    public function values()
    {
      return $this->belongsToMany('App\Models\MissionSxtnAttributeValue','mission_sxtn_values','mission_sxtn_id','mission_sxtn_attribute_value_id');
    }

    public static function getStatusMission($mission){
    $str = '';
     if ($mission->status == 0){
         $str = $str . '<span class="label label-default">Hồ sơ mới tạo</span>';
     }
     elseif ($mission->status == 1){
         $str = $str . '<span class="label label-primary">đã nộp bản mềm</span>';
     }
     elseif ($mission->status == 2){
         if ($mission->checked_status == 0){
             $str = $str .'<span class="label label-success">đã nộp bản cứng</span>';
         }
         elseif ($mission->checked_status == 1){
             $str = $str .'<span class="label label-warning">đã giao cho cán bộ xử lý</span>';
         }
         elseif ($mission->checked_status == 2){
               if ($mission->process_status == 0){
                   $str = $str .'<span class="label label-primary">hồ sơ được duyệt</span>';
               }
               elseif ($mission->process_status == 1) {
                   $str = $str .'<span class="label label-warning">đang thực hiện</span>';
               }
               elseif ($mission->process_status == 2){
                   $str = $str .'<span class="label label-danger">dừng thực hiện</span>';
               }
               elseif ($mission->process_status == 3){
                   $str = $str .'<span class="label label-success">đã hoàn thành</span>';
               }
         }
         elseif ($mission->checked_status == 3){
             $str = $str .'<span class="label label-danger">hồ sơ không được duyệt</span>';
         }
       }

       return $str;
  }
  public function roundCollection()
  {
    return $this->belongsTo('App\Models\RoundCollection','round_collection_id');
  }
  
  public function company()
  {
    return $this->belongsTo('App\Models\Company','company_id');
  }
}
