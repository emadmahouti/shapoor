<?php

use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();

$router->get('/', ['App\Controllers\HomeController', 'index']);

$router->group(['prefix' => 'auth'], function ($router) {
    $router->get('/login', ['App\Controllers\Message\Authenticate', 'login']);
    $router->get('/logout', ['App\Controllers\Message\Authenticate', 'logout']);
});

$router->get('/dashboard', ['App\Controllers\Message\Dashboard', 'index']);

$router->group(['prefix' => '/api'], function ($router) {


    $router->group(['prefix' => 'external/v1'], function ($router) {
        $router->post('/', ['App\Controllers\Message\Api\External\V1\Auth\Authenticate', 'login']);

        $router->group(['prefix' => '/message'], function ($router) {
            $router->get('/', ['App\Controllers\Message\Api\External\V1\Message\MessageController', 'messages']);
            $router->post('/', ['App\Controllers\Message\Api\External\V1\Message\MessageController', 'insert']);
        });

        $router->group(['prefix' => '/auth'], function ($router) {
            $router->post('/verify', ['App\Controllers\Message\Api\External\V1\Auth\Authenticate', 'verify']);
            $router->post('/login', ['App\Controllers\Message\Api\External\V1\Auth\Authenticate', 'login']);
            $router->post('/', ['App\Controllers\Message\Api\External\V1\Auth\Authenticate', 'auth']);
        });
    });

    $router->group(['prefix' => 'internal/v1'], function ($router) {

        $router->group(['prefix' => '/auth'], function ($router) {
            $router->post('/verify', ['App\Controllers\Message\Api\Internal\V1\Auth\Authenticate', 'verify']);
        });

        $router->group(['prefix' => '/message'], function ($router) {
            $router->get('/', ['App\Controllers\Message\Api\Internal\V1\Message\MessageController', 'message']);
        });
    });
});