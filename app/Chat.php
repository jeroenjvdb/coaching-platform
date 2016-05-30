<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    /**
     * the table associated with the model
     *
     * @var string
     */
    protected $table = "chats";

    /**
     * the attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * the presence of timestamps
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * the messagesthis chat has
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
