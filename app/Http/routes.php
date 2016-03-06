<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/test', function(){
    	echo 'test';
    });
});



Route::group(['middleware' => 'auth'], function(){

});


Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::group(['middleware' => 'auth'], function()
    {
		Route::post('fire', ['uses' => 'ChatController@fire']);

		Route::get('/', ['uses' => 'ChatController@index']);
		Route::get('chat', ['as' => 'chat', 'uses' => 'ChatController@chat']);
    	Route::group(['prefix' => 'zwemmer'], function()
    	{
    		Route::get('/', 		['as' => 'swimmers.index', 	'uses' => 'SwimmerController@index']);
    		Route::get('/create', 	['as' => 'swimmers.create', 'uses' => 'SwimmerController@create']);
    		Route::post('/', 		['as' => 'swimmers.store', 	'uses' => 'SwimmerController@store']);
    		Route::get('/{id}', 	['as' => 'swimmers.show', 	'uses' => 'SwimmerController@show']);

    	});

		Route::group(['prefix' => 'groep'],function()
		{
			Route::get('/', 			['as' => 'groups.index', 	'uses' => 'GroupController@index']);
			Route::get('/create', 		['as' => 'groups.create', 	'uses' => 'GroupController@create']);
			Route::post('/', 			['as' => 'groups.store', 	'uses' => 'GroupController@store']);
			Route::get('/{id}', 		['as' => 'groups.show', 	'uses' => 'GroupController@show']);
			Route::get('/{id}/edit',	['as' => 'groups.edit', 	'uses' => 'GroupController@edit']);
			Route::post('/{id}', 		['as' => 'groups.update', 	'uses' => 'GroupController@update']);
			Route::get('/{id}/destroy', ['as' => 'groups.destroy', 	'uses' => 'GroupController@destroy']);
		});

		Route::resource('coach', 'CoachController');


	    Route::get('/home', 'HomeController@index');
	    Route::get('/jeroen', ['as' => 'swimmer.jeroen', 'uses' => 'SwimmerController@jeroen']);
	    Route::get('/philippe', ['as' => 'swimmer.philippe', 'uses' => 'SwimmerController@philippe']);
    });
});
