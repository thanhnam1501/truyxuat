<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table="roles";

    protected $fillable = [
        'name', 'display_name', 'description',
    ];




    
 // tạo liên kết với bảng role_user qua role_id
    public function users(){
        return $this->belongsToMany('App\Models\User','role_users','role_id', 'user_id');
    }
    // tạo liên kết với bảng permission_user qua role_id
    public function permissions(){
        return $this->belongsToMany('App\Models\Permission','permission_roles','role_id', 'permission_id');
    }

}