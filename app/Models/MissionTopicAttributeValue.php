<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionTopicAttributeValue extends Model
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
  protected $table="mission_topic_attribute_values";

  protected $fillable = [
      'mission_topic_attribute_id','value'
  ];
}
