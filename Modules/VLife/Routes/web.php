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

Route::prefix('vlife')->group(function () {
    Route::get('/', 'VLifeController@index');

    Route::get('/my_contact', 'VLifeController@myContact');
    Route::get('/my_contact/{id}/edit/{tab}', 'VLifeController@myContact');
    Route::get('/my_contact/{id}/edit/{tab}/{sub_tab}', 'VLifeController@myContact');
    Route::get('/get_contact_list', 'VLifeController@getContactList');

    //Profile
    Route::get('/my_contact/profile/{id}/edit', 'VLifeController@myContact');
    Route::get('/my_contact/profile/create', 'VLifeController@myContact');
    Route::get('/get_contact_profile_data/{contact_id}', 'VLifeController@getContactProfileData');
    Route::post('/my_contact/profile/save', 'VLifeController@saveContactProfile');
    Route::post('/my_contact/profile/inactive', 'VLifeController@inactiveContactProfile');

    //Cashflow - Income

    Route::get('/my_contact/cashflow/income/{id}/edit', 'VLifeController@myContact');
    Route::get('/my_contact/cashflow/income/{contact_id}/create', 'VLifeController@myContact');
    Route::get('/get_contact_cashflow_income/{id}', 'VLifeController@getContactCashflowIncome');
    Route::get('/get_contact_cashflow_income_data/{id}', 'VLifeController@getContactCashflowIncomeData');
    Route::get('/get_contact_cashflow_income_option', 'VLifeController@getContactCashflowIncomeOption');
    Route::post('/my_contact/cashflow/income/save', 'VLifeController@saveCashflowIncome');
    Route::post('/my_contact/cashflow/income/inactive', 'VLifeController@inactiveCashflowIncome');
    Route::post('/my_contact/cashflow/income/update_incl', 'VLifeController@updateCashflowInclStatus');
    //Asset & Investment
    Route::get('/my_contact/asset_investment/{id}/edit', 'VLifeController@myContact');
    Route::get('/my_contact/asset_investment/{contact_id}/create', 'VLifeController@myContact');
    Route::get('/get_contact_asset_investment/{id}', 'VLifeController@getContactAssetInvestment');
    Route::get('/get_contact_asset_investment_option', 'VLifeController@getContactAssetInvestmentOption');
    Route::get('/get_contact_cashflow_asset_investment_data/{id}', 'VLifeController@getContactAssetInvestmentData');
    Route::post('/my_contact/asset_investment/save', 'VLifeController@saveAssetInvestment');
    Route::post('/my_contact/asset_investment/inactive', 'VLifeController@inactiveAssetInvestment');
    Route::post('/my_contact/asset_investment/update_incl', 'VLifeController@updateAssetInvestmentStatus');

    // Needs Calculation
    Route::post('/my_contact/need_calculation/medical/save', 'VLifeController@saveNCMedical');
    //Common
    Route::get('/get_nationality_option', 'VLifeController@getNationalityOption');
    Route::get('/get_country_option', 'VLifeController@getCountryOption');
    Route::get('/get_state_option', 'VLifeController@getStateOption');
});
