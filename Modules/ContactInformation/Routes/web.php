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
Route::prefix('contactinformation')->group(function () {
    Route::get('/r/get_contact', 'AxiosGetController@get_contact');
    Route::get('/r/get_support_worker_lists', 'ContactInformationController@get_support_worker_lists');

    Route::view('/', 'contactinformation::index');
    Route::get('{any}', function ($any) {
        return view('contactinformation::index');
    })->where('any', '.*');
});
