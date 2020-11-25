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

Route::prefix('setting')->middleware(['auth'])->group(function() {
    //REQUEST ROUTE prefix with /r/

    //GET ROUTE
    Route::get('/r/get_service_lists','SettingServiceController@get_service_lists');
    Route::get('/r/get_service_detail','SettingServiceController@get_service_detail');
    Route::get('/r/get_price_plan_detail','SettingServiceController@get_price_plan_detail');

    //POST ROUTE
    Route::post('/r/save_service','SettingServiceController@save_service');
    Route::post('/r/add_new_service_price_plan','SettingServiceController@add_new_service_price_plan');
    Route::post('/r/add_new_service_breakdown','SettingServiceController@add_new_service_breakdown');
    Route::post('/r/delete_service_breakdown','SettingServiceController@delete_service_breakdown');

    Route::post('/r/price_plan/add_new_group_item','SettingServiceController@add_new_group_item');
    Route::post('/r/price_plan/add_new_group','SettingServiceController@add_new_group');
    Route::post('/r/price_plan/delete_group_item','SettingServiceController@delete_group_item');
    Route::post('/r/price_plan/delete_group','SettingServiceController@delete_group');
    Route::post('/r/price_plan/update_group','SettingServiceController@update_group');
    Route::post('/r/price_plan/update_price_plan','SettingServiceController@update_price_plan');
    Route::post('/r/price_plan/clone_existing','SettingServiceController@clone_existing');
    Route::post('/r/price_plan/save_price_plan_breakdown','SettingServiceController@save_price_plan_breakdown');
    Route::post('/r/price_plan/delete_price_plan','SettingServiceController@delete_price_plan');



    Route::view('/', 'setting::index');
    Route::get('{any}', function ($any){
        return view('setting::index');
    })->where('any','.*');
});
