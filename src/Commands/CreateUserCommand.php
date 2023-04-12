<?php

namespace Main\Component\Commands;

use Main\Component\Repositories\UsersRepositoryInterface;
use Main\Component\User\User;
use Main\Component\UUID\UUID;
use MongoDB\Driver\Exception\CommandException;

class CreateUserCommand
{
    private UsersRepositoryInterface $usersRepository;
    public function __construct (UsersRepositoryInterface $usersRepository){
        $this->usersRepository = $usersRepository;
    }

    public function handle(array $rawInput): void
    {
        $input = $this->parseRawInput($rawInput);

        $username = $input['username'];

        if ($this->userExists($username)) {
            throw new CommandException("User already exists: $username");
        }
        $this->usersRepository->save(new User(
            UUID::random(),
            $username,
            $input['first_name'],
            $input['last_name']
        ));
    }

    private function parseRawInput(array $rawInput): array
    {
        $input = [];

        foreach ($rawInput as $argument) {
            $parts = explode('=', $argument);
            if (count($parts) !== 2) {
                continue;
            }
            $input[$parts[0]] = $parts[1];
        }
        foreach (['username', 'first_name', 'last_name'] as $argument) {
            if (!array_key_exists($argument, $input)) {
                throw new CommandException(
                    "No required argument provided: $argument"
                );
            }

            if (empty($input[$argument])) {
                throw new CommandException(
                    "Empty argument provided: $argument"
                );
            }
        }
        return $input;
    }

    private function userExists(string $username):bool
    {
//        try {
            $this->usersRepository->getByUsername($username);
//        } catch {
//            return false;
//        }
        return true;
    }
}