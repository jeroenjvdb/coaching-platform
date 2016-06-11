<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeartRate extends Model
{
    protected $table = "heart_rates";

    public $timestamps = true;

    protected $fillable = [
        'heart_rate',
        'date',
    ];

    protected $appends = [
        'value',
    ];

    public function swimmer()
    {
        return $this->belongsTo('App\Swimmer');
    }

    public function getValueAttribute()
    {
        return $this->heart_rate;
    }
}
