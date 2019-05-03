<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpProduct extends Model
{
    protected $table='sp_products';

    protected $fillable=['product_id','harvest_date','expiration_date','harvest_date'];
}
