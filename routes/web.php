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
    return \App\Category::getAll();
    // dd(storage_path('app'));
    // dd(storage_path('app'), \Storage::allFiles(storage_path('app')));
    // dd(\Storage::disk('public')->get('http://goo-goo-data.test/storage/avatars/test.txt'));
    try {
        // dd(getcwd());        
        // dd(\Storage::allDirectories('D:\laragon\www\goo-goo-data\public'));
        \Storage::disk('s3')->put('/avatars/file.txt', 'Contents of the file.');
        dd('success?');
    } catch (\Exception $e) {
        dd($e->getMessage());
    }
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
    });

});

