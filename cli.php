<?php


use Main\Component\Blog\Command\Arguments;
use Main\Component\Blog\Command\CreateUserCommand;
use Main\Component\Blog\Exceptions\UserNotFoundException;
use Main\Component\Blog\Repositories\UserRepository\InMemoryUsersRepository;
use Main\Component\Blog\Repositories\UserRepository\SqliteUsersRepository;
use Main\Component\Blog\User;
use Main\Component\Blog\UUID;
use Main\Component\Person\Name;


include __DIR__ . "/vendor/autoload.php";

//$name1 = new Name('Иван', 'Таранов');
//$user1 = new User(UUID::random(), $name1, 'User');

//    echo $userRepository->get(new UUID("9861b07d-4911-4d3d-8cab-31ec1b015407"));
//    echo $userRepository->getByUsername('User3');

$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');
$userRepository = new SqliteUsersRepository($connection);

$command = new CreateUserCommand($userRepository);

try {
    $command->handle(Arguments::fromArgv($argv));
} catch (Exception $e) {
    echo $e->getMessage();
}




