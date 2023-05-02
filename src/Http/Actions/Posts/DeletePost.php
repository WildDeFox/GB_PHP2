<?php

namespace Main\Component\Http\Actions\Posts;

use Main\Component\Blog\Exceptions\HttpException;
use Main\Component\Blog\Exceptions\InvalidArgumentExceptions;
use Main\Component\Blog\Exceptions\PostNotFoundException;
use Main\Component\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Main\Component\Blog\UUID;
use Main\Component\Http\Actions\ActionInterface;
use Main\Component\Http\ErrorResponse;
use Main\Component\Http\Request;
use Main\Component\Http\Response;
use Main\Component\Http\SuccessfulResponse;

class DeletePost implements ActionInterface
{
    private PostsRepositoryInterface $postsRepository;

    public function __construct(PostsRepositoryInterface $postsRepository)
    {
        $this->postsRepository = $postsRepository;
    }

    /**
     * @throws InvalidArgumentExceptions
     */
    public function handle(Request $request): Response
    {
        try {
            $postUuid = $request->query('uuid');
            $this->postsRepository->get(new UUID($postUuid));
        } catch (PostNotFoundException | HttpException | InvalidArgumentExceptions $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $this->postsRepository->delete(new UUID($postUuid));

        return new SuccessfulResponse([
            'uuid' => $postUuid,
        ]);
    }

}