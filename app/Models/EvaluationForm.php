<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationForm extends Model
{
    protected $table = 'evaluation_form';
    protected $fillable = ['user_id', 'mission_id', 'content', 'table_name'];
    protected $casts = [
        'content' => 'array',
    ];
}
