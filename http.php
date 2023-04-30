<?php

use Main\Component\Blog\Exceptions\AppExceptions;
use Main\Component\Blog\Repositories\UserRepository\SqliteUsersRepository;
use Main\Component\Http\Actions\Users\FindByUsername;
use Main\Component\Http\ErrorResponse;
use Main\Component\Http\Request;

require_once __DIR__ . "/vendor/autoload.php";

$request = new Request($_GET, $_SERVER);

$routes = [
    // Создаем действие, соответствующее пути /users/show
    '/users/show' => new FindByUsername(
        // Действию нужен репозиторий
        new SqliteUsersRepository(
            new PDO('sqlite:' . __DIR__ . '/blog.sqlite')
        )
    ),
];
try {
    // Пытаемся получить путь из запроса
    $path = $request->path();
}catch (HttpException) {
    (new ErrorResponse)->send();
    return;
}

if (!array_key_exists($path, $routes)) {
    (new ErrorResponse('Not found'))->send();
    return;
}

$action = $routes[$path];

try {
    $response = $action->handle($request);
} catch (AppExceptions $e) {
    (new ErrorResponse($e->getMessage()))->send();
}

$response->send();

