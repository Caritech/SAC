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
Route::get('test', function () {
    dd(1);
});

Route::prefix('scheduler')->group(function () {
    Route::get('/', 'SchedulerController@index');
});

Route::prefix('service')->middleware(['auth'])->group(function () {

    //AGREEMENT
    Route::get('/r/get_service_agreement_lists', 'ServiceAgreementController@get_service_agreement_lists');
    Route::get('/r/get_service_agreement_dropdown', 'ServiceAgreementController@get_service_agreement_dropdown');
    Route::get('/r/get_client_info', 'ServiceAgreementController@get_client_info');
    Route::get('/r/get_agreement_detail', 'ServiceAgreementController@get_agreement_detail');
    Route::post('/r/save_service_agreement', 'ServiceAgreementController@save_service_agreement');

    //BUDGET PLAN
    Route::get('/r/get_client_budget_plan', 'BudgetPlanController@get_client_budget_plan');
    Route::get('/r/get_client_budget_plan_lists', 'BudgetPlanController@get_client_budget_plan_lists');
    Route::get('/r/get_budget_plan_detail', 'BudgetPlanController@get_budget_plan_detail');
    Route::post('/r/save_budget_plan', 'BudgetPlanController@save_budget_plan');
    Route::post('/r/create_budgte_plan', 'BudgetPlanController@create_budgte_plan');
    Route::post('/r/update_budget_plan_pricing', 'BudgetPlanController@update_budget_plan_pricing');
    Route::post('/r/update_budget_plan_pricing', 'BudgetPlanController@update_budget_plan_pricing');
    Route::post('/r/budget_plan/add_new_service_item', 'BudgetPlanController@add_new_service_item');
    Route::post('/r/budget_plan/delete_service_breakdown_item', 'BudgetPlanController@delete_service_breakdown_item');

    Route::view('/', 'scheduler::service_index');
    Route::get('{any}', function ($any) {
        return view('scheduler::service_index');
    })->where('any', '.*');
});
