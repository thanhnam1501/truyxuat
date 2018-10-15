<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ProfileResetPasswordNotification;

class Profile extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = "profiles";
   // protected $guard = 'profile';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar','type','status', 'verification_code', 'company_id','representative','mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token){
        $this->notify(new ProfileResetPasswordNotification($token));
    }
  
    public function organization()
    {
      return $this->belongsTo('App\Models\Organization','organization_id');
    }
}
