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
    // dd(storage_path(''));
    dd(\Storage::getFile(storage_path('app\public\avatars\test.txt')));
    \Storage::disk('local')->put('file.txt', 'Contents of the file.');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/children', 'ChildController@index')->name('children');

Route::prefix('api')->group(function() {
    
    Route::prefix('child')->group(function() {
        Route::get('/{hash?}', 'ChildController@get');
        Route::post('/', 'ChildController@save');
        Route::delete('/{hash?}', 'ChildController@delete');
    });
});

