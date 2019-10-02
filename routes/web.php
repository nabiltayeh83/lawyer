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


//Route::get('/home', function () {
//    return redirect('/');
//});

//Route::get('/', 'HomeController@index');

Route::get('/', function () { return view('website.index'); });


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath'
    ]
], function () {

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::post('/login', 'Auth\LoginController@login')->name('login');



    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/

    Route::get('logout', 'Auth\LoginController@logout')->name('logout');


    //Auth::routes();


    //ADMIN AUTH ///

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', function () {
            return route('/login');
        });


        Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login.form');

        Route::post('/login', 'AdminAuth\LoginController@login')->name('admin.login');

        


        Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');
      //  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.reset');
     //   Route::post('/password/email', 'AdminAuth\ForgotPasswordController@send_email')->name('admin.password.email');
    });






    Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'WEB\Admin'], function () {
        Route::get('/', function () {
            return redirect('/admin/home');
        });
        Route::post('/changeStatus/{model}', 'HomeController@changeStatus');

        Route::get('home', 'HomeController@index')->name('admin.home');

        Route::get('/admins/{id}/edit', 'AdminController@edit')->name('admins.edit');
        Route::patch('/admins/{id}', 'AdminController@update')->name('users.update');
        Route::get('/admins/{id}/edit_password', 'AdminController@edit_password')->name('admins.edit_password');
        Route::post('/admins/{id}/edit_password', 'AdminController@update_password')->name('admins.edit_password');



        if (can('admins')) {
            Route::get('/admins', 'AdminController@index')->name('admins.all');
            Route::post('/admins/changeStatus', 'AdminController@changeStatus')->name('admin_changeStatus');

            Route::delete('admins/{id}', 'AdminController@destroy')->name('admins.destroy');

            Route::post('/admins', 'AdminController@store')->name('admins.store');
            Route::get('/admins/create', 'AdminController@create')->name('admins.create');
        }


        if (can('slider')) {
            Route::post('/slider/changeStatus', 'SliderController@changeStatus');
            Route::delete('slider/image/{image_id}', 'SliderController@deleteImage');
            Route::resource('/slider', 'SliderController');
        }


        if (can('contact_us')) {
            Route::get('/contact', 'ContactController@index');
            Route::get('/viewMessage/{id}', 'ContactController@viewMessage');
            Route::delete('/contact/{id}', 'ContactController@destroy');
        }



        if (can('settings')) {
            Route::get('settings', 'SettingController@index')->name('settings.all');
            Route::post('settings', 'SettingController@update')->name('settings.update');
        }


        if(can('pages'))
        {
            Route::post('/pages/changeStatus', 'PagesController@changeStatus');
            Route::resource('/pages', 'PagesController');
        }


        if (can('users')) {

            Route::delete('users/{id}', 'UserController@destroy')->name('users.destroy');
            Route::get('/users/{id}/edit_password', 'UserController@edit_password')->name('users.edit_password');
            Route::post('/users/{id}/edit_password', 'UserController@update_password')->name('users.edit_password');
            Route::post('users_changeStatus2', 'UserController@changeStatus2');
            Route::resource('/users', 'UserController');

        }







        if (can('employees')) {
            Route::get('/employees/{id}/edit_password', 'EmployeesController@edit_password')->name('users.edit_password');
            Route::post('/employees/{id}/edit_password', 'EmployeesController@update_password')->name('users.edit_password');
            Route::get('/employees/{id}/locations', 'EmployeesController@locations');
            Route::resource('/employees', 'EmployeesController');
        }



        if (can('notifications')) {

            Route::resource('/notifications', 'NotificationMessageController');
        }



        if(can('permissions'))
        {
            Route::resource('/role', 'RoleController');
        }



        if(can('countries'))
        {
            Route::resource('/countries', 'CountryController');
        }


        if(can('categories'))
        {
            Route::resource('/categories', 'CategoryController');
        }



    });








});


