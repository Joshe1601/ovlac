<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('save-file', ['as' => 'save.file', 'uses' => 'ProductController@saveFile']);

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// User as resource
$router->get('users', ['as' => 'users.index', 'uses' => 'UserController@index']);
$router->get('users/{id}', ['as' => 'users.show', 'uses' => 'UserController@show']);
$router->post('users/create', ['as' => 'users.create', 'uses' => 'UserController@create']);
$router->get('users/{id}/edit', ['as' => 'users.edit', 'uses' => 'UserController@edit']);
$router->post('users', ['as' => 'users.store', 'uses' => 'UserController@store']);
$router->put('users/{id}', ['as' => 'users.update', 'uses' => 'UserController@update']);
$router->delete('users/{id}', ['as' => 'users.destroy', 'uses' => 'UserController@destroy']);


// Register
$router->get('register', [
    'as' => 'auth.create',
    'uses' => 'AuthController@create'
]);
$router->post('register', [
    'as' => 'auth.store',
    'uses' => 'AuthController@store'
]);

// Login
$router->get('login', [
    'as' => 'auth.login',
    'uses' => 'AuthController@login'
]);
$router->post('login', [
    'as' => 'auth.verify_user',
    'uses' => 'AuthController@verifyUser'
]);

// Dashboard
$router->get('dashboard', ['middleware' => 'auth', 'as' => 'auth.dashboard', 'uses' => 'AuthController@dashboard']);

// Logout
$router->get('logout', [
    'as' => 'auth.logout',
    'uses' => 'AuthController@logout'
]);


// Reset Password
$router->get('password/forgot', [
    'as' => 'auth.forgot_password',
    'uses' => 'AuthController@forgotPassword'
]);

$router->post('password/sendEmail', [
    'as' => 'auth.send_email_link',
    'uses' => 'AuthController@sendEmailLink'
]);

$router->get('password/reset', [
    'as' => 'auth.reset_password',
    'uses' => 'AuthController@resetPassword'
]);

