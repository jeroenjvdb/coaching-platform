<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{
    /**
     * the table this model is associated wirh
     *
     * @var string
     */
    protected $table = 'distances';

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'distance'
    ];

    /**
     * the presence of timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    public function stroke()
    {
        return $this->belongsTo('App\Stroke');
    }


}
