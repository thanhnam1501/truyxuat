<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Council extends Model
{
	//use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table="councils";

    protected $fillable = [
    	'round_collection_id','name','group_council_id','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
      public function group_council()
    {
      return $this->hasOne('App\Models\GroupCouncil');
    }

    public function getUsers() {
        return $this->belongsToMany('App\Models\User', 'council_users', 'council_id', 'user_id')->orderBy('id', 'DESC');
    }

    public function getJudgeCouncilMembers($user_id)
    {
        return $this->belongsToMany('App\Models\User','council_users','council_id','user_id')
                ->wherePivot('user_id',$user_id);
    }

    public function users() {
        return $this->belongsToMany('App\Models\User', 'council_users', 'council_id', 'user_id')->withPivot('position_council_id');
    }
}
