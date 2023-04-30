<?php

namespace Main\Component\Http\Actions\Users;

use Main\Component\Blog\Exceptions\HttpException;
use Main\Component\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Main\Component\Blog\User;
use Main\Component\Blog\UUID;
use Main\Component\Http\Actions\ActionInterface;
use Main\Component\Http\ErrorResponse;
use Main\Component\Http\Request;
use Main\Component\Http\Response;
use Main\Component\Http\SuccessfulResponse;
use Main\Component\Person\Name;

class CreateUser implements ActionInterface
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function handle(Request $request): Response
    {
        try {
            $newUserUuid = UUID::random();

            $user = new User(
                $newUserUuid,
                new Name(
                    $request->jsonBodyField('first_name'),
                    $request->jsonBodyField('last_name')
                ),
                $request->jsonBodyField('username'),
            );
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        $this->usersRepository->save($user);

        return new SuccessfulResponse([
            'uuid' => (string)$newUserUuid,
        ]);
    }
}