<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionTopicFile extends Model
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
    protected $table="mission_topic_files";

    protected $fillable = [
        'mission_topic_id','profile_id','name','link','size',
    ];

    public function topic()
    {
      return $this->belongsTo('App\Models\MissionTopic','mission_topic_id');
    }
}
