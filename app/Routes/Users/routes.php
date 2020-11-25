<?php

// Authentication Routes... 
// see https://github.com/laravel/framework/blob/5.8/src/Illuminate/Routing/Router.php
Route::get('user/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('user/login', 'Auth\LoginController@login');
Route::post('user/logout', 'Auth\LoginController@logout')->name('logout');


Route::group(['middleware'=>'role'], function () {
	#####################################################################
	#######                   PERMISSION-ROLE-USER               ########
	#####################################################################
  
});
// Route::get('user/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('user/register', 'Auth\RegisterController@register');

Route::resetPassword();
Route::emailVerification();