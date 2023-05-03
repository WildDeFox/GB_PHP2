<?php

namespace Main\Component\Http\Auth;

use Main\Component\Blog\Exceptions\AuthException;
use Main\Component\Blog\Exceptions\HttpException;
use Main\Component\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Main\Component\Blog\User;
use Main\Component\Http\Request;

class JsonBodyUsernameIdentification implements IdentificationInterface
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
            $username = $request->jsonBodyField('username');
        } catch (HttpException $e) {
            throw new AuthException($e->getMessage());
        }
        try {
            return $this->usersRepository->getByUsername($username);
        } catch (HttpException $e) {
            throw new AuthException($e->getMessage());
        }
    }
}