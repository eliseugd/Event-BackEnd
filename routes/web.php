<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->options(
    '/{any:.*}',
    [
        'middleware' => ['cors'],
        function () {
            return response(['status' => 'success']);
        },
    ]
);

Route::group(['middleware' => ['cors']], function () {
    Route::post('signin', 'AuthenticateController@authenticate');

    Route::group(['prefix' => 'user-register'], function () {
        Route::post('/', 'UserController@store');
    });

    Route::post('/events-search', 'EventController@show');
});

// Auth::routes();

Route::group(['middleware' => ['cors', 'jwt.verify']], function () {
    Route::group(['prefix' => 'events'], function () {
        Route::get('/', 'EventController@index');
        Route::post('/', 'EventController@store');
        Route::get('/{event}/edit', 'EventController@edit');
        Route::patch('/{event}', 'EventController@update');
        Route::delete('/{event}', 'EventController@destroy');
    });

    Route::group(['prefix' => 'user-event'], function () {
        Route::get('/', 'EventUserController@index');
        Route::post('/', 'EventUserController@store');
        Route::post('/search', 'EventUserController@show');
        Route::get('/{event-user}/edit', 'EventUserController@edit');
        Route::patch('/{event-user}', 'EventUserController@update');
        Route::post('/aprovar', 'EventUserController@aprovarParticipation');
        Route::post('/cancel', 'EventUserController@cancelParticipation');
        Route::delete('/{event-user}', 'EventUserController@destroy');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@index');
        Route::post('/', 'UserController@store');
        Route::get('/{event}', 'UserController@show');
        Route::get('/{event}/edit', 'UserController@edit');
        Route::patch('/{event}', 'UserController@update');
        Route::delete('/{event}', 'UserController@destroy');
    });

    Route::group(['prefix' => 'category-event'], function () {
        Route::get('/', 'CategoryEventController@index');
        Route::post('/', 'CategoryEventController@store');
        Route::get('/{category}', 'CategoryEventController@show');
        Route::get('/{category}/edit', 'CategoryEventController@edit');
        Route::patch('/{category}', 'CategoryEventController@update');
        Route::delete('/{category}', 'CategoryEventController@destroy');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
