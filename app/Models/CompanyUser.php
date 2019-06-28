<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyUser extends Model
{

    protected $table = 'company_users';
    protected $fillable = ['user_id', 'company_id'];
}
