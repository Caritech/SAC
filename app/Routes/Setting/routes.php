<?php

Route::get('setting/users/create','UsersController@create')->name('user.create');
Route::post('setting/users/create','UsersController@store')->name('user.store');

Route::get('profile/{id}', 'Setting\ProfileController@profile')->name('profile');
Route::put('profile/{id}', 'Setting\ProfileController@update')->name('profile.update');

/*
Route::get('emailtemplate','Auth\EmailController@home2')->name('home2');
Route::get('resetpass','Auth\EmailController@resetpass')->name('resetpass');
*/

Route::get('setting/users/masquerade/{id}',"Setting\UsersController@Cloak");

Route::get('uncloak',"Setting\UsersController@unCloak");
Route::resource('setting/users','Setting\UsersController');

Route::get('/history/move_history_log','Setting\HistoryController@move_history_log');
Route::get('history/{id}', 'Setting\HistoryController@more');
Route::resource('history', 'Setting\HistoryController');

Route::get('fortnight','Setting\UsersController@unCloak')->name('home2');
Route::get('resetpass','Setting\UsersController@unCloak')->name('resetpass');

Route::get('setting/fortnight/getPreview','Setting\FortnightController@requestFortnightInformation');
Route::get('setting/fortnight/getPreviewList','Setting\FortnightController@requestFortnightList');
Route::resource('setting/fortnight', 'Setting\FortnightController');

Route::get('setting/holiday/getPreview','Setting\HolidayController@requestHolidayInformation');
Route::resource('setting/holiday', 'Setting\HolidayController');

Route::name('setting.')->group(function () {

    Route::get('setting/services/{id}/add_price', 'Setting\ServiceController@add_price');
    Route::get('setting/services/{service_id}/price_plan/{group_id}', 'Setting\ServiceController@manage_price');
    Route::post('setting/services/{service_id}/price_plan/{group_id}', 'Setting\ServiceController@save_manage_price');
    Route::post('setting/services/{service_id}/price_plan/{group_id}', 'Setting\ServiceController@save_manage_price');
    Route::post('setting/services/{service_id}/price_plan/{group_id}/create_new_group', 'Setting\ServiceController@create_new_group');
    Route::post('setting/services/{service_id}/price_plan/{group_id}/create_new_group_item', 'Setting\ServiceController@create_new_group_item');
    Route::post('setting/services/{service_id}/price_plan/{group_id}/save_group', 'Setting\ServiceController@save_group');
    Route::post('setting/services/{service_id}/price_plan/{group_id}/save_plan_service_item', 'Setting\ServiceController@save_plan_service_item');

    Route::resource('setting/services', 'Setting\ServiceController');
    Route::resource('setting/services-breakdown', 'Setting\ServiceBreakdownController');

});