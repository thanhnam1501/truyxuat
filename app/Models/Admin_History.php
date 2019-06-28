<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin_History extends Model
{
    use SoftDeletes;
   protected $table="admin_histories";

      protected $fillable = [
        'user_id', 'content'
    ];
}
