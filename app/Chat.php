<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    /**
     * the table associated with the moddle
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
     * @var bool
     */
    public $timestamps = true;

    public function messages()
    {
        return $this->hasMany('App\Message');
    }
}
