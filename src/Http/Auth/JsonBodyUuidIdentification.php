<?php

namespace Main\Component\Http\Auth;

use Main\Component\Blog\Exceptions\AuthException;
use Main\Component\Blog\Exceptions\HttpException;
use Main\Component\Blog\Exceptions\InvalidArgumentExceptions;
use Main\Component\Blog\Exceptions\UserNotFoundException;
use Main\Component\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Main\Component\Blog\User;
use Main\Component\Blog\UUID;
use Main\Component\Http\Request;

class JsonBodyUuidIdentification implements IdentificationInterface
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @throws AuthException
     */
    public function user(Request $request): User
    {
        try {
            $userUuid = new UUID($request->jsonBodyField('user_uuid'));
        } catch (HttpException | InvalidArgumentExceptions $e) {
            throw new AuthException($e->getMessage());
        }
        try {
            return $this->usersRepository->get($userUuid);
        } catch (UserNotFoundException $e) {
            throw new AuthException($e->getMessage());
        }
    }

}