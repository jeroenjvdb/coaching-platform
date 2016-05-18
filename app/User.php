<?php

namespace App;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Phoenix\EloquentMeta\MetaTrait;


class User extends Authenticatable
{
    use MetaTrait, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        'first_name',
//        'last_name',
        'name',
        'email',
        'password',
        'clearance_level',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function stopwatches()
    {
        return $this->hasMany('App\Stopwatch');
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }
}
