<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{
    protected $table = 'distances';

    protected $fillable = [
        'distance'
    ];

    public $timestamps = false;


}
