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

    /**
     * the attributes to append to json
     *
     * @var array
     */
    protected $appends = [
        'total',
    ];

    /**
     * the presence of timestamps
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The group this training belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    /**
     * the exercises this training contains
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exercises()
    {
        return $this->hasMany('App\Exercise');
    }

    /**
     * the swimmers this group has
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function swimmers()
    {
        return $this->belongsToMany('App\Swimmer', 'presences');
    }

    /**
     * the total number of meters
     *
     * @return mixed
     */
    public function getTotalAttribute()
    {
        return $this->exercises->sum('total');
    }

    



}
