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

$router->post('','NotificationController@createItem');
$router->post('/publish','NotificationController@publish');
$router->get('', 'NotificationController@index');
$router->get('/{id}', 'NotificationController@show');
$router->patch('/{id}', 'NotificationController@updateItem');
$router->delete('/{id}', 'NotificationController@removeItem');
