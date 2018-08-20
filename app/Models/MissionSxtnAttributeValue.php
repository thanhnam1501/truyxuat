<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionSxtnAttributeValue extends Model
{
    use SoftDeletes;

    protected $table = 'mission_sxtn_attribute_values';

    protected $date = ['deleted_at'];

    protected $fillable = ['mission_sxtn_attribute_id', 'value'];
}
