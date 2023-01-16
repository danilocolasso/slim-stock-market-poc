<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\StockMarketController;
use App\Middlewares\JwtAuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // unprotected routes
    $app->group('/user', function (RouteCollectorProxy $group) {
        $group->post('/register', AuthController::class . ':register');
        $group->post('/login', AuthController::class . ':login');
    });

    // protected routes
    $app->group('', function (RouteCollectorProxy $group) {
        $group->get('/stock', StockMarketController::class . ':getData');
        $group->get('/history', StockMarketController::class . ':getHistory');
    })->addMiddleware(new JwtAuthMiddleware());
};
