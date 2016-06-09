<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    protected $table = 'weights';

    protected $fillable = [
        'weight',
        'date',
    ];

    protected $appends = [
        'value',
    ];

    public $timestamps = true;

    public function swimmer()
    {
        return $this->belongsTo('App\Swimmer');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    public function getWeightAttribute($value)
    {
        return $value / 1000;
    }

    public function getValueAttribute()
    {
        return $this->weight;
    }

    public function setWeightAttribute($value)
    {
        $this->attributes['weight'] = $value * 1000;
    }

}
