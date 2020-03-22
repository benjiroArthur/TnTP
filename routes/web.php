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

Route::get('/js/popper.js.map', function () {
    return redirect('/home');
});
Route::get('/js/vuejs-datatable.esm.js.map', function () {
    return redirect('/home');
});

Auth::routes();
Route::post('/new-register', 'Auth\MyRegisterController@userRegister')->name('userRegister');
//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'data', 'as' => 'data.'], function() {
    Route::get('/profile', 'ProfileController@getProfile');
    Route::post('/profile', 'ProfileController@getProfile');
    Route::get('/address', 'ProfileController@address');
    Route::get('/region', 'ProfileController@region');
    Route::get('/city/{region}', 'ProfileController@city');
});











//should be the last route
Route::get('{path}', 'HomeController@index')->where('path', '([A-z\-/_.]+)?' );
