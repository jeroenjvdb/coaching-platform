<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StopwatchTime extends Model
{
    protected $table = 'stopwatch_times';

    protected $fillable = [
        'time',
        'created',
        'is_paused',
    ];

    protected $dates = [
        ];

    protected $casts = [
        'is_paused' => 'boolean',
        'full_time' => 'array',
    ];

    protected $appends = [
        //'time',
        'full_time',
    ];

    public function stopwatch()
    {
        return $this->hasOne('App\Stopwatch');
    }

    public function scopeOrdered($query)
    {
        $query
            ->orderBy('time', 'desc')
            ->orderBy('created_at', 'desc');
    }

    /**
     * make the timeAttribute readable
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFullTimeAttribute()
    {
        $data = collect([]);
        $input = $this->attributes['time'];

        $data->milliseconds = $input % 1000;
        $data->hundredth = $input % 100;
        $input = floor($input / 1000);

        $data->seconds = $input % 60;
        $input = floor($input / 60);

        $data->minutes = $input % 60;
        $input = floor($input / 60);

        $data->hours = $input%24;
        $input = floor($input/24);

        $data->toText = sprintf('%02d', $data->hours) . ':' .
            sprintf('%02d', $data->minutes ) . ':' .
            sprintf('%02d', $data->seconds ) . '.' .
            sprintf('%02d', $data->milliseconds / 10);

        return $data;
    }
}
