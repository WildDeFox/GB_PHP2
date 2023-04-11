<?php

namespace Main\Component\Repositories;

use Main\Component\User\User;
use Main\Component\UUID\UUID;
use PDO;

class SqliteUsersRepository
{
    public function __construct(private PDO $connection){var_dump($this->connection);}

    public function save(User $user): void
    {
        // Подготавливаем запрос
        $statement = $this->connection->prepare(
            'INSERT INTO user (first_name, last_name, uuid) VALUES (:first_name, :last_name, :uuid)'
        );
        // Выполняем запрос с конкретными значениями
        $statement->execute([
            ':first_name' => $user->getFirstName(),
            ':last_name' => $user->getLastName(),
            ':uuid' => (string)$user->uuid(),
        ]);
    }

    // Также добавим метод для получения пользователя по его UUID
    public function get(UUID $uuid): User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM user WHERE uuid = ?'
        );
        $statement->execute([
            ':uuid' => (string)$uuid,
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Бросаем исключение, если пользователь не найден

        return new User(
            new UUID($result['uuid']),
            $result['first_name'], $result['last_name']
        );
    }
}