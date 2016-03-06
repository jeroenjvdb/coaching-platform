<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    /**
     * the database table of the model
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'message'
    ];

    /**
     * sender of the message
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
