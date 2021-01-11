<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    if (\Auth::check()) {
        return redirect('/dashboard');
    } else {
        return redirect('/login');
    }
});

//To view images from storage
Route::get('view_image/{filepath}/{filename}', function ($filepath, $filename) {
    $path = storage_path('app/' . $filepath . '/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

Route::get('view_image/{filepath}/{id}/{filename}', function ($filepath, $id, $filename) {
    $path = storage_path('app/' . $filepath . '/' . $id . '/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

Route::get('view_image/{file_path?}', function ($file_path) {
    $path = storage_path('app/' . $file_path);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->where('file_path', '(.*)');
Route::get('view_file/{file_path?}', function ($file_path) {
    $path = storage_path('app/' . $file_path);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);

    if (is_array(getimagesize($path))) {
        $image = true;
        return Image::make($path)->response();
    }

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->where('file_path', '(.*)');

Route::get('get_user_info', function () {
    return \Auth::user();
});

Route::get('get_vlife_setting', function () {
    $setting = \DB::table('vlife_settings')->where('id', 1)->first();
    return \Response::json($setting);;
});



Auth::routes(['register' => false]);

Route::get('/dashboard', 'HomeController@dashboard');

Route::get('/admin/user_management', 'UserController@index');
Route::get('/admin/user_management/create', 'UserController@create');
Route::post('/admin/user_management/store', 'UserController@store');
Route::get('/admin/user_management/{id}/edit', 'UserController@edit');
Route::put('/admin/user_management/{id}/update', 'UserController@update');
Route::get('/my_profile', 'ProfileController@index');
Route::put('/my_profile/{id}', 'ProfileController@update');

Route::prefix('vlife')->group(function () {
    $vue_root = 'VLifeController@myContact';

    Route::get('/', $vue_root);

    Route::get('/my_contact', 'VLifeController@myContact');
    Route::get('/my_contact/{id}/edit', function ($id) {
        return redirect('vlife/my_contact/' . $id . '/edit/profile');
    });
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
    Route::post('/my_contact/need_calculation/save_nc', 'NeedsCalculatorController@save_nc');
    Route::get('/get_nc_data/{id}', 'NeedsCalculatorController@get_nc_data');
    Route::get('/my_contact/{id}/get_nc_industry_recommendation', 'NeedsCalculatorController@get_nc_industry_recommendation');
    Route::get('/my_contact/get_nc_industry_recommendation_distribution', 'NeedsCalculatorController@get_nc_industry_recommendation_distribution');

    // Insurnace (Exissting & Recommendartion)
    Route::get('/my_contact/insurance/{id}/create', $vue_root);
    Route::get('/my_contact/insurance/{id}/edit', $vue_root);
    Route::get('/get_contact_insurance/{id}', 'VLifeController@getInsurance');
    Route::get('/get_contact_insurance_detail/{id}', 'VLifeController@getInsuranceDetail');
    Route::post('/my_contact/insurance/save', 'VLifeController@saveInsurance');
    Route::post('/my_contact/insurance/update_incl', 'VLifeController@updateIncludeCalculationStatus');
    Route::post('/my_contact/insurance/delete', 'VLifeController@deleteInsurance');
    Route::post('/my_contact/insurance/update_to_existing', 'VLifeController@updateInsuranceToExisting');

    // Summary
    Route::get('/my_contact/summary/get_recommendation', 'SummaryController@get_recommendation');
    Route::get('/my_contact/summary/get_income_by_type', 'SummaryController@get_income_by_type');
    Route::get('/my_contact/summary/get_assets_investment_by_type', 'SummaryController@get_assets_investment_by_type');
    Route::get('/my_contact/summary/get_insurance_policy_summary', 'SummaryController@get_insurance_policy_summary');
    Route::get('/my_contact/summary/get_insurance_policy_premium', 'SummaryController@get_insurance_policy_premium');
    Route::get('/my_contact/summary/get_assurance_needs', 'SummaryController@get_assurance_needs');

    //SAVE Summary
    Route::post('my_contact/summary/save', 'SummaryController@save');

    //Report
    Route::get('/my_contact/{id}/print_summary_report', 'ReportController@print_summary_report');

    /*
        Item Maintenance
    */
    Route::prefix('setting')->group(function () {
        Route::resource('nc_type_category', 'Setting\NCTypeCategoryController');
        Route::resource('nc_type_data', 'Setting\NCTypeDataController');
    });


    //Common
    Route::get('/get_nationality_option', 'VLifeController@getNationalityOption');
    Route::get('/get_country_option', 'VLifeController@getCountryOption');
    Route::get('/get_state_option', 'VLifeController@getStateOption');
    Route::get('/get_insurance_dropdown', 'VLifeController@get_insurance_dropdown');
    //FOR SETTING USE
    Route::get('/get_setting_needs_calculator_items', 'SettingController@get_setting_needs_calculator_items');
});
