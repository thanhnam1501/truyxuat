<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
	use SoftDeletes;

	protected $table = 'organizations';

	protected $dates = ['deleted_at'];

	protected $fillable = [
		'name', 'tax_code', 'address', 'mobile_phone', 'fax', 'account_number',
		'bank_name', 'email_company', 'image', 'representator', 'status', 
		'position_representator', 'mobile_representator'
	];
}
