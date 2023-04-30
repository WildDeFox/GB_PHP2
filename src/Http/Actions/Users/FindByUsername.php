<?php

namespace Main\Component\Http\Actions\Users;

use Main\Component\Blog\Exceptions\HttpException;
use Main\Component\Blog\Exceptions\UserNotFoundException;
use Main\Component\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Main\Component\Http\Actions\ActionInterface;
use Main\Component\Http\ErrorResponse;
use Main\Component\Http\Request;
use Main\Component\Http\Response;
use Main\Component\Http\SuccessfulResponse;

class FindByUsername implements ActionInterface
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function handle(Request $request): Response
    {
        try {
            // Пытаемся получить искомое имя пользователя из запроса
            $username = $request->query('username');
            } catch (HttpException $e) {
            // Если в запросе нет параметра username -
            // возвращаем неуспешный ответ,
            // сообщение об ошибке берём из описания исключения
            return new ErrorResponse($e->getMessage());
        }
        try {
            // Пытаемся найти пользователя в репозитории
            $user = $this->usersRepository->getByUsername($username);
            } catch (UserNotFoundException $e) {
            // Если пользователь не найден -
            // возвращаем неуспешный ответ
            return new ErrorResponse($e->getMessage());
        }
        // Возвращаем успешный ответ
        return new SuccessfulResponse([
            'username' => $user->getUsername(),
            'name' => $user->getName()->first() . ' ' . $user->getName()->last(),
        ]);
    }
}