<?php

namespace Main\Component\User;

use Main\Component\UUID\UUID;

class User
{
  public function __construct(private string $firstName,
                              private string $lastName,
                              private UUID $uuid,
                              private string $username
  )
  {}

  public function __toString()
  {
    return $this->firstName . ' ' . $this->lastName;
  }

  public function username(): string
  {
      return $this->username;
  }

  public function getFirstName(): string
  {
      return $this->firstName;
  }

  public function getLastName(): string
  {
      return $this->lastName;
  }

  public function uuid():UUID
  {
      return $this->uuid;
  }
}