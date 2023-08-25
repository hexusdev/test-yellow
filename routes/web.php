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

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api/user', 'middleware' => 'jwt.auth'], function() use ($router) {
    $router->post('register', 'UserController@register');
    $router->post('sign-in', 'UserController@signIn');
    $router->post('recover-password', 'UserController@recoverPassword');
    $router->get('companies', 'CompanyController@index');
    $router->post('companies', 'CompanyController@store');
});
