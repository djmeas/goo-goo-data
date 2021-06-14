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
    return App\User::where('id', Auth::id())->first()->email;
    return App\Tracker::whereIn('child_id', \App\Child::accessibleChildren())->paginate(2);
});

Auth::routes();

Route::middleware(['isAuthenticatedUser'])->group(function() {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/children', 'ChildController@index')->name('children');
    Route::get('/children/{hash}', 'ChildController@view')->name('view_child');

    Route::get('/tracker', 'TrackerController@index')->name('tracker');

    Route::get('/charts/{hash}', 'ChartController@view');

    Route::get('/invites', 'CaretakerController@view_invites');

    Route::prefix('api')->group(function() {
        
        Route::prefix('child')->group(function() {
            Route::get('/{hash?}', 'ChildController@get');
            Route::post('/', 'ChildController@save');
            Route::delete('/{hash?}', 'ChildController@delete');
        });

        Route::prefix('caretaker')->group(function() {
            Route::get('my-invites', 'CaretakerController@get_my_invites');
            Route::post('my-invites', 'CaretakerController@respond_to_invite');

            Route::get('is-parent/{child_hash}/{user_id}', 'CaretakerController@is_parent_of_child');
            Route::post('mark-parent-child', 'CaretakerController@mark_parent_child');

            Route::post('invite', 'CaretakerController@save_invite');
            Route::delete('invite/{invite_id}', 'CaretakerController@delete_invite');
            Route::get('pending-invites/{hash}', 'CaretakerController@get_pending_invites');

            Route::get('{hash?}', 'CaretakerController@get');

            Route::delete('{child_hash}/{user_id}', 'CaretakerController@delete_caretaker');
        });

        Route::prefix('category')->group(function() {
            Route::get('/', 'CategoryController@get');
        });

        Route::prefix('tracker')->group(function() {
            Route::get('/{hash?}/{id?}', 'TrackerController@get');
            Route::post('/', 'TrackerController@save');
            Route::delete('/{id}', 'TrackerController@delete');
        });

        Route::prefix('chart')->group(function() {
            Route::get('{hash}/{category_id}/{start}/{end}', 'ChartController@generate_chart');
        });
    });

});

