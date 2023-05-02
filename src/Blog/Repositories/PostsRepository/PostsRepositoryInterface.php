<?php

namespace Main\Component\Blog\Repositories\PostsRepository;

use Main\Component\Blog\Post;
use Main\Component\Blog\UUID;

interface PostsRepositoryInterface
{
    public function save(Post $post): void;
    public function get(UUID $uuid): Post;
}