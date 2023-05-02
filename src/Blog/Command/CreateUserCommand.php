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
use Psr\Log\LoggerInterface;

class CreateUserCommand
{
    private UsersRepositoryInterface $usersRepository;
    private LoggerInterface $logger;

    public function __construct(UsersRepositoryInterface $usersRepository, LoggerInterface $logger)
    {
        $this->usersRepository = $usersRepository;
        $this->logger = $logger;
    }

    /**
     * @throws CommandException
     * @throws InvalidArgumentExceptions
     * @throws ArgumentsException
     */
    public function handle(Arguments $arguments): void
    {
        $this->logger->info("Create user command started");
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
        $this->logger->info("User created: $username");
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