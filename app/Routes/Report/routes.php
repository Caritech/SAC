<?php

Route::get('/report', 'Report\ReportController@report');

Route::get('report/swTrainingReport', 'Report\information\SWTrainingController@sw_index');
Route::get('report/TrainingReport', 'Report\information\SWTrainingController@training_index');

Route::resource('report/report_first_aid', 'Report\information\FirstAidExpiryController');

Route::resource('report/MedicationSupportAdminExpiry', 'Report\information\MedicationSupportAdminExpController');

Route::resource('report/work_with_child', 'Report\information\WorkWithChildController');
Route::get('report/work_with_child_ajax', 'Report\information\WorkWithChildController@get_all_ajax');

Route::get('report/report_police_cert/{type}', 'Report\information\PoliceCertController@printPDF');

Route::resource('report/ReportDrivingLicenseExpiry', 'Report\information\DrivingLicenseExpiryController');

Route::resource('report/ReportMotorServiceExpiry', 'Report\information\MotorServiceExpiryController');

Route::resource('report/report_required_induction', 'Report\information\RequiredInductionController');

Route::resource('report/PayPointCheckList', 'Report\information\PayPointCheckListController');
