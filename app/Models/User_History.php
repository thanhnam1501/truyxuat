<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_History extends Model
{
    use SoftDeletes;

    protected $table="user_histories";

      protected $fillable = [
        'user_id', 'company_id', 'content'
    ];
}
