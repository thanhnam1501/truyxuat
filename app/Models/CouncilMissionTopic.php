<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouncilMissionTopic extends Model
{
    protected $table = 'council_mission_topics';

    protected $fillable = ['council_id', 'mission_id', 'group_council_id', 'type'];
}
