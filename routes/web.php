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

Route::get('/', function () {
    return view('start');
});
Route::get('/info', function () {
    return view('info');
});
Route::get('/bookings','TransactionController@index');
Route::get('/bookroom','TransactionController@create');
Route::post('/roombooked','TransactionController@store');
Route::get('/transaction/{transaction}','TransactionController@show');
Route::get('/transaction/{transaction}/edit','TransactionController@edit');
Route::put('/transaction/{transaction}/update','TransactionController@update');
Route::delete('/transaction/{transaction}/destroy','TransactionController@destroy');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
