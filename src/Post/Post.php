<?php

namespace Main\Component\Post;

use Main\Component\User\User;

class Post
{
  private int $id;
  private User $userId;
  private string $title;
  private string $text;

  public function __construct(int $id, User $userId, string $title, string $text)
  {
    $this->id = $id;
    $this->userId = $userId;
    $this->title = $title;
    $this->text = $text;
  }

  public function __toString()
  {
    return $this->title . ' >>> ' . $this->text;
  }
}