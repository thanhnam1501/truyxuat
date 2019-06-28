<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

     protected $fillable = [
        'name', 'company_id','content','sort_content','slug','image','price','status','node','user_id','link_product'
    ];

    public function image(){
    	return $this->hasMany(Imageupload::class);
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
