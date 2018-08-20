<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionScienceTechnologyAttribute extends Model
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
  protected $table="mission_science_technology_attributes";

  protected $fillable = [
      'mission_science_technology_id','tag_input_id','label','column','status','order', 'parent_attribute_id'
  ];
}
