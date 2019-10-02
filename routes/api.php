<?php

use Illuminate\Http\Request;


Route::group(['middleware' => 'auth:api'], function () {



    Route::post('/editProfile', 'API\UserController@editUser');
    Route::get('/logout', 'API\UserController@logout');
    Route::post('/changePassword', 'API\UserController@changePassword');
    Route::post('/editUser','API\UserController@editUser');
    Route::get('/myNotifications', 'API\UserController@get_notifications');




    Route::post('/bookRequest','API\UserController@bookRequest');

    Route::get('/myBooking','API\UserController@myBooking');
    Route::get('/myScheduleBooking','API\UserController@myScheduleBooking');


    Route::get('/employeeHome','API\UserController@employeeHome');
    Route::get('/acceptOrder/{id}','API\UserController@acceptOrder');
    Route::get('/in_progressOrder/{id}','API\UserController@in_progressOrder');
    Route::post('/startOrder/{id}','API\UserController@startOrder');
    Route::post('/completeOrder/{id}','API\UserController@completeOrder');

    Route::post('/employeeLocation','API\UserController@employeeLocation');

    Route::post('/requestNewArea','API\AppController@requestNewArea');
    Route::post('/bookAppointment','API\AppController@bookAppointment');
     });
     
    Route::post('/rate','API\UserController@rate');
    
    Route::post('/checkPoints','API\UserController@checkPoints');
    Route::post('/checkPromo','API\UserController@checkPromo');
    Route::get('getCars', 'API\AppController@getCars');
    Route::post('checkCode', 'API\UserController@checkCode');
    Route::get('workingTimes', 'API\AppController@workTime');


    Route::get('settings', 'API\AppController@settings');
    Route::post('/login', 'API\UserController@login');
    Route::post('/signUp', 'API\UserController@signUp');

   // Route::post('/forgetpassword', 'Auth\ForgotPasswordController@forgetpassword');
    // Route::post('/forgetpassword', 'API\UserController@forgetpassword');
   // Route::get('/offers','API\productController@Offers');
    Route::post('contact', 'API\AppController@contact');
    Route::post('/forgotPassword','API\UserController@forgotPassword');
    Route::post('/resetPassword','API\UserController@resetPassword');

    //Route::get('getAds', 'API\AppController@ads');
   // Route::get('getCountry', 'API\AppController@getCountry');
    Route::get('slider', 'API\AppController@slider');

    Route::get('/search', 'API\AppController@search');

