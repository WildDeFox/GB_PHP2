<?php

namespace Main\Component\User;

use Main\Component\UUID\UUID;

class User
{
  private string $firstName;
  private string $lastName;
  private UUID $uuid;

  public function __construct(string $firstName, string $lastName, UUID $uuid)
  {
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->uuid = $uuid;
  }

  public function __toString()
  {
    return $this->firstName . ' ' . $this->lastName;
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