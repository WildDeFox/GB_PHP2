<?php

use Main\Component\Commands\CreateUserCommand;
use Main\Component\Repositories\SqliteUsersRepository;
use MongoDB\Driver\Exception\CommandException;

require_once __DIR__ . '/vendor/autoload.php';

//$userRepository = new SqliteUsersRepository(
//    new PDO('sqlite:' . __DIR__ . '/db.sqlite')
//);
$userRepository = new \Main\Component\Repositories\InMemoryUsersRepository();
$command = new CreateUserCommand($userRepository);

try {
    $command->handle($argv);
} catch (CommandException $e) {
    echo "{$e->getMessage()}\n";
}
