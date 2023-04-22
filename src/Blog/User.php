<?php

namespace Main\Component\Blog;

use Main\Component\Person\Name;

class User
{
    private UUID $uuid;
    private Name $username; // Имя и фамилия
    private string $login;

    public function __construct(UUID $uuid, Name $username, string $login)
    {
        $this->uuid = $uuid;
        $this->username = $username;
        $this->login = $login;
    }

    /**
     * @return UUID
     */
    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    /**
     * @param UUID $uuid
     */
    public function setUuid(UUID $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return Name
     */
    public function getUsername(): Name
    {
        return $this->username;
    }

    /**
     * @param Name $username
     */
    public function setUsername(Name $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function __toString(): string
    {
        return "Юзер $this->uuid с именем $this->username и логином $this->login." . PHP_EOL;
    }
}