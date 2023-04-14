<?php

include __DIR__ . "/vendor/autoload.php";

// Создаем объект подключения к SQLite
$connection = new PDO('sqlite:' . __DIR__ . '/db.sqlite');

$userRepository = new SqliteUserRepository($connection);

$command = new CreateUserCommand($userRepository);

try {
    $command->handle(Arguments::fromArgv($argv));
} catch (Exception $e) {
    echo $e->getMessage();
}