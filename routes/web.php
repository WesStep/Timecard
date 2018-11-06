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

Route::get('index', [
    'uses' => 'PageController@getIndex',
    'as' => 'index'
]);

Route::get('login', [
    'uses' => 'PageController@getLogin',
    'as' => 'login'
]);

Route::get('disclaimer', [
    'uses' => 'PageController@getDisclaimer',
    'as' => 'disclaimer'
]);

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function() {

    Route::get('/', [
        'uses' => 'PageController@getDashboard',
        'as' => 'dashboard/index'
    ]);

    Route::get('archive', [
        'uses' => 'PageController@getArchive',
        'as' => 'dashboard/archive'
    ]);

    Route::get('clock', [
        'uses' => 'PageController@getClock',
        'as' => 'dashboard/clock'
    ]);

    Route::post('clockIn', [
        'uses' => 'ClockController@clockIn',
        'as' => 'dashboard/clockIn'
    ]);

    Route::post('clockOut', [
        'uses' => 'ClockController@clockOut',
        'as' => 'dashboard/clockOut'
    ]);

    Route::get('delete', [
        'uses' => 'PageController@getDelete',
        'as' => 'dashboard/delete'
    ]);

    Route::post('delete', [
        'uses' => 'EditController@deleteAccount',
        'as' => 'dashboard/delete'
    ]);

    Route::get('edit', [
        'uses' => 'PageController@getEdit',
        'as' => 'dashboard/edit'
    ]);

    Route::post('edit', [
        'uses' => 'EditController@editInfo',
        'as' => 'dashboard/edit'
    ]);

    Route::get('history', [
        'uses' => 'PageController@getHistory',
        'as' => 'dashboard/history'
    ]);

    Route::group(['middleware' => 'permitted'], function() {

        Route::get('company', [
            'uses' => 'PageController@getCompany',
            'as' => 'dashboard/company'
        ]);

        Route::post('company/add', [
            'uses' => 'CompanyController@addCompany',
            'as' => 'dashboard/company/add'
        ]);

        Route::post('company/delete', [
            'uses' => 'CompanyController@deleteCompany',
            'as' => 'dashboard/company/delete'
        ]);

        Route::post('company/edit', [
            'uses' => 'CompanyController@editCompany',
            'as' => 'dashboard/company/edit'
        ]);

        Route::get('manage', [
            'uses' => 'PageController@getManager',
            'as' => 'dashboard/manage'
        ]);

        Route::post('manage/edit/{id}', [
            'uses' => 'EditController@payrollEditAccount',
            'as' => 'dashboard/manage/edit'
        ]);

        Route::group(['prefix' => 'pay'], function () {

            Route::get('', [
                'uses' => 'PageController@getPay',
                'as' => 'dashboard/pay'
            ]);

            Route::get('show', [
                'uses' => 'PayController@getEmployee',
                'as' => 'dashboard/pay/show'
            ]);

            Route::post('', [
                'uses' => 'PayController@recordPayment',
                'as' => 'dashboard/pay'
            ]);

            Route::post('edit', [
                'uses' => 'PayController@editShift',
                'as' => 'pay/edit'
            ]);

            Route::post('delete', [
                'uses' => 'PayController@deleteShift',
                'as' => 'pay/delete'
            ]);
        });

		/**
		 * The business stats page will show the overall stats per employee
		 * for the time period specified. It will default to the previous week
		 * of information, but will also allow options to see the last week,
		 * month, quarter, or year, as well as a custom date range. The way the
		 * shifts will be displayed will be in a collapsable div so as to not
		 * mess up the look of the page. The totals of shifts worked, hours
		 * worked, and wages paid for the time period will be displayed for each
		 * employee without needing to expand anything. The business owner will
		 * be able to print the current report as it is shown on the webpage.
		 */
        
        Route::get('statistics', [
            'uses' => 'PageController@getStats',
            'as' => 'dashboard/statistics'
        ]);

        Route::get('statistics/show', [
            'uses' => 'StatsController@getStats',
            'as' => 'dashboard/statistics/show'
        ]);

    });

});

Auth::routes();

Route::get('/', [
    'uses' => 'HomeController@index',
    'as' => 'dashboard/index'
]);

Route::get('/register', [
    'uses' => 'PageController@getRegister',
    'as' => 'register',
    'middleware' => ['auth']
]);

Route::post('/login', [
    'uses' => 'SignInController@signin',
    'as' => 'auth/signin'
]);
