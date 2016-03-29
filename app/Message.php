<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    /**
     * the table this model is associated with
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
        'message',
        'chat_id',
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

    /**
     * the chat where this message was posted
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chat()
    {
        return $this->belongsTo('App\Chat');
    }
}
