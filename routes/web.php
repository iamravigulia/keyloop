<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('/properties')->group(function(){
    Route::get('/index', 'App\Http\Controllers\PropertyController@index')->name('properties.index');
    Route::get('/edit/{id}', 'App\Http\Controllers\PropertyController@edit')->name('properties.edit');
    Route::post('/update/{id}', 'App\Http\Controllers\PropertyController@update')->name('properties.update');
});
