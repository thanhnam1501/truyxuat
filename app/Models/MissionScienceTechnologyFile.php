<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionScienceTechnologyFile extends Model
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
  protected $table="mission_science_technology_files";

  protected $fillable = [
    'mission_science_technology_id','profile_id','name','link','size'
  ];
}
