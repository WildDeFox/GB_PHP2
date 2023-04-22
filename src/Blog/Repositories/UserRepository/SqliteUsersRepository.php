<?php

namespace Main\Component\Blog\Repositories\UserRepository;

use Main\Component\Blog\User;
use PDO;

class SqliteUsersRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user): void
    {
        $statement = $this->connection->prepare(
            'INSERT INTO users (first_name, last_name) VALUES (:first_name, :last_name)'
        );

        $statement->execute([
            ':first_name' => $user->getUsername()->first(),
            ':last_name' =>$user->getUsername()->last()
        ]);
    }

}