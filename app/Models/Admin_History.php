<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin_History extends Model
{
   protected $table="admin_histories";

      protected $fillable = [
        'user_id', 'content'
    ];
}
