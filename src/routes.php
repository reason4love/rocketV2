<?php

use Illuminate\Routing\Router;

Route::group([
    'prefix' => 'v1',
    'namespace' => 'Hector\V2bAdapter\Controllers',
    'middleware' => 'api',
], function (Router $router) {
    $router->group([
        'middleware' => 'rocket.auth',
    ],
        function (Router $innerRouter) {
            $innerRouter->get('userinfo', 'BaseController@userinfo');
            $innerRouter->get('logout', 'BaseController@logout');
        }
    );

    $router->post('login', 'BaseController@login');
    $router->get('init', 'BaseController@init');
    $router->get('broadcast', 'BaseController@broadcast');
    $router->get('pc-alert', 'BaseController@pcAlert');
    $router->get('pc-update', 'BaseController@pcUpdate');
    $router->get('config', 'BaseController@config');
    $router->get('anno', 'BaseController@anno');
});
