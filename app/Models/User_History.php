<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_History extends Model
{
    protected $table="user_histories";

      protected $fillable = [
        'user_id', 'company_id', 'content'
    ];
}
