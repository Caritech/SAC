<?php

//budget plan
Route::get('service/agreement/axios_get_budget_plan_lists','Service\BudgetPlanController@axios_get_budget_plan_lists');
Route::get('service/agreement/axios_get_budget_plan','Service\BudgetPlanController@axios_get_budget_plan');
Route::get('service/agreement/{id}/budget_plan','Service\BudgetPlanController@budget_plan');
Route::post('service/agreement/axios_create_budget_plan','Service\BudgetPlanController@axios_create_budget_plan');

Route::get('budget_plan/axios_get_budget_plan_service_breakdown','Service\BudgetPlanController@axios_get_budget_plan_service_breakdown');
Route::get('budget_plan/axios_get_budget_plan_breakdown_item','Service\BudgetPlanController@axios_get_budget_plan_breakdown_item');
Route::get('budget_plan/axios_get_budget_price_plan_lists','Service\BudgetPlanController@axios_get_budget_price_plan_lists');
Route::get('budget_plan/axios_get_budget_plan_price_plan_group','Service\BudgetPlanController@axios_get_budget_plan_price_plan_group');
Route::post('budget_plan/axios_add_new_budget_plan_item','Service\BudgetPlanController@axios_add_new_budget_plan_item');
Route::post('budget_plan/axios_save_budget_plan','Service\BudgetPlanController@axios_save_budget_plan');
Route::post('budget_plan/axios_remove_budget_plan_item','Service\BudgetPlanController@axios_remove_budget_plan_item');
Route::post('budget_plan/axios_update_price_plan','Service\BudgetPlanController@axios_update_price_plan');




//agreement
Route::get('service/agreement/home','Service\AgreementController@home');
Route::post('service/axios_save_service_agreement','Service\AgreementController@axios_save_service_agreement');
Route::resource('service/agreement','Service\AgreementController');
Route::get('service/axios_get_service_agreement_data_for_dashboard','Service\AgreementController@axios_get_service_agreement_data_for_dashboard');
Route::get('service/axios_get_service_agreement_lists','Service\AgreementController@axios_get_service_agreement_lists');
Route::get('service/axios_get_service_agreement','Service\AgreementController@axios_get_service_agreement');



//plan
Route::post('service/axios_save_service_plan','Service\PlanController@axios_save_service_plan');
Route::get('service/axios_get_service_plans','Service\PlanController@axios_get_service_plans');
Route::get('service/axios_get_service_plan_data_for_dashboard','Service\PlanController@axios_get_service_plan_data_for_dashboard');
Route::get('service/axios_get_service_plan_lists','Service\PlanController@axios_get_service_plan_lists');
Route::get('service/axios_get_service_plan','Service\PlanController@axios_get_service_plan');
Route::get('service/axios_preview_assignment_from_plan','Service\PlanController@axios_preview_assignment_from_plan');
Route::get('service/plan_by_client/{pd_id}','Service\PlanController@plan_by_client');
Route::get('service/axios_get_pre_assignment_from_plans/','Service\PlanController@axios_get_pre_assignment_from_plans');
Route::get('service/plan/home','Service\PlanController@home');
Route::resource('service/plan','Service\PlanController');

//assignment

Route::get('service/axios_get_service_assignment_lists','Service\AssignmentController@axios_get_service_assignment_lists');
Route::get('service/axios_get_service_assignment','Service\AssignmentController@axios_get_service_assignment');
Route::get('service/assignment/home','Service\AssignmentController@home');
Route::get('service/assignment/create_from_plan','Service\AssignmentController@create_from_plan');
Route::get('service/axios_get_pre_assignment_with_plan','Service\AssignmentController@axios_get_pre_assignment_with_plan');
Route::get('service/axios_create_assignment_from_plan','Service\AssignmentController@axios_create_assignment_from_plan');
Route::resource('service/assignment','Service\AssignmentController');






//OLDOLDOLDODLOLDODLODL
//Route::resource('/service/assignment_overview','Service\AssignmentController');
Route::post('/service/assignment_overview/getAssignment','Service\AssignmentController@ajax_getAssignment');

//Home Help Assignment
Route::post('service/homehelp/client_service_list','Service\HomeHelpController@saveClientServiceLists');

Route::post('/service/homehelp/client_service_list/ajax_UpdateClientService','Service\HomeHelpController@ajax_UpdateClientService');
Route::get('/service/homehelp/client_service_list','Service\HomeHelpController@ClientServiceList')->name('client_service_list');
Route::post('/service/homehelp/client_service_list/ajax_cancellation','Service\HomeHelpController@ajax_cancellation');
Route::get('/service/homehelp/client_service_list/cancel_assignment','Service\HomeHelpController@CancelAssignment');
Route::post('/service/homehelp/client_service_list/cancel_assignment','Service\HomeHelpController@CancelAssignment');

//SuggestedSW
Route::post('/service/homehelp/client_service_list/ajax_getSuitableSW','Service\HomeHelpController@ajax_getSuitableSW');
Route::get('/service/homehelp/client_service_list/ajax_getSuitableSW','Service\HomeHelpController@ajax_getSuitableSW');
Route::post('/service/homehelp/client_service_list/ajax_findSWInSuitableLists','Service\HomeHelpController@ajax_findSWInSuitableLists');
Route::get('/service/homehelp/client_service_list/ajax_findSWInSuitableLists','Service\HomeHelpController@ajax_findSWInSuitableLists');


//Transport Assignment
Route::get('/service/transport/{branch_id}','Service\TransportController@index')->name('transport_assignment_form');
Route::get('/service/transport/{branch_id}/requestList','Service\TransportController@requestList');

//Assignment Overview
Route::get('/service/assignment_overview','Service\AssignmentController@index')->name('assignment_overview');
Route::get('/service/assignment_overview/requestList','Service\AssignmentController@show');

//add
Route::post('/service/transport/ajax_addTransportAssignment','Service\TransportController@ajax_addTransportAssignment');
Route::get('/service/transport/ajax_addTransportAssignment','Service\TransportController@ajax_addTransportAssignment');

//getNameOfCarer
Route::post('/service/transport/ajax_getPrimaryCarer','Service\TransportController@ajax_getPrimaryCarer');
Route::get('/service/transport/ajax_getPrimaryCarer','Service\TransportController@ajax_getPrimaryCarer');
Route::post('/service/transport/ajax_getSupportWorker','Service\TransportController@ajax_getSupportWorker');
Route::get('/service/transport/ajax_getSupportWorker','Service\TransportController@ajax_getSupportWorker');

//update
Route::delete('/service/transport/ajax_updateTransportAssignment','Service\TransportController@ajax_updateTransportAssignment');

//Cancel Assignment
Route::post('/service/transport/ajax_cancellation','Service\HomeHelpController@ajax_cancellation');
Route::get('/service/transport/ajax_cancellation','Service\HomeHelpController@ajax_cancellation');

//Delete Assignment
Route::delete('/service/transport/ajax_deleteTransportAssignment','Service\TransportController@ajax_deleteTransportAssignment');

//Print Report
Route::get('/service/transport/assignment/{location_id}/{date}/print','Service\TransportController@printpdf');

//Copy From selected date
Route::post('/service/transport/ajax_checkSelectDate','Service\TransportController@ajax_checkSelectDate');
Route::get('/service/transport/ajax_checkSelectDate','Service\TransportController@ajax_checkSelectDate');





