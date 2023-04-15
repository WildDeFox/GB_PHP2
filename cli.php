<?php

use Main\Component\Blog\Command\Arguments;
use Main\Component\Blog\Command\CreateUserCommand;
use Main\Component\Blog\Repositories\UsersRepository\SqliteUsersRepository;

include __DIR__ . "/vendor/autoload.php";

// Создаем объект подключения к SQLite
$connection = new PDO('sqlite:' . __DIR__ . '/db.sqlite');

$userRepository = new SqliteUsersRepository($connection);

$command = new CreateUserCommand($userRepository);

try {
    $command->handle(Arguments::fromArgv(['username=ivan', 'first_name=Ivan', 'last_name=Niki']));
} catch (Exception $e) {
    echo $e->getMessage();
}