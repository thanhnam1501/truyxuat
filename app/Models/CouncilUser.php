<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouncilUser extends Model
{
    protected $table = 'council_users';
    protected $fillable = ['user_id', 'council_id', 'position_council_id'];
}
