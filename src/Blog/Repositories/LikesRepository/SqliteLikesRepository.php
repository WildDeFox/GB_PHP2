<?php

namespace Main\Component\Blog\Repositories\LikesRepository;

use Main\Component\Blog\Exceptions\InvalidArgumentExceptions;
use Main\Component\Blog\Exceptions\LikeAlreadyExists;
use Main\Component\Blog\Exceptions\LikeNotFoundException;
use Main\Component\Blog\Like;
use Main\Component\Blog\UUID;
use PDO;

class SqliteLikesRepository implements LikesRepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Like $like): void
    {
        $statement = $this->connection->prepare(
            'INSERT INTO likes (uuid, user_uuid, post_uuid) 
                   VALUES (:uuid, :user_uuid, :post_uud)'
        );

        $statement->execute([
            ':uuid' => (string)$like->getUuid(),
            ':user_uuid' => (string)$like->getUserId(),
            ':post_uuid' => (string)$like->getPostId(),
        ]);
    }

    /**
     * @throws LikeNotFoundException
     * @throws InvalidArgumentExceptions
     */
    public function getByPostUuid(UUID $uuid): array
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM likes WHERE post_uuid = :uuid'
        );

        $statement->execute([
            'uuid' => (string)$uuid
        ]);

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new LikeNotFoundException(
                "No likes to post with uuid = $uuid"
            );
        }

        $likes = [];
        foreach ($result as $like) {
            $likes[] = new  Like(
                uuid: new UUID($like['uuid']),
                post_id: new UUID($like['post_uuid']),
                user_id: new UUID($like['user_uuid'])
            );
        }
        return $likes;
    }

    /**
     * @throws LikeAlreadyExists
     */
    public function checkUserLikeForPostExists($postUuid, $userUuid): void
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM likes WHERE post_uuid = :postUuid AND user_uuid = :userUuid'
        );

        $statement->execute([
            ':postUuid' => $postUuid,
            ':userUuid' => $userUuid
        ]);

        $isExisted = $statement->fetch();

        if ($isExisted) {
            throw new LikeAlreadyExists(
                "The users like for this post already exists"
            );
        }
    }

}