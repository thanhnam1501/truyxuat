<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PositionCouncil extends Model
{
    protected $table = 'position_councils';
    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'status', 'description'];
}
