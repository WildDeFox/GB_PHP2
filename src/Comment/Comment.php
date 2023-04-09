<?php

namespace Main\Component\Comment;

use Main\Component\Post\Post;
use Main\Component\User\User;

class Comment
{
  private int $id;
  private User $userId;
  private Post $postId;
  private string $text;

  public function __construct(int $id, User $userId, Post $postId, string $text)
  {
    $this->id = $id;
    $this->userId = $userId;
    $this->postId = $postId;
    $this->text = $text;
  }

  public function __toString()
  {
    return $this->text;
  }
}