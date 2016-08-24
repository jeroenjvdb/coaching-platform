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

    public function coaches()
    {
        return $this->hasMany('App\Coach');
    }
    
    public function coach()
    {
        return $this->hasOne('App\Coach');
    }

    public function chats()
    {
        return $this->belongsToMany('App\Chat', 'chat_users');
    }


    public function setPasswordAttribute($password){
        $this->attributes['password'] = bcrypt($password);
    }

    public function getGroup()
    {
        $group = null;

        if ($this->getMeta('swimmer_id')) {
            $is_swimmer = true;
            $mySwimmer = Swimmer::find($this->getMeta('swimmer_id'));
            $groups = $mySwimmer->group;
//            $groups = $this->group->where('id', $user->getMeta('swimmer_id'))->get();
            $group = $groups->first();
        }

        if ($this->coach) {
            $groups = $this->coach->groups;
            $group = $groups->first();
            if($this->getMeta('group')) {
                $id = intval($this->getMeta('group'));
                if($groups->where('id', $id)->count()) {
                    $group = $groups->where('id', $id)->first();
                }
            }
        }

//        if($group )

        return $group;
    }
}
