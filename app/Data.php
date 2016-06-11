<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $table = "data";

    protected $fillable = [
        'text',
        'media_type',
        'media_url',
        'user_id',
        'is_reaction',
    ];

    public $timestamps = true;

    public function swimmer()
    {
        return $this->belongsTo('App\Swimmer');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
