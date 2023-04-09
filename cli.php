<?php

use Main\Component\Comment\Comment;
use Main\Component\Post\Post;
use Main\Component\User\User;

require_once __DIR__ . '/vendor/autoload.php';

$faker = Faker\Factory::create();

$new_str = explode(' ', $faker->name(), 2);
$user = new User($new_str[0], $new_str[1], 1);

$post = new Post(1, $user, $faker->text(10), $faker->text());

$comment = new Comment(1, $user, $post, $faker->text(100));

foreach ($argv as $value) {
  if ($value === 'name') {
    echo $user;
  } elseif ($value === 'post') {
    echo $post;
  } elseif ($value === 'comment') {
    echo $comment;
  }
}