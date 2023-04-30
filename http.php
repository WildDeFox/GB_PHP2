<?php

use Main\Component\Blog\Exceptions\AppExceptions;
use Main\Component\Blog\Repositories\UserRepository\SqliteUsersRepository;
use Main\Component\Http\Actions\Users\CreateUser;
use Main\Component\Http\Actions\Users\FindByUsername;
use Main\Component\Http\ErrorResponse;
use Main\Component\Http\Request;

require_once __DIR__ . "/vendor/autoload.php";

$request = new Request($_GET, $_SERVER, file_get_contents('php://input'));

$routes = [
    'GET' => [
        '/users/show' => new FindByUsername(
            new SqliteUsersRepository(
                new PDO('sqlite:' . __DIR__ . '/blog.sqlite')
            )
        ),
    ],
    'POST' => [
        '/users/create' => new CreateUser(
            new SqliteUsersRepository(
                new PDO('sqlite:' . __DIR__ . '/blog.sqlite')
            )
        )
    ]

];
try {
    $path = $request->path();
}catch (HttpException) {
    (new ErrorResponse)->send();
    return;
}

try {
    $method = $request->method();
} catch (HttpException) {
    (new ErrorResponse)->send();
    return;
}

if (!array_key_exists($method, $routes)) {
    (new ErrorResponse('Not found'))->send();
    return;
}


if (!array_key_exists($path, $routes[$method])) {
    (new ErrorResponse('Not found'))->send();
    return;
}

$action = $routes[$method][$path];

try {
    $response = $action->handle($request);
} catch (AppExceptions $e) {
    (new ErrorResponse($e->getMessage()))->send();
}
$response->send();