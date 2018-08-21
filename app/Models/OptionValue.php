<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionValue extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
     protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table="option_values";

    protected $fillable = [
        'option_id','value','name','note'
    ];

    public function values()
    {
        return $this->belongsTo('App\Models\Option','option_id');
    }
}
