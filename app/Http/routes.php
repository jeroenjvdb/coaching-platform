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


Route::bind('group', function ($slug) {
    return App\Group::where('slug', $slug)->firstOrFail();
});

Route::bind('swimmer', function ($slug) {
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

Route::group(['middleware' => 'web'], function () {
    Route::get('/index', function() {
        return redirect('/');
    });
    
    Route::get('test', 'HomeController@test');
    Route::auth();

    Route::get('password/email', 'Auth\PasswordController@getEmail');
    Route::post('password/email', 'Auth\PasswordController@postEmail');

    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('password/reset', 'Auth\PasswordController@postReset');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', 'HomeController@index');
        Route::get('/password', [
            'as' => 'auth.password.edit',
            'uses' => 'UserController@getUpdatePassword',
        ]);
        Route::post('/password', [
            'as' => 'auth.password.update',
            'uses' => 'UserController@postUpdatePassword',
        ]);
        Route::group(['prefix' => '{group}'], function () {
            Route::get('/me', ['as' => 'me.profile', 'uses' => 'MyController@me']);
            Route::post('/me', ['as' => 'me.reaction.store', 'uses' => 'MyController@store']);
            Route::post('/me/heartRate', ['as' => 'me.heartRate', 'uses' => 'MyController@heartRate']);
            Route::get('/me/heartRate', ['as' => 'profile.heartRate', 'uses' => 'MyController@getHeartRate']);
        });


        Route::group([/*'middleware' => 'coach'*/], function () {


            Route::group(['prefix' => '{group}'], function () {
                Route::resource('coach', 'CoachController', ['parameters' => [
//                'group' => 'group',
                ]]);
                Route::group(['namespace' => 'Training'], function () {
                    Route::get('/get', ['as' => '{group}.training.get', 'uses' => 'ApiController@get']);
//                    Route::get('/{id}', ['as' => 'trainings.show', 'uses' => 'TrainingController@show']);

                    Route::get('training/{training_id}/download', [
                        'as' => '{group}.training.download',
                        'uses' => 'TrainingController@download',
                    ]);


                    Route::group(['prefix' => 'training/{training_id}'], function () {
                        Route::post('presences', [
                            'as' => '{group}.training.presences.store',
                            'uses' => 'PresenceController@store',
                        ]);

                        Route::post('exercise/position', [
                            'as' => '{group}.training.exercise.update.position',
                            'uses' => 'ExerciseController@updatePosition',
                        ]);

                        Route::post('exercise/position/category', [
                            'as' => '{group}.training.exercise.update.cat.position',
                            'uses' => 'CategoryController@updateCatPosition',
                        ]);

                        Route::post('category', [
                            'as' => '{group}.training.category.exercise.store',
                            'uses' => 'CategoryController@store',
                        ]);

                        Route::get('distances', [
                            'as' => '{group}.training.show.distances',
                            'uses' => 'ApiController@individualDistance',
                        ]);
                        Route::post('shared', [
                            'as' => '{group}.training.shared',
                            'uses' => 'ApiController@shared',
                        ]);

                    });
                    Route::resource('training', 'TrainingController');
                    Route::resource('training.exercise', 'ExerciseController', [
                        'except' => [
                            'index',
                            'show',
                            'edit',
                        ]
                    ]);

                });

                Route::group([ 'namespace' => 'Swimmer'], function () {
                    Route::group(['prefix' => 'zwemmer'], function() {
                        Route::get('download', ['as' => '{group}.swimmer.download.pr', 'uses' => 'SwimmerController@download']);

                        Route::group(['prefix' => '{swimmer}'], function () {
                            Route::post('meta', [
                                'as' => '{group}.swimmer.meta.store',
                                'uses' => 'MetaController@store',
                            ]);
                            Route::post('contact', [
                                'as' => '{group}.swimmer.contact.update',
                                'uses' => 'ContactController@update'
                            ]);

                            Route::post('heartRate', [
                                'as' => '{group}.swimmer.heartRate',
                                'uses' => 'ApiController@heartRate'
                            ]);
                            Route::get('heartRate', [
                                'as' => '{group}.swimmer.heartRate',
                                'uses' => 'ApiController@getHeartRate'
                            ]);

                        });
                    });

                    Route::resource('zwemmer', 'SwimmerController', [
                        'names' => [
                            'index' => '{group}.swimmer.index',
                            'store' => '{group}.swimmer.store',
                            'create' => '{group}.swimmer.create',
                            'show' => '{group}.swimmer.show',
                            'update' => '{group}.swimmer.update',
                            'edit' => '{group}.swimmer.edit',
                        ],
                        'parameters' => [
                            'zwemmer' => 'swimmer',
                        ],
                        'except' => [
                            'destroy',
                        ]
                    ]);

                });
                Route::post('stopwatch/{id}/time', [
                    'as' => '{group}.stopwatch.storeTime',
                    'uses' => 'StopwatchTimeController@store'
                ]);
                Route::post('stopwatch/create/api', [
                    'as' => '{group}.stopwatch.store.api',
                    'uses' => 'StopwatchController@storeApi',
                ]);

                Route::resource('stopwatch', 'StopwatchController', [
                    'except' => [
                        'destroy',
                        'edit',
                        'update',
                    ],
                ]);

            });


            Route::get('/create', ['as' => 'groups.create', 'uses' => 'GroupController@create']);
            Route::post('/', ['as' => 'groups.store', 'uses' => 'GroupController@store']);
            Route::group(['prefix' => '{group}'], function () {
                //Route::get('/', ['as' => 'groups.index', 'uses' => 'GroupController@index']);

                Route::get('/', ['as' => 'groups.show', 'uses' => 'GroupController@show']);
                Route::get('/edit', ['as' => 'groups.edit', 'uses' => 'GroupController@edit']);
                Route::post('/', ['as' => 'groups.update', 'uses' => 'GroupController@update']);
                Route::get('/destroy', ['as' => 'groups.destroy', 'uses' => 'GroupController@destroy']);


                Route::group(['prefix' => 'chat'], function () {
                    Route::get('/', ['as' => 'chat.index', 'uses' => 'ChatController@index']);
                    //Route::get('chat', ['as' => 'chat', 'uses' => 'ChatController@chat']);
                    Route::post('/{name}/message', ['as' => 'chat.fire', 'uses' => 'ChatController@fire']);
                    Route::get('/{name}', ['as' => 'chat.show', 'uses' => 'ChatController@show']);
                });


                Route::group(['prefix' => 'training', 'namespace' => 'Training'], function () {
//                    Route::get('/', ['as' => 'trainings.index', 'uses' => 'TrainingController@index']);
//                    Route::get('/create', ['as' => 'trainings.create', 'uses' => 'TrainingController@create']);
//                    Route::post('/', ['as' => 'trainings.store', 'uses' => 'TrainingController@store']);

                });

                Route::group(['namespace' => 'Gym'], function () {

                    Route::group(['prefix' => 'gym'], function() {
                        Route::get('/get', [
                            'as' => '{group}.gym.get',
                            'uses' => 'ApiController@get',
                        ]);

                        Route::post('exercise/store/api', [
                            'as' => '{group}.gym.{gym}.add.api',
                            'uses' => 'ApiController@store',
                        ]);

                        Route::post('{gym}/add/', [
                            'as' => '{group}.gym.{gym}.add',
                            'uses' => 'TrainingController@store',
                        ]);

                        Route::post('exercise/{id}/category', [
                            'as' => '{group}.gym.exercises.category',
                            'uses' => 'CategoryController@add'
                        ]);
                        Route::post('/category', [
                            'as' => '{group}.gym.categories.store',
                            'uses' => 'CategoryController@store'
                        ]);

                        Route::resource('exercise', 'ExerciseController', [
                            'only' => [
                                'index',
                                'create',
                                'store',
                                'show',
                            ]
                        ]);
                    });

                    Route::resource('gym', 'GymController', [
                        'except' => [
                            'update',
                            'edit',
                            'destroy',
                        ]
                    ]);
                });
            });


            /*Route::group(['prefix' => 'stopwatch'], function () {
                Route::get('/', ['as' => 'stopwatches.index', 'uses' => 'StopwatchController@index']);
                Route::get('/create', ['as' => 'stopwatches.create', 'uses' => 'StopwatchController@create']);
                Route::post('/', ['as' => 'stopwatches.store', 'uses' => 'StopwatchController@store']);
                Route::get('/{id}', ['as' => 'stopwatches.show', 'uses' => 'StopwatchController@show']);
                Route::post('/{id}/time', ['as' => 'stopwatches.storeTime', 'uses' => 'StopwatchTimeController@store']);
            });*/




        });

    });
});
