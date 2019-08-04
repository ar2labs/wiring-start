<?php

declare(strict_types=1);

use App\Http\Controller\UserRestfulController;

// API RESTful v1 example
$route->group('/api/v1', function ($route) {

    $route->get('/user', [UserRestfulController::class, 'index'])
        ->setName('rest-list');

    $route->post('/user', [UserRestfulController::class, 'create'])
        ->setName('api-create');

    $route->get('/user/{id:\d+}', [UserRestfulController::class, 'read'])
        ->setName('rest-read');

    $route->put('/user/{id:\d+}', [UserRestfulController::class, 'update'])
        ->setName('api-update-replace');

    $route->patch('/user/{id:\d+}', [UserRestfulController::class, 'modify'])
        ->setName('api-update-modify');

    $route->delete('/user/{id:\d+}', [UserRestfulController::class, 'delete'])
        ->setName('api-delete');
});