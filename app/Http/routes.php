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
    Route::get('/test', function() {
        return view('test');
    });
    // Route::get('/test', function () {
    //     $redis = app()->make('redis');
    //     $redis->set('key1', 'test');
    //     return $redis->get('key1');
    // });
});


Route::group(['middleware' => 'auth'], function () {

});


Route::group(['middleware' => 'web'], function () {
    Route::get('test', function(){
        $strokes = App\Stroke::with('distances')->get();

        $data = [
            'strokes' => $strokes,
        ];

        return view('test', $data);
    });
    Route::auth();

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', 'HomeController@index');

        Route::group(['prefix' => 'chat'], function () {
            Route::get('/', ['as' => 'chat.index', 'uses' => 'ChatController@index']);
            //Route::get('chat', ['as' => 'chat', 'uses' => 'ChatController@chat']);
            Route::post('/fire', ['as' => 'chat.fire', 'uses' => 'ChatController@fire']);
            Route::get('/{name}', ['as' => 'chat.show', 'uses' => 'ChatController@show']);
        });



        Route::resource('coach', 'CoachController');


        Route::group(['prefix' => '{group}'], function () {
            //Route::get('/', ['as' => 'groups.index', 'uses' => 'GroupController@index']);
            //Route::get('/create', ['as' => 'groups.create', 'uses' => 'GroupController@create']);
            //Route::post('/', ['as' => 'groups.store', 'uses' => 'GroupController@store']);
            Route::get('/', ['as' => 'groups.show', 'uses' => 'GroupController@show']);
            Route::get('/edit', ['as' => 'groups.edit', 'uses' => 'GroupController@edit']);
            Route::post('/', ['as' => 'groups.update', 'uses' => 'GroupController@update']);
            Route::get('/destroy', ['as' => 'groups.destroy', 'uses' => 'GroupController@destroy']);


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

                Route::get('/{training_id}/download', [
                    'as' => 'training.download',
                    'uses' => 'TrainingController@download',
                ]);

                Route::post('/{training_id}/presences', [
                    'as' => 'presences.store',
                    'uses' => 'PresenceController@store',
                ]);

                Route::post('/{training_id}/exercise/', [
                    'as' => 'exercises.store',
                    'uses' => 'ExerciseController@store',
                ]);

                Route::get('/{training_id}/exercise/{id}', [
                    'as' => 'exercises.edit',
                    'uses' => 'ExerciseController@edit',
                ]);

                Route::post('/{training_id}/exercise/{id}', [
                    'as' => 'exercises.update',
                    'uses' => 'ExerciseController@update',
                ]);
            });

            Route::group(['prefix' => 'stopwatch'], function() {
                Route::get('/', ['as' => 'stopwatches.index', 'uses' => 'StopwatchController@index']);
                Route::get('/create', ['as' => 'stopwatches.create', 'uses' => 'StopwatchController@create']);
                Route::post('/', ['as' => 'stopwatches.store', 'uses' => 'StopwatchController@store']);
                Route::get('/{id}', ['as' => 'stopwatches.show', 'uses' => 'StopwatchController@show']);
                Route::post('/{id}/time', ['as' => 'stopwatches.storeTime', 'uses' => 'StopwatchTimeController@store']);
            });

            Route::group(['prefix' => 'gym', 'namespace' => 'Gym'], function()
            {
                Route::group(['prefix' => 'exercise'], function()
                {
                    Route::get('/', ['as' => 'gym.exercises.index', 'uses' => 'ExerciseController@index']);
                    Route::get('/create', ['as' => 'gym.exercises.create', 'uses' => 'ExerciseController@create']);
                    Route::post('/', ['as' => 'gym.exercises.store', 'uses' => 'ExerciseController@store']);
                    Route::get('/{id}', ['as' => 'gym.exercises.show', 'uses' => 'ExerciseController@show']);
                    Route::post('/{id}/category', ['as' => 'gym.exercises.category', 'uses' => 'CategoryController@add']);
                });

                Route::post('/category', ['as' => 'gym.categories.store', 'uses' => 'CategoryController@store']);


                Route::get('/', ['as' => 'gyms.index', 'uses' => 'GymController@index']);
                Route::get('/create', ['as' => 'gyms.create', 'uses' => 'GymController@create']);
                Route::post('/', ['as' => 'gyms.store', 'uses' => 'GymController@store']);
                Route::group(['prefix' => '{id}'], function()
                {
                    Route::get('/', ['as' => 'gyms.show', 'uses' => 'GymController@show']);
                    Route::post('/', ['as' => 'gym.training.store', 'uses' => 'TrainingController@store']);
                });
            });



        });


        Route::get('/home', 'HomeController@index');
        Route::get('/jeroen', ['as' => 'swimmer.jeroen', 'uses' => 'SwimmerController@jeroen']);
        Route::get('/philippe', ['as' => 'swimmer.philippe', 'uses' => 'SwimmerController@philippe']);
    });
});
