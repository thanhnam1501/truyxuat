<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionFile extends Model
{
    protected $table = 'mission_files';
    protected $fillable =['table_name', 'mission_id', 'profile_id', 'mission_attribute_id', 'path'];
}
