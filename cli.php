<?php


use Main\Component\Blog\Exceptions\UserNotFoundException;
use Main\Component\Blog\Post;
use Main\Component\Blog\Repositories\InMemoryUsersRepository;
use Main\Component\Blog\User;
use Main\Component\Person\Name;
use Main\Component\Person\Person;


include __DIR__ . "/vendor/autoload.php";

$name1 = new Name('Иван', 'Таранов');
$user1 = new User(1, $name1, 'User');
$name2 = new Name('Никита', 'Капурин');
$user2 = new User(2, $name2, 'User2');
$userRepository = new InMemoryUsersRepository();

try {
    $userRepository->save($user1);
    $userRepository->save($user2);

    echo $userRepository->get(1);
    echo $userRepository->get(2);
} catch (UserNotFoundException | Exception $e) {
    echo $e-getMessage();
}

