<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoundCollection extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'year', 'status'
    ];

    protected $table="round_collections";
}
