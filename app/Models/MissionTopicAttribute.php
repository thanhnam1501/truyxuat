<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionTopicAttribute extends Model
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
  protected $table="mission_topic_attributes";

  protected $fillable = [
      'tag_input_id','label','column','status','order'
  ];
}
