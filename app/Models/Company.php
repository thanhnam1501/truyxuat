<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    protected $table = 'companies';
    protected $fillable = ['name', 'address', 'mobile_phone','tax_code','content','acount_number','fax','bank_name','email_company','image','status','account_limit','product_limit','time_limit'];
}
