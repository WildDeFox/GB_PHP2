<?php

namespace Main\Component\User;

class User
{
  private string $firstName;
  private string $lastName;
  private int $id;

  public function __construct(string $firstName, string $lastName, int $id)
  {
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->id = $id;
  }

  public function __toString()
  {
    return $this->firstName . ' ' . $this->lastName;
  }

  public function getId() {
    return $this->id;
  }
}