<?php

namespace Main\Component\Http;

class ErrorResponse extends Response
{
    protected const SUCCESS = false;
    private string $reason;

    // Неуспешный ответ содержит строку с причиной неуспеха,
    // по умолчанию - 'Something goes wrong'
    public function __construct(string $reason = 'Something goes wrong')
    {
        $this->reason = $reason;
    }
    // Реализация абстрактного метода
    // родительского класса
    protected function payload(): array
    {
        return ['reason' => $this->reason];
    }
}