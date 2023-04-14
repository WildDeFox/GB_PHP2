<?php

namespace Main\Component\Person;

class Name
{
    private string $firstName;
    private string $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function first():string
    {
        return $this->firstName;
    }

    public function last():string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName):void
    {
        $this->lastName = $lastName;
    }

    public function __toString(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}