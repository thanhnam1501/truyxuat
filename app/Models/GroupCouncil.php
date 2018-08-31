<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupCouncil extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table="group_councils";

    protected $fillable = [
    	'name','status', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}
