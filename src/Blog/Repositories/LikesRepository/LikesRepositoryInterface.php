<?php

namespace Main\Component\Blog\Repositories\LikesRepository;

use Main\Component\Blog\Like;
use Main\Component\Blog\UUID;

interface LikesRepositoryInterface
{
    public function save(Like $like): void;
    public function getByPostUuid(UUID $uuid): array;
}