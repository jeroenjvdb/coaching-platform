<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stroke extends Model
{
    protected $table = 'strokes';

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function distances()
    {
        return $this->hasMany('App\Distance');
    }
}
