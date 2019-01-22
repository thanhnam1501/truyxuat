<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
   protected $table = "qr_codes";
   // protected $guard = 'profile';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','company_id','start','end','note','user_id',
    ];

    public static function checkStart($company_id, $start, $type = '') {
        $qrcode = Qrcode::select(\DB::raw('MAX(`end`) as end'))
        ->where('company_id', $company_id)
        ->first();
        if($type != '') {
            if($qrcode && $qrcode->end >= $start) {
                return ($qrcode->end + 1);
            }
            return 1;
        } else {
            if($qrcode && ($qrcode->end+1) != $start) {
                return 'Serial đầu nên bắt đầu từ '.($qrcode->end + 1);
            }
            return '';
        }
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

     public static function decodeSerial($hash_serial) {
        $arr_hash_serial = str_split($hash_serial, 2);
        $salt = self::$salt;
        $serial = '';
        foreach ($arr_hash_serial as $val) {
            $serial .= array_search($val, $salt);
        }
        return (((int) $serial)-27)/13;
    }
}
