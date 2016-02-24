<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Swimmer extends Model
{
    protected $table = 'swimmers';

    protected $fillable = [
    	'name',
    	'date_of_birth',
    ];

    protected $dates = [
    	'date_of_birth',
    	'created_at',
    	'updated_at',
    	'deleted_at',
    ];


}
