<?php

namespace Main\Component\Blog\Command;

// php cli.php username=ivan first_name=Ivan last_name=Niki
use Main\Component\Blog\Exceptions\ArgumentsException;
use Main\Component\Blog\Exceptions\CommandException;
use Main\Component\Blog\Exceptions\UserNotFoundException;

use Main\Component\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Main\Component\Blog\User;
use Main\Component\Blog\UUID;
use Main\Component\Person\Name;

class CreateUserCommand
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository) {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @throws ArgumentsException
     * @throws CommandException
     */public function handle(Arguments $arguments): void
    {
        $username = $arguments->get('username');
        // Проверяем, существует ли пользователь в репозитории
        if ($this->userExists($username)) {
            // Бросаем исключение, если пользователь уже существет
            throw new CommandException("User already exists: $username");
        }
        // Сохраняем пользователя в репозиторий
        $this->usersRepository->save(new User(
            UUID::random(),
            new Name(
                $arguments->get('first_name'),
                $arguments->get('last_name')
            ),
            $username,
        ));
    }
    private function userExists(string $username): bool
    {
        try {
            // Пытаемся получить пользователя из репозитория
            $this->usersRepository->getByUsername($username);
        } catch (UserNotFoundException) {
            return false;
        }
        return true;
    }
}