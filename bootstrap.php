<?php

use Main\Component\Blog\Container\DIContainer;
use Main\Component\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use Main\Component\Blog\Repositories\LikesRepository\SqliteLikesRepository;
use Main\Component\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Main\Component\Blog\Repositories\PostsRepository\SqlitePostsRepository;
use Main\Component\Blog\Repositories\UserRepository\SqliteUsersRepository;
use Main\Component\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Main\Component\Http\Auth\IdentificationInterface;
use Main\Component\Http\Auth\JsonBodyUsernameIdentification;
use Main\Component\Http\Auth\JsonBodyUuidIdentification;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

require_once __DIR__ . '/vendor/autoload.php';

$container = new DIContainer();

$container->bind(
    PDO::class,
    new PDO('sqlite:' . __DIR__ . '/blog.sqlite')
);

$container->bind(
    LoggerInterface::class,
    (new Logger('blog'))->pushHandler(new StreamHandler(
        __DIR__ . '/logs/blog.log'
    ))
);

$container->bind(
    LikesRepositoryInterface::class,
    SqliteLikesRepository::class
);

$container->bind(
    IdentificationInterface::class,
    JsonBodyUsernameIdentification::class
);

$container->bind(
    PostsRepositoryInterface::class,
    SqlitePostsRepository::class
);

$container->bind(
    UsersRepositoryInterface::class,
    SqliteUsersRepository::class,
);

return $container;