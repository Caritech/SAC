<?php
//Permission Module
Route::resource('/setting/permission', 'Permission\PermissionController');
Route::get('/setting/permission','Permission\PermissionController@create');


Route::get('/setting/role/create','Permission\PermissionController@role_create');
Route::post('/setting/role/create','Permission\PermissionController@role_store');
Route::post('/setting/role/destroy','Permission\PermissionController@ajax_deleteRole');
Route::get('/setting/role/refresh','Permission\PermissionController@ajax_refreshPermission');