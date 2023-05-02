<?php

use Main\Component\Blog\Exceptions\AppExceptions;
use Main\Component\Http\Actions\Likes\CreatePostLike;
use Main\Component\Http\Actions\Posts\CreatePost;
use Main\Component\Http\Actions\Posts\DeletePost;
use Main\Component\Http\Actions\Users\CreateUser;
use Main\Component\Http\Actions\Users\FindByUsername;
use Main\Component\Http\ErrorResponse;
use Main\Component\Http\Request;

$container = require __DIR__ . '/bootstrap.php';

$request = new Request(
    $_GET,
    $_SERVER,
    file_get_contents('php://input'),
);

try {
    $path = $request->path();
} catch (HttpException) {
    (new ErrorResponse)->send();
    return;
}

try {
    $method = $request->method();
} catch (HttpException) {
    (new ErrorResponse)->send();
    return;
}

$routes = [
    'GET' => [
        '/users/show' => FindByUsername::class,
    ],
    'POST' => [
        '/users/create' => CreateUser::class,
        '/posts/create' => CreatePost::class,
        '/post-likes/create' => CreatePostLike::class
    ],
    'DELETE' => [
        '/posts' => DeletePost::class,
    ],
];

if (!array_key_exists($method, $routes)) {
    (new ErrorResponse("Route not found: $method $path"))->send();
    return;
}

if (!array_key_exists($path, $routes[$method])) {
    (new ErrorResponse("Route not found: $method $path"))->send();
    return;
}

$actionClassName = $routes[$method][$path];
$action = $container->get($actionClassName);

try {
    $response = $action->handle($request);
} catch (AppExceptions $e) {
    (new ErrorResponse($e->getMessage()))->send();
}

$response->send();