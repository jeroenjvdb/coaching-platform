<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    /**
     * the table associated with the model
     *
     * @var string
     */
    protected $table = 'trainings';

    /**
     * the attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'starttime',
    ];

    /**
     * the dates
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'total',
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exercises()
    {
        return $this->hasMany('App\Exercise');
    }


    public function getTotalAttribute()
    {
        return $this->exercises->sum('total');
    }



}
