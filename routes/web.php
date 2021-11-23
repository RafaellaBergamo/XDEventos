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

Route::get('/', function () { return redirect()->route('view-login'); });


Route::get('login', 'Auth\LoginController@viewLogin')->middleware('throttle:6')->name('view-login');



Route::group(['middleware' => 'auth.authenticate'], function() {
    Route::get('/clients', 'ClientsController@viewClients' )->name('clients');
    Route::post('/clients', 'ClientsController@getClients' )->name('get-clients');
    Route::get('/clients/new-client', 'ClientsController@newClient' )->name('new-client');
    Route::post('/clients/save-client', 'ClientsController@saveClient' )->name('save-client');
    Route::post('/clients/update-client', 'ClientsController@updateClient' )->name('save-update-client');
    Route::post('/clients/delete-client', 'ClientsController@deleteClient' )->name('delete-client');
    Route::get('/clients/update-client/{id}', 'ClientsController@viewUpdateClient' )->name('update-client');

    Route::get('/users', 'UsersController@viewUsers' )->name('users');
    Route::post('/users', 'UsersController@getUsers' )->name('get-users');
    Route::get('/users/new-user', 'UsersController@newUser' )->name('new-user');
    Route::post('/users/save-user', 'UsersController@saveUser' )->name('save-user');
    Route::post('/users/update-user', 'UsersController@updateUser' )->name('save-update-user');
    Route::post('/users/delete-user', 'UsersController@deleteUser' )->name('delete-user');
    Route::get('/users/update-user/{id}', 'UsersController@viewUpdateUser' )->name('update-user');
});


Route::group(['prefix' => 'auth'],function() {
    Route::post('login', 'Auth\LoginController@loginUser')->name('login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('register', 'Auth\CreateAccountController@newAccount');
    Route::post('register', 'Auth\CreateAccountController@createAccount')->name('create-account');
    Route::post('forgot-password', 'Auth\ForgotPasswordController@getMail');
    Route::post('send-email', 'Auth\ForgotPasswordController@sendMail');
    Route::get('change-password/{email}', 'Auth\ForgotPasswordController@viewChangePassword');
    Route::post('change-password', 'Auth\ForgotPasswordController@changePassword')->name('change-password');
    Route::post('get-cities', 'Auth\CreateAccountController@getCities');
});



