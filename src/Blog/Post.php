<?php

namespace Main\Component\Blog;


use Main\Component\Person\Person;

class Post
{
    private int $id;
    private Person $author;
    private string $text;

    public function __construct(int $id, Person $author, string $text)
    {
        $this->id = $id;
        $this->author = $author;
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
     * @return Person
     */
    public function getAuthor(): Person
    {
        return $this->author;
    }

    /**
     * @param Person $author
     */
    public function setAuthor(Person $author): void
    {
        $this->author = $author;
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
        return $this->author . $this->id . ' пишет: ' . $this->text ;
    }

}