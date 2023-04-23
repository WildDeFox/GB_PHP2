<?php

namespace Main\Component\Blog\Command;

use Main\Component\Blog\Exceptions\ArgumentsException;
use Main\Component\Blog\Exceptions\CommandException;
use Main\Component\Blog\Exceptions\InvalidArgumentExceptions;
use Main\Component\Blog\Exceptions\UserNotFoundException;
use Main\Component\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Main\Component\Blog\User;
use Main\Component\Blog\UUID;
use Main\Component\Person\Name;

class CreateUserCommand
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @throws CommandException
     * @throws InvalidArgumentExceptions
     * @throws ArgumentsException
     */
    public function handle(Arguments $arguments): void
    {
        $username = $arguments->get('username');

        if ($this->userExists($username)) {
            throw new CommandException("User already exists: $username");
        }

        $this->usersRepository->save(new User(
            UUID::random(),
            new Name(
                $arguments->get('first_name'),
                $arguments->get('last_name'),
            ),
            $username,
        ));
    }

    private function userExists(string $username): bool
    {
        try {
            $this->usersRepository->getByUsername($username);
        } catch (UserNotFoundException) {
            return false;
        }
        return true;
    }
}