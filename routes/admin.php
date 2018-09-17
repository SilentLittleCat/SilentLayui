<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

App::setLocale('zh');

Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');

Route::middleware(['auth.admin:admin'])->group(function() {

    Route::get('/', 'IndexController@index');
    Route::get('/index/welcome', 'IndexController@welcome');

    Route::get('change-password', 'Auth\LoginController@showChangePasswordForm');
    Route::post('change-password', 'Auth\LoginController@changePassword');
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/admin-menus/index', 'AdminMenuController@index');
    Route::get('/admin-menus/get', 'AdminMenuController@get');
    Route::get('/admin-menus/create', 'AdminMenuController@create');
    Route::get('/admin-menus/edit', 'AdminMenuController@edit');
    Route::post('/admin-menus/store', 'AdminMenuController@store');
    Route::post('/admin-menus/update', 'AdminMenuController@update');
    Route::post('/admin-menus/delete', 'AdminMenuController@delete');
    Route::post('/admin-menus/deleteMany', 'AdminMenuController@deleteMany');

    Route::get('/admin-users/index', 'AdminUserController@index');
    Route::get('/admin-users/get', 'AdminUserController@get');
    Route::get('/admin-users/create', 'AdminUserController@create');
    Route::get('/admin-users/edit', 'AdminUserController@edit');
    Route::post('/admin-users/store', 'AdminUserController@store');
    Route::post('/admin-users/update', 'AdminUserController@update');
    Route::post('/admin-users/delete', 'AdminUserController@delete');
    Route::post('/admin-users/deleteMany', 'AdminUserController@deleteMany');

    Route::get('/admin-roles/index', 'AdminRoleController@index');
    Route::get('/admin-roles/get', 'AdminRoleController@get');
    Route::get('/admin-roles/create', 'AdminRoleController@create');
    Route::get('/admin-roles/edit', 'AdminRoleController@edit');
    Route::post('/admin-roles/store', 'AdminRoleController@store');
    Route::post('/admin-roles/update', 'AdminRoleController@update');
    Route::post('/admin-roles/delete', 'AdminRoleController@delete');
    Route::post('/admin-roles/deleteMany', 'AdminRoleController@deleteMany');
});