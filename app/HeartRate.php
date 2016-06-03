<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeartRate extends Model
{
    protected $table = "heart_rates";

    public $timestamps = true;

    protected $fillable = [
        'heart_rate',
    ];

    public function swimmer()
    {
        return $this->belongsTo('App\Swimmer');
    }
}
