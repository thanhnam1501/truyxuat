<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionScienceTechnologyValue extends Model
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
  protected $table="mission_science_technology_values";

  protected $fillable = [
      'mission_science_technology_id','mission_science_technology_attribute_value_id',
  ];
}
