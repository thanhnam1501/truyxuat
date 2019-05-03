<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportAmountQrcode extends Model
{
     protected $table = "report_amount_qrcode";
   // protected $guard = 'profile';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'product_id', 'amount', 'name','status','company_id','user_id'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
     public function profile() {
        return $this->belongsTo(Profile::class);
    }
}
