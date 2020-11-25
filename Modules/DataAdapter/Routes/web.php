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

Route::prefix('data_adapter')->middleware(['auth'])->group(function () {
    Route::get('/r/sync_services', 'DataAdapterController@sync_services');
    Route::get('/r/sync_price', 'DataAdapterController@sync_price');
    Route::get('/r/sync_information', 'DataAdapterController@sync_information');

    Route::view('/', 'dataadapter::index');
    Route::get('{any}', function ($any) {
        return view('dataadapter::index');
    })->where('any', '.*');

});
