<?php

declare(strict_types=1);

use Controllers\UserController;
use Lib\Router;
use function Lib\responseJson;

return static function (Router $router): void {
    $router->get('/api/health', static function (): void {
        responseJson(data: ['ok' => true], message: 'API is running');
    });

    $router->post('/api/users', [UserController::class, 'register']);
};
