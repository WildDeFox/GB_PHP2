<?php

namespace Main\Component\Repositories;

use Main\Component\User\User;
use PDO;

class SqliteUsersRepository
{
    public function __construct(private PDO $connection){var_dump($this->connection);}

    public function save(User $user): void
    {
        // Подготавливаем запрос
        $statement = $this->connection->prepare(
            'INSERT INTO user (first_name, last_name) VALUES (:first_name, :last_name)'
        );
        // Выполняем запрос с конкретными значениями
        $statement->execute([
            ':first_name' => $user->getFirstName(),
            ':last_name' => $user->getLastName(),
        ]);
    }
}