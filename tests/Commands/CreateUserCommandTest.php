<?php

namespace Commands;

use Main\Component\Blog\Command\Arguments;
use Main\Component\Blog\Command\CreateUserCommand;
use Main\Component\Blog\Exceptions\ArgumentsException;
use Main\Component\Blog\Exceptions\CommandException;
use Main\Component\Blog\Exceptions\InvalidArgumentExceptions;
use PHPUnit\Framework\TestCase;

class CreateUserCommandTest extends TestCase
{
    /**
     * @throws ArgumentsException
     * @throws InvalidArgumentExceptions
     */
    public function testItThrowsAnExceptionWhenUserAlreadyExists(): void
    {
        $command = new CreateUserCommand();
        $this->expectException(CommandException::class);
        $this->expectExceptionMessage("User already exists: Ivan");
        $command->handle(new Arguments(['username' => 'Ivan']));
    }
}