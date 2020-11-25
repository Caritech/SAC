<?php

//main of scheduling Page
//Route::middleware(['permission:scheduler'])->group(function () {
Route::get('/scheduler', 'Scheduler\SchedulerController@index')->name('scheduler.index');

Route::prefix('scheduler')->name('scheduler.')->group(function () {

    //Service Agreement
    Route::get('service_agreement', 'Scheduler\SchedulerController@service_agreement')->name('service_agreement.index');
    /*

     *************************************
    Service Agreement - SA
     *************************************

     */
    Route::get('service_agreement/service/{service_id}', 'Scheduler\SchedulerController@sa_by_service');
    //Route::get('service_agreement/client/{service_id}', 'Scheduler\SchedulerController@sa_by_client');
    Route::get('service_agreement/client/{pd_id}', 'Scheduler\SchedulerController@sa_by_pd');

    Route::get('service_agreement/create', 'Scheduler\SchedulerController@create_sa');
    Route::post('service_agreement/create', 'Scheduler\SchedulerController@store_sa');

    //type can be service/client
    Route::get('service_agreement/create/{type}/{id}', 'Scheduler\SchedulerController@create_sa');
    Route::post('service_agreement/create/{type}/{id}', 'Scheduler\SchedulerController@store_sa');

    Route::get('service_agreement/edit/{id}', 'Scheduler\SchedulerController@edit_sa');
    Route::post('service_agreement/edit/{id}', 'Scheduler\SchedulerController@update_sa');

    //type used for return prupose
    Route::get('service_agreement/edit/{id}/{type}', 'Scheduler\SchedulerController@edit_sa');
    Route::post('service_agreement/edit/{id}/{type}', 'Scheduler\SchedulerController@update_sa');

    /*

     *************************************
    Service Planning - SP
     *************************************

     */
    //overall view
    Route::get('service_planning', 'Scheduler\SchedulerController@service_planning')->name('service_planning.index');
    //view by client
    Route::get('service_planning/sa/{sa_id}/view', 'Scheduler\SchedulerController@view_sp');

    //create
    Route::get('service_planning/sa/{sa_id}/create', 'Scheduler\SchedulerController@create_sp');
    Route::post('service_planning/sa/{sa_id}/create', 'Scheduler\SchedulerController@store_sp');

    //edit
    Route::get('service_planning/sa/{sa_id}/edit/{sp_id}', 'Scheduler\SchedulerController@edit_sp');
    Route::post('service_planning/sa/{sa_id}/edit/{sp_id}', 'Scheduler\SchedulerController@update_sp');

    //sp function
    Route::get('service_planning/sa/{sa_id}/preview_assignment', 'Scheduler\SchedulerController@preview_sp_assignment');

    /*  AJAX FUNCTION  */
    Route::get('service_planning/sa/{sa_id}/ajax_get_preview_assignment_in_calendar', 'Scheduler\SchedulerController@ajax_get_preview_assignment_in_calendar');

    /*   ON DEVING  */
    Route::get('dev/agreement', 'Scheduler\SchedulerDevController@index_agreement');
    Route::get('dev/agreement/create', 'Scheduler\SchedulerDevController@create_agreement');
    Route::post('dev/agreement/create', 'Scheduler\SchedulerDevController@store_agreement');

    Route::get('dev/agreement/{a_id}/planning', 'Scheduler\SchedulerDevController@planning_agreement');

    Route::get('service_assignment', 'Scheduler\SchedulerController@service_assignment')->name('service_assignment.index');
    Route::get('report', 'Scheduler\SchedulerController@report')->name('report.index');

});