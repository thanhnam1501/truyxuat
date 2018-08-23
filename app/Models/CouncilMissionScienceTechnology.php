<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouncilMissionScienceTechnology extends Model
{
    protected $table = 'council_mission_science_technologies';

    protected $fillable = ['council_id', 'mission_id'];
}
