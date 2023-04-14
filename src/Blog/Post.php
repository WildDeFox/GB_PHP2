<?php
namespace Main\Component\Blog;

class Post
{
    private int $id;
    private User $user;
    private string $text;

    public function __construct(int $id, User $user, string $text)
    {
        $this->id = $id;
        $this->user = $user;
        $this->text = $text;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): Post
    {
        $this->text = $text;
        return $this;
    }

    public function __toString()
    {
        return $this->user . ' пишет: ' . $this->text . PHP_EOL;
    }
}