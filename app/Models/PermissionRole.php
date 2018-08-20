<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table="permission_roles";

    // protected $primaryKey = ['permission_id', 'role_id'];

    protected $fillable = [
        'permission_id', 'role_id',
    ];
}
