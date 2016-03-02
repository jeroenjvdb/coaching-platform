<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = [

    ];

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
        return $this->hasMany('App\Group');
    }
}
