<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionSxtnAttribute extends Model
{
    use SoftDeletes;

    protected $date = ['deleted_at'];

    protected $table = 'mission_sxtn_attributes';

    protected $fillable = ['mission_sxtn_id','label','column', 'order', 'tag_input_id', 'status'];
}
