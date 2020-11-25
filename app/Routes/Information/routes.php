<?php

Route::resource('/information/contact', 'Information\ContactController');

Route::get('/information/contact/{contact_type}/index','Information\ContactController@index');
Route::post('/information/contact/{id}/role_update','Information\ContactController@update_role');
Route::get('/information/contact/{id}/journey','Information\ContactController@show_journey');
Route::get('/information/contact/{id}/service-agreement','Information\ServiceAgreementController@index');
Route::get('/information/contact/{id}/service-agreement/{sa_id}/careplan','Information\CareplanController@index');

Route::get('/information/contact/{id}/leave','Information\ContactController@leave');
Route::get('/information/contact/{id}/leave/create','Information\ContactController@create_leave');
Route::post('/information/contact/{id}/leave/create','Information\ContactController@store_leave');
Route::get('/information/contact/{id}/leave/{leave_id}/edit','Information\ContactController@edit_leave');
Route::post('/information/contact/{id}/leave/{leave_id}/edit','Information\ContactController@update_leave');

Route::get('/information/contact/{id}/erecording','Information\ContactController@erecording');
Route::post('/information/contact/{id}/erecording','Information\ContactController@addErecording');

Route::get('/information/contact/{id}/dex','Information\ContactController@dex');
Route::put('/information/contact/{id}/dex','Information\ContactController@dexUpdate');

Route::get('/information/contact/{id}/mds','Information\ContactController@mds');
Route::put('/information/contact/{id}/mds','Information\ContactController@mdsUpdate');

Route::get('/information/contact/{id}/address','Information\ContactController@address');

Route::get('/information/contact/{id}/address/edit','Information\ContactController@editAddress');
Route::put('/information/contact/{id}/address/edit','Information\ContactController@updateAddress');

Route::get('/information/contact/{id}/relationship  ','Information\ContactController@relationship');
Route::post('/information/contact/{id}/relationship','Information\ContactController@updateRelationship');

Route::post('ajax/medical_list','Information\ContactController@medicalList');

Route::get('information/contact/{id}/address/create','Information\ContactController@createAddress')->name('contact.createAddress');
Route::put('information/contact/{id}/address/create','Information\ContactController@storeAddress')->name('contact.storeAddress');

Route::post('information/contact/{id}/erecording/add','Information\ContactController@addErecording');