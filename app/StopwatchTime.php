<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StopwatchTime extends Model
{
    protected $table = 'stopwatch_times';

    protected $fillable = [
        'time',
    ];

    public function stopwatch()
    {
        return $this->hasOne('App\Stopwatch');
    }

    public function scopeOrdered($query)
    {
        $query->orderBy('time', 'asc');
    }

    /**
     * make the timeAttribute readable
     *
     * @param $value
     * @return \Illuminate\Support\Collection
     */
    public function getTimeAttribute($value)
    {
        $data = collect([]);
        $input = $value;

        $data->milliseconds = $input % 1000;
        $input = floor($input / 1000);

        $data->seconds = $input % 60;
        $input = floor($input / 60);

        $data->minutes = $input % 60;
        $input = floor($input / 60);

        $data->toString = $data->minutes . ':' . sprintf('%02d', $data->seconds ) . '.' . $data->milliseconds;


        return $data;
    }
}
