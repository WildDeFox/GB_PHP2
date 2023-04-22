<?php

namespace Main\Component\Blog\Repositories;

use Main\Component\Blog\Exceptions\UserNotFoundException;
use Main\Component\Blog\User;

class InMemoryUsersRepository
{
    private array $users = [];

    public function save(User $user): void
    {
        $this->users[] = $user;
    }

    /**
     * @throws UserNotFoundException
     */
    public function get(int $id):User
    {
        foreach ($this->users as $user) {
            if ($user->getId() === $id) {
                return $user;
            }
        }
        throw new UserNotFoundException("User no found: $id");
    }

}