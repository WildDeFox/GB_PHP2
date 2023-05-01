<?php

use Main\Component\Blog\Command\Arguments;
use Main\Component\Blog\Command\CreateUserCommand;
use Psr\Log\LoggerInterface;

$container = require_once __DIR__ . '/bootstrap.php';
$logger = $container->get(LoggerInterface::class);
try {
    // При помощи контейнера создаём команду
    $command = $container->get(CreateUserCommand::class);
    $command->handle(Arguments::fromArgv($argv));
} catch (Exception $e) {
    $logger->error($e->getMessage(), ['exception' => $e]);
}




