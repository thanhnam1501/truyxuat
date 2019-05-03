<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renewal extends Model
{
    protected $table = "renewals";
   // protected $guard = 'profile';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'company_id', 'time_limit', 'price','content','status','account_limit','product_limit',
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }
}
