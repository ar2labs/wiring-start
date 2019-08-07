<?php

declare(strict_types=1);

use App\Http\Controller\IndexController;

$route->get('/', [IndexController::class, 'home'])
    ->setName('home');

$route->post('/contact', [IndexController::class, 'contact']);

$route->get('/user', [IndexController::class, 'user'])
    ->setName('user');

$route->get('/about', [IndexController::class, 'about'])
    ->setName('about');

$route->get('/logs', [IndexController::class, 'logs'])
    ->setName('logs');

$route->get('/book', [IndexController::class, 'book'])
    ->setName('book');

$route->get('/info', [IndexController::class, 'info'])
    ->setName('info');
