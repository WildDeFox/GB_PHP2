<?php
namespace Main\Component\Repositories;

use Main\Component\User\User;
use Main\Component\UUID\UUID;

interface UsersRepositoryInterface
{
    public function save(User $user): void;
    public function get(UUID $uuid): User;

    public function getByUsername(string $username): User;
}