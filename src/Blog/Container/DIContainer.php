<?php

namespace Main\Component\Blog\Container;

use Main\Component\Blog\Exceptions\NotFoundException;
use ReflectionClass;

class DIContainer
{
    private array $resolvers = [];

    public function bind(string $type, $resolve): void
    {
        $this->resolvers[$type] = $resolve;
    }
    /**
     * @throws NotFoundException
     */
    public function get(string $type): object
    {
        if (array_key_exists($type, $this->resolvers)) {
            $typeToCreate = $this->resolvers[$type];

            if (is_object($typeToCreate)) {
                return $typeToCreate;
            }

            return $this->get($typeToCreate);
        }
        if (!class_exists($type)) {
            throw new NotFoundException("Cannot resolve type: $type");
        }

        $reflectionClass = new ReflectionClass($type);

        $constructor = $reflectionClass->getConstructor();

        if ($constructor === null) {
            return new $type();
        }

        $parameters = [];

        foreach ($constructor->getParameters() as $parameter) {
            $parameterType = $parameter->getType()->getName();
            $parameters[] = $this->get($parameterType);
        }

        return new $type(...$parameters);
    }

}