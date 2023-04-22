<?php


use Main\Component\Blog\Exceptions\UserNotFoundException;
use Main\Component\Blog\Repositories\UserRepository\InMemoryUsersRepository;
use Main\Component\Blog\Repositories\UserRepository\SqliteUsersRepository;
use Main\Component\Blog\User;
use Main\Component\Person\Name;


include __DIR__ . "/vendor/autoload.php";

$name1 = new Name('Иван', 'Таранов');
$user1 = new User(1, $name1, 'User');
$name2 = new Name('Никита', 'Капурин');
$user2 = new User(2, $name2, 'User2');

$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');
$userRepository = new SqliteUsersRepository($connection);

$userRepository->save($user1);
$userRepository->save($user2);


