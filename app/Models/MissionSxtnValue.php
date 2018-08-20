<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionSxtnValue extends Model
{
    use SoftDeletes;

    protected $table = 'mission_sxtn_values';

    protected $date = ['deleted_at'];

    protected $fillable = ['mission_sxtn_id', 'mission_sxtn_attribute_value_id'];
}
