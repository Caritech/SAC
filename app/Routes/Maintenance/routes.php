<?php

//modify table
Route::get('/maintenance/table/service', 'Maintenance\Table\ServiceTableController@service');
Route::get('/maintenance/table/service/create', 'Maintenance\Table\ServiceTableController@create_service');
Route::post('/maintenance/table/service/create', 'Maintenance\Table\ServiceTableController@store_service');

Route::post('/maintenance/table/service/validate_service_name','Maintenance\Table\ServiceTableController@ajax_validate_service_name');