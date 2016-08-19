<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Phoenix\EloquentMeta\MetaTrait;


class Coach extends Model
{
    use MetaTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coaches';

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
//        'user_id',
    ];

    public $timestamps = false;

    /**
     * get the user associated with the coach
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * get all the groups from this coach
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }

}
