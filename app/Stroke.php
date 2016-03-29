<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stroke extends Model
{
    /**
     * the table associated with the model
     *
     * @var string
     */
    protected $table = 'strokes';

    /**
     * the attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * presence of timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * the distances of the exercises
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function distances()
    {
        return $this->hasMany('App\Distance');
    }
}
