<?php

namespace Main\Component\Blog;

use http\Exception\InvalidArgumentException;

class UUID
{
    // Внутри объекта мы храним UUID как строку
    private string $uuidString;

    public function __construct(string $uuidString) {
        $this->uuidString = $uuidString;

        // Если строка не подходит по формату -
        // бросаем исключение InvalidArgumentException
        if (!uuid_is_valid($uuidString)) {
            throw new InvalidArgumentException(
                "Malformed UUID: $this->uuidString"
            );
        }
    }

    // А так мы можем сгенерировать новый случайный UUID
    // и получить его в качестве объекта нашего класса
    public static function random():self
    {
        return new self(uuid_create(UUID_TYPE_RANDOM));
    }

    public function __toString():string
    {
        return $this->uuidString;
    }
}