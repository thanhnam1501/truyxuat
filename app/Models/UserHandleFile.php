<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHandleFile extends Model
{
    protected $table = 'user_handle_files';

    protected $fillable = ['admin_id', 'user_id', 'mission_table', 'status', 'is_handle', 'deadline', 'note', 'mission_id'];

    protected $dates = ['deleted_at'];
}
