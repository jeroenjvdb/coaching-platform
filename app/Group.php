<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * the table of the model
     *
     * @var string
     */
    protected $table = 'groups';

    /**
     * the attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * get all the coaches for this group
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function coaches()
    {
        return $this->belongsToMany('App\Coach');
    }

    /**
     * get all the swimmers from this group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function swimmers()
    {
        return $this->hasMany('App\Swimmer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trainings()
    {
        return $this->hasMany('App\Training');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function exercises()
    {
        return $this->hasManyThrough('App\Exercise', 'App\Training');
    }
}
