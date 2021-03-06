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
Route::middleware(['auth','notBlocked'])->group(function(){
    Route::get('/subscription','SubscriptionController@index')->name('interrupt_subscription');

    Route::middleware(['admin'])->prefix('admin')->group(function(){
        Route::get('/dashboard', 'AdminController@index')->name('admin_dashboard');
        Route::get('/user', 'AdminController@user')->name('admin_user');
        Route::get('/user/{id}', 'AdminController@userDetail')->name('admin_user_detail');
        Route::post('/user/{id}', 'AdminController@userUpdate')->name('admin_user_update');
        Route::post('/user/{id}/ban','AdminController@userBan')->name('admin_user_ban');
    });

    Route::middleware(['subscription'])->group(function(){
        // Dashboard
        Route::get('/home', 'HomeController@index')->name('home');
        Route::post('/home','HomeController@show')->name('specific_dashboard');

        //Upload 
        Route::post('/upload/galery/{property_id}', 'PropertyController@upload')->name('upload');
        Route::post('/upload/property-document/{property_id}', 'PropertyController@uploadDocument')->name('upload-document');
        Route::get('/upload/remove/{id}/{remove_file}/{property_id}','PropertyController@deleteFile')->name('delete_file');
        Route::get('/upload/remove-image/{id}/{remove_file}/{property_id}','PropertyController@deleteImage')->name('delete_img_file');

        // Prefix tenant
        Route::prefix('tenant')->group(function(){
            Route::get('/add','TenantController@create')->name('add_tenant');
            Route::post('/add','TenantController@store')->name('save_new_tenant');
            Route::get('/','TenantController@index')->name('show_tenant');
            Route::get('/{id}','TenantController@show')->name('show_detail_tenant');
            Route::post('/edit/{id}','TenantController@update')->name('update_tenant');
            Route::post('/delete/{id}','TenantController@destroy')->name('delete_tenant');
        });

        // Prefix tenant
        Route::prefix('report')->group(function(){
            Route::get('/income-expense','ReportController@reportIncomeExpense')->name('report_income_expense');
            Route::get('/income-expense/view','ReportController@reportIncomeExpenseView')->name('report_income_expense_view');
            Route::get('/overdue','ReportController@reportOverdue')->name('report_overdue');
            Route::get('/overdue/view','ReportController@reportOverdueView')->name('report_overdue_view');
            Route::get('/upcoming-income','ReportController@reportUpcomingIncome')->name('report_upcoming_income');
            Route::get('/upcoming-income/view','ReportController@reportUpcomingIncomeView')->name('report_upcoming_income_view');
        });

        Route::prefix('contract')->group(function(){
            Route::get('/list','ContractController@index')->name('view_contract_list');
            Route::get('/add','ContractController@addGeneralContract')->name('add_general_contract');
            Route::post('/add','ContractController@store')->name('save_contract');
        });

        // Prefix property
        Route::prefix('property')->group(function(){
            Route::get('/','PropertyController@index')->name('show_property');
            Route::get('/add','PropertyController@create')->name('add_property');
            Route::post('/add','PropertyController@store')->name('save_new_property');
            Route::get('/{id}','PropertyController@show')->name('show_detail_property');
            Route::get('/edit/{id}','PropertyController@edit')->name('edit_property');
            Route::post('/edit/{id}','PropertyController@update')->name('update_property');

            // Expenses
            Route::get('/{id}/expenses/add','ExpensesController@index')->name('property_expenses');
            Route::post('/{id}/expenses/add','ExpensesController@store')->name('add_property_expenses');
            Route::get('/{id}/expenses/{expenses_id}/edit','ExpensesController@edit')->name('edit_property_expenses');
            Route::post('/{id}/expenses/{expenses_id}/edit','ExpensesController@update')->name('update_property_expenses');
            Route::post('/{id}/expenses/{expenses_id}/delete','ExpensesController@destroy')->name('delete_property_expenses');

            // Contract
            Route::get('/{id}/contract/add','ContractController@create')->name('add_contract');
            Route::get('/{id}/contract/{contract_id}','ContractController@show')->name('show_contract');
            Route::post('/{id}/contract/add','ContractController@store')->name('save_contract');
            Route::get('/{id}/contract/{contract_id}/generate','ContractController@generateContract')->name('generate_contract');
            // Payment
            Route::get('/{id}/payment/{payment_term_id}/add','PaymentController@create')->name('add_payment');
            Route::get('/{id}/payment/{payment_term_id}/{payment_id}','PaymentController@show')->name('show_payment');
            Route::post('/{id}/payment/{payment_term_id}/add','PaymentController@store')->name('save_payment');
        });

        Route::prefix('settings')->group(function(){
            Route::get('/contract/template','ContractController@showTemplate')->name('add_edit_template_contract');
            Route::post('/contract/template','ContractController@saveTemplate')->name('save_edit_template_contract');
        });
    });    
});