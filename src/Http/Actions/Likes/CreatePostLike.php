<?php

namespace Main\Component\Http\Actions\Likes;

use Main\Component\Blog\Exceptions\HttpException;
use Main\Component\Blog\Exceptions\InvalidArgumentExceptions;
use Main\Component\Blog\Exceptions\LikeAlreadyExists;
use Main\Component\Blog\Like;
use Main\Component\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use Main\Component\Blog\UUID;
use Main\Component\Http\Actions\ActionInterface;
use Main\Component\Http\ErrorResponse;
use Main\Component\Http\Request;
use Main\Component\Http\Response;
use Main\Component\Http\SuccessfulResponse;

class CreatePostLike implements ActionInterface
{
    private LikesRepositoryInterface $likesRepository;

    public function __construct(LikesRepositoryInterface $likesRepository)
    {
        $this->likesRepository = $likesRepository;
    }

    /**
     * @throws InvalidArgumentExceptions
     */
    public function handle(Request $request): Response
    {
        try {
            $postUuid = $request->jsonBodyField('post_uuid');
            $userUuid = $request->jsonBodyField('user_uuid');
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        try {
            $this->likesRepository->checkUserLikeForPostExists($postUuid, $userUuid);
        } catch (LikeAlreadyExists $e) {
            return new ErrorResponse($e->getMessage());
        }

        $newLikeUuid = UUID::random();

        $like = new Like(
            uuid: $newLikeUuid,
            post_id: new UUID($postUuid),
            user_id: new UUID($userUuid),
        );

        $this->likesRepository->save($like);

        return new SuccessfulResponse(
            ['uuid' => (string)$newLikeUuid]
        );
    }
}