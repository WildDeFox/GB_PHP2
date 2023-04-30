<?php

use Main\Component\Blog\Command\Arguments;
use Main\Component\Blog\Command\CreateUserCommand;

$container = require_once __DIR__ . '/bootstrap.php';

try {
    // При помощи контейнера создаём команду
    $command = $container->get(CreateUserCommand::class);
    $command->handle(Arguments::fromArgv($argv));
} catch (Exception $e) {

}




