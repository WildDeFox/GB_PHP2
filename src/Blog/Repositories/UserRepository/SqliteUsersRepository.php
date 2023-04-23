<?php

namespace Main\Component\Blog\Repositories\UserRepository;

use Main\Component\Blog\Exceptions\InvalidArgumentExceptions;
use Main\Component\Blog\Exceptions\UserNotFoundException;
use Main\Component\Blog\User;
use Main\Component\Blog\UUID;
use Main\Component\Person\Name;
use PDO;
use PDOStatement;

class SqliteUsersRepository implements UsersRepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user): void
    {
        $statement = $this->connection->prepare(
            'INSERT INTO users (uuid, first_name, last_name, username)
                   VALUES (:uuid, :first_name, :last_name, :username)'
        );

        $statement->execute([
            ':uuid' => $user->getUuid(),
            ':first_name' => $user->getName()->first(),
            ':last_name' =>$user->getName()->last(),
            ':username' =>$user->getUsername()
        ]);
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidArgumentExceptions
     */
    public function get(UUID $uuid): User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE uuid = :uuid'
        );

        $statement->execute([
            ':uuid' => $uuid,
        ]);

        return $this->getUser($statement, $uuid);
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidArgumentExceptions
     */
    public function getByUsername(string $username): User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE username = :username'
        );
        $statement->execute([
            ':username' => $username,
        ]);

        return $this->getUser($statement, $username);
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidArgumentExceptions
     */
    public function getUser(PDOStatement $statement, string $username): User
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result === false) {
            throw new UserNotFoundException(
                "Cannot find user: $username"
            );
        }
        return new User(
            new UUID($result['uuid']),
            new Name($result['first_name'], $result['last_name']),
            $result['username'],
        );
    }
}