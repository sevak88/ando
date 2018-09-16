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

Route::get('/', [
    "uses" => "PrintingController@index"
]);

Auth::routes();


Route::post('/printings/addlog/{id}', [
    "as" => "printings.addlog",
    'uses' =>'PrintingController@addlog'
]);
Route::post('/printings/deletefile/{id}', [
    "as" => "printings.deletefile",
    'uses' =>'PrintingController@deletefile'
]);
Route::resource('/printings', 'PrintingController');
