<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionTopic extends Model
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
    protected $table="mission_topics";

    protected $fillable = [
        'status','checked_status','process_status','time_submit_ele_copy','time_submit_hard_copy','report_time_submit_ele','report_time_submit_hard','profile_id','key','code','is_filled','round_collection_id','type','is_submit_ele_copy', 'is_submit_hard_copy', 'order_submit_hard_copy',
        'is_assign', 'is_valid', 'is_invalid', 'is_judged', 'is_denied', 'is_invalid_reason', 'is_denied_reason', 'is_performed', 'is_unperformed','approve_type','is_unperformed_reason','list_categories',
    ];

    public function values()
    {
      return $this->belongsToMany('App\Models\MissionTopicAttributeValue','mission_topic_values','mission_topic_id','mission_topic_attribute_value_id');
    }

    public function roundCollection()
    {
      return $this->belongsTo('App\Models\RoundCollection','round_collection_id');
    }

    public function profile()
    {
      return $this->belongsTo('App\Models\Profile','profile_id');
    }
}
