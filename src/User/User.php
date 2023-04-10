<?php

namespace Main\Component\User;

class User
{
  private string $firstName;
  private string $lastName;

  public function __construct(string $firstName, string $lastName)
  {
    $this->firstName = $firstName;
    $this->lastName = $lastName;
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
}