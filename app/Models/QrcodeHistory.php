<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrcodeHistory extends Model
{
     protected $table = "qrcode_histories";
   // protected $guard = 'profile';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','company_id', 'stt', 'time_scans',
    ];

       public function company() {
        return $this->belongsTo(Company::class);
    }
}
