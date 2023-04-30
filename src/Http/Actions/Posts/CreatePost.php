<?php

namespace Main\Component\Http\Actions\Posts;

use Main\Component\Blog\Exceptions\HttpException;
use Main\Component\Blog\Exceptions\InvalidArgumentExceptions;
use Main\Component\Blog\Exceptions\UserNotFoundException;
use Main\Component\Blog\Post;
use Main\Component\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Main\Component\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Main\Component\Blog\UUID;
use Main\Component\Http\Actions\ActionInterface;
use Main\Component\Http\ErrorResponse;
use Main\Component\Http\Request;
use Main\Component\Http\Response;
use Main\Component\Http\SuccessfulResponse;

class CreatePost implements ActionInterface
{
    private UsersRepositoryInterface $usersRepository;
    private PostsRepositoryInterface $postsRepository;

    public function __construct(UsersRepositoryInterface $usersRepository, PostsRepositoryInterface $postsRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->postsRepository = $postsRepository;
    }

    public function handle(Request $request): Response
    {
        try {
            $authorUuid = new UUID($request->jsonBodyField('author_uuid'));
        } catch (HttpException | InvalidArgumentExceptions $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        try {
            $user = $this->usersRepository->get($authorUuid);
        } catch (UserNotFoundException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $newPostUuid = UUID::random();

        try {
            $post = new Post(
                $newPostUuid,
                $user,
                $request->jsonBodyField('title'),
                $request->jsonBodyField('text'),
            );
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $this->postsRepository->save($post);

        return new SuccessfulResponse([
            'uuid' => (string)$newPostUuid,
        ]);
    }

}