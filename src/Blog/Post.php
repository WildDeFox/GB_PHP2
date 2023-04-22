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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setAuthor(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }


    public function __toString()
    {
        return $this->user . $this->id . ' пишет: ' . $this->text ;
    }

}