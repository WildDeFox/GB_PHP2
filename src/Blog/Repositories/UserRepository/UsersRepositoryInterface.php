<?php
namespace Main\Component\Blog\Repositories\UserRepository;

use Main\Component\Blog\User;
use Main\Component\Blog\UUID;

interface UsersRepositoryInterface
{
    public function save(User $user): void;
    public function get(UUID $uuid): User;
    public function getByUsername(string $username): User;
}