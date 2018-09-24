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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Middleware
Route::middleware(['auth', 'subscription'])->group(function(){
    // Dashboard
    Route::get('/home', 'HomeController@index')->name('home');

    // Prefix tenant
    Route::prefix('tenant')->group(function(){
        Route::get('/add','TenantController@create')->name('add_tenant');
        Route::post('/add','TenantController@store')->name('save_new_tenant');
        Route::get('/','TenantController@index')->name('show_tenant');
        Route::get('/{id}','TenantController@show')->name('show_detail_tenant');
        Route::post('/edit/{id}','TenantController@update')->name('update_tenant');
        Route::post('/delete/{id}','TenantController@destroy')->name('delete_tenant');
    });
});