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

Route::bind('group', function($slug){
    return App\Group::where('slug', $slug)->firstOrFail();
});

Route::bind('swimmer', function($slug){
    return App\Swimmer::where('slug', $slug)->first();
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
    Route::get('/test', function () {
        $redis = app()->make('redis');
        $redis->set('key1', 'test');
        return $redis->get('key1');
    });
});


Route::group(['middleware' => 'auth'], function () {

});


Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::group(['middleware' => 'auth'], function () {
        Route::group(['prefix' => 'chat'], function () {
            Route::get('/', ['as' => 'chat.index', 'uses' => 'ChatController@index']);
            //Route::get('chat', ['as' => 'chat', 'uses' => 'ChatController@chat']);
            Route::post('/fire', ['as' => 'chat.fire', 'uses' => 'ChatController@fire']);
            Route::get('/{name}', ['as' => 'chat.show', 'uses' => 'ChatController@show']);
        });

        Route::group(['prefix' => 'groep'], function () {
            Route::get('/', ['as' => 'groups.index', 'uses' => 'GroupController@index']);
            Route::get('/create', ['as' => 'groups.create', 'uses' => 'GroupController@create']);
            Route::post('/', ['as' => 'groups.store', 'uses' => 'GroupController@store']);
            Route::get('/{id}', ['as' => 'groups.show', 'uses' => 'GroupController@show']);
            Route::get('/{id}/edit', ['as' => 'groups.edit', 'uses' => 'GroupController@edit']);
            Route::post('/{id}', ['as' => 'groups.update', 'uses' => 'GroupController@update']);
            Route::get('/{id}/destroy', ['as' => 'groups.destroy', 'uses' => 'GroupController@destroy']);
        });

        Route::resource('coach', 'CoachController');


        Route::group(['prefix' => '{group}'], function () {

            Route::group(['prefix' => 'zwemmer'], function () {
                Route::get('/', ['as' => 'swimmers.index', 'uses' => 'SwimmerController@index']);
                Route::get('/create', ['as' => 'swimmers.create', 'uses' => 'SwimmerController@create']);
                Route::post('/', ['as' => 'swimmers.store', 'uses' => 'SwimmerController@store']);
                Route::get('/{swimmer}', ['as' => 'swimmers.show', 'uses' => 'SwimmerController@show']);
                Route::get('/{swimmer}/edit', ['as' => 'swimmers.edit', 'uses' => 'SwimmerController@edit']);
                Route::post('/{swimmer}', ['as' => 'swimmers.update', 'uses' => 'SwimmerController@update']);


            });

            Route::group(['prefix' => 'training'], function () {
                Route::get('/', ['as' => 'trainings.index', 'uses' => 'TrainingController@index']);
                Route::get('/create', ['as' => 'trainings.create', 'uses' => 'TrainingController@create']);
                Route::post('/', ['as' => 'trainings.store', 'uses' => 'TrainingController@store']);
                Route::get('/{id}', ['as' => 'trainings.show', 'uses' => 'TrainingController@show']);

                Route::post('/{training_id}/exercise/', [
                    'as' => 'exercises.store',
                    'uses' => 'ExerciseController@store'
                ]);

                Route::get('/{training_id}/exercise/{id}', [
                    'as' => 'exercises.edit',
                    'uses' => 'ExerciseController@edit'
                ]);

                Route::post('/{training_id}/exercise/{id}', [
                    'as' => 'exercises.update',
                    'uses' => 'ExerciseController@update'
                ]);

            });
        });


        Route::get('/home', 'HomeController@index');
        Route::get('/jeroen', ['as' => 'swimmer.jeroen', 'uses' => 'SwimmerController@jeroen']);
        Route::get('/philippe', ['as' => 'swimmer.philippe', 'uses' => 'SwimmerController@philippe']);
    });
});
