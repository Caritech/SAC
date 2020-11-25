<?php

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

Route::get('get_user_info', function () {
    return \Auth::user();
});

Route::get('get_vlife_setting', function () {
    $setting = \DB::table('vlife_settings')->where('id',1)->first();
    return \Response::json($setting);;
});

Auth::routes(['register' => false]);

Route::view('/dashboard', 'Core.dashboard');
