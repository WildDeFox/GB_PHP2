<?php


use Main\Component\Blog\Post;
use Main\Component\Blog\User;
use Main\Component\Person\Name;
use Main\Component\Person\Person;


include __DIR__ . "/vendor/autoload.php";

$name = new Name('Nikita', 'Kapurin');
$user = new User(1, $name, 'Nikita1');
$person = new Person($name, new DateTimeImmutable());

echo $user;
echo $person;

$post = new Post(
    1,
    new Person(
        new Name('Иван', 'Никитин'),
        new DateTimeImmutable()
    ),
    'Всем привет' . PHP_EOL
);
echo $post;