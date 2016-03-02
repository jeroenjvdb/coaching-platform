<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Swimmer extends Model
{
	/**
	 * the table associated with the model
	 *
	 * @var string
	 */
    protected $table = 'swimmers';

	/**
	 * the attributes that are mass assignable
	 *
	 * @var array
	 */
    protected $fillable = [
    	'name',
    	'profile_id',
    ];

	/**
	 * the dates
	 *
	 * @var array
	 */
    protected $dates = [
    	'date_of_birth',
    	'created_at',
    	'updated_at',
    	'deleted_at',
    ];

	public function group()
	{
		return $this->belongsTo('App\Group');
	}


}
