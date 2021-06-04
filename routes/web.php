<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('sandbox', function () {
    return App\Tracker::whereIn('child_id', \App\Child::accessibleChildren())->paginate(2);
});

Auth::routes();

Route::middleware(['isAuthenticatedUser'])->group(function() {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/children', 'ChildController@index')->name('children');

    Route::get('/tracker', 'TrackerController@index')->name('tracker');

    Route::prefix('api')->group(function() {
        
        Route::prefix('child')->group(function() {
            Route::get('/{hash?}', 'ChildController@get');
            Route::post('/', 'ChildController@save');
            Route::delete('/{hash?}', 'ChildController@delete');
        });

        Route::prefix('category')->group(function() {
            Route::get('/', 'CategoryController@get');
        });

        Route::prefix('tracker')->group(function() {
            Route::get('/{hash?}/{id?}', 'TrackerController@get');
            Route::post('/', 'TrackerController@save');
            Route::delete('/{id}', 'TrackerController@delete');
        });
    });

});

