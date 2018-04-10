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

        Route::get('pay', [
            'uses' => 'PageController@getPay',
            'as' => 'dashboard/pay'
        ]);

        Route::get('pay/show', [
            'uses' => 'PayController@getEmployee',
            'as' => 'dashboard/pay/show'
        ]);

        Route::post('pay', [
            'uses' => 'PayController@recordPayment',
            'as' => 'dashboard/pay'
        ]);

        Route::group(['prefix' => 'statistics'], function() {

            Route::get('week', [
                'uses' => 'PageController@getStatsWeek',
                'as' => 'dashboard/statistics/week'
            ]);

            Route::get('month', [
                'uses' => 'PageController@getStatsMonth',
                'as' => 'dashboard/statistics/month'
            ]);

            Route::get('year', [
                'uses' => 'PageController@getStatsYear',
                'as' => 'dashboard/statistics/year'
            ]);

        });

        Route::get('show/{id}', [
            'uses' => 'EditController@showEmployee',
            'as' => 'dashboard/showEmployee'
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
