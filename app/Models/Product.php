<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $fillable = [
        'name', 'company_id','content','sort_content','slug','image','price','status','node','user_id'
    ];

    public function image(){
    	return $this->hasMany(Imageupload::class);
    }
}
