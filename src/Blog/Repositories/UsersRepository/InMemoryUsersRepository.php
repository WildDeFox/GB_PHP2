<?php

namespace Main\Component\Blog\Repositories\UsersRepository;

use Main\Component\Blog\Exceptions\UserNotFoundException;
use Main\Component\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Main\Component\Blog\User;
use Main\Component\Blog\UUID;

class InMemoryUsersRepository implements UsersRepositoryInterface
{
    private array $users = [];

    public function save(User $user): void
    {
        $this->users[] = $user;
    }

    /**
     * @throws UserNotFoundException
     */
    public function get(int|UUID $uuid): User
    {
        foreach ($this->users as $user) {
            if ($user->id() === $uuid) {
                return $user;
            }
        }
        throw new UserNotFoundException("User not found $uuid");
    }

}