<?php

namespace Main\Component\Blog\Repositories\UsersRepository;

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
        // Подготавливаем запрос
        $statement = $this->connection->prepare(
             'INSERT INTO users (uuid, username, first_name, last_name)
                   VALUES (:uuid, :username, :first_name, :last_name)'
        );
        $statement->execute([
            ':uuid' => (string)$user->uuid(),
            ':username' => $user->username(),
            ':first_name' => $user->name()->first(),
            ':last_name' => $user->name()->last(),
        ]);
    }

    // Также добавим метод для получения пользователя по его UUID

    /**
     * @throws UserNotFoundException
     */
    public function get(UUID $uuid): User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE uuid = ?'
        );

        $statement->execute([(string)$uuid]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Бросаем исключение, если пользователь не найден
        if ($result === false) {
            throw new UserNotFoundException(
                "Cannot get user: $uuid"
            );
        }
        return $this->getUser($statement, $uuid);
    }

    /**
     * @throws UserNotFoundException
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
     */
    private function getUser(PDOStatement $statement, string $errorString): User
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result === false) {
            throw new UserNotFoundException(
                "Cannot find user: $errorString"
            );
        }
        return new User(
            new UUID($result['uuid']),
            new Name($result['first_name'], $result['last_name']),
            $result['username'],
        );
    }


}