<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stopwatch extends Model
{
    protected $table = 'stopwatches';

    protected $fillable = [
        'is_running',
    ];

    protected $casts = [
        'is_running' => 'boolean',
    ];

    public function distance()
    {
        return $this->belongsTo('App\Distance');
    }

    public function swimmer()
    {
        return $this->belongsTo('App\Swimmer');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function times()
    {
        return $this->hasMany('App\StopwatchTime');
    }
}
