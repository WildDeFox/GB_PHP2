<?php
namespace Main\Component\UUID;
class UUID
{
    // Внутри объекта мы храним UUID как строку
    public function __construct(private string $uuidString) {
        if (!uuid_is_valid($this->uuidString)) {
            throw new \http\Exception\InvalidArgumentException(
                "Malformed UUID: $this->uuidString"
            );
        }
    }

    public static function random():self
    {
        return new self(uuid_create(UUID_TYPE_RANDOM));
    }

    public function __toString():string
    {
        return $this->uuidString;
    }
}