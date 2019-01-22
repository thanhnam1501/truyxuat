<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
   protected $table = "process";

     protected $fillable = [
        'name', 'product_id','content','status','user_id','time'
    ];
}
